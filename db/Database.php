<?php

/**
 * Abstraktna trieda Database
 * 
 * Namespace: App\Database
 * Táto trieda slúži ako základná trieda pre všetky triedy
 * pracujúce s databázou. Poskytuje základné funkcionality
 * na prácu s PDO pripojením a chybovými hláseniami.
 */

namespace App\Database;

use App\Config\DatabaseConfig;
use PDO;
use PDOException;

/**
 * Abstraktna trieda Database
 * 
 * Poskytuje:
 * - Pripojenie k databáze
 * - Metódy na vykonávanie dotazov
 * - Spracovanie chýb pri práci s databázou
 */
abstract class Database
{
    /**
     * @var PDO Inštancia PDO pripojenia
     */
    protected $conn;

    /**
     * @var string Chybové hlásenie
     */
    protected $lastError;

    /**
     * Konštruktor triedy
     * Inicializuje databázové pripojenie
     */
    public function __construct()
    {
        try {
            $this->conn = DatabaseConfig::getConnection();
        } catch (PDOException $e) {
            $this->lastError = "Chyba pri inicializácii databázy: " . $e->getMessage();
            throw $e;
        }
    }

    /**
     * Metóda na vrátenie poslednej chyby
     * 
     * @return string Posledná chyba
     */
    public function getLastError(): string
    {
        return $this->lastError ?? "Žiadna chyba";
    }

    /**
     * Metóda na vykonávanie SELECT dotazu
     * 
     * @param string $sql SQL dotaz
     * @param array $params Parametre pre pripravenú správu
     * @return array Pole výsledkov
     */
    protected function executeSelect(string $sql, array $params = []): array
    {
        try {
            $statement = $this->conn->prepare($sql);
            $statement->execute($params);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            $this->lastError = "Chyba pri SELECT dotaze: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Metóda na vykonávanie INSERT, UPDATE, DELETE dotazov
     * 
     * @param string $sql SQL dotaz
     * @param array $params Parametre pre pripravenú správu
     * @return bool Úspešnosť operácie
     */
    protected function executeModify(string $sql, array $params = []): bool
    {
        try {
            $statement = $this->conn->prepare($sql);
            return $statement->execute($params);
        } catch (PDOException $e) {
            $this->lastError = "Chyba pri modifikácii údajov: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Metóda na vrátenie počtu riadkov ovplyvnených posledným dotazom
     * 
     * @param string $sql SQL dotaz
     * @param array $params Parametre
     * @return int Počet riadkov
     */
    protected function executeCount(string $sql, array $params = []): int
    {
        try {
            $statement = $this->conn->prepare($sql);
            $statement->execute($params);
            $result = $statement->fetch();
            return $result['pocet'] ?? 0;
        } catch (PDOException $e) {
            $this->lastError = "Chyba pri počítaní riadkov: " . $e->getMessage();
            return 0;
        }
    }

    /**
     * Metóda na zatvorenie databázového pripojenia
     */
    public function closeConnection(): void
    {
        $this->conn = null;
    }

    /**
     * Deštrukctor - automaticky sa volá pri zničení objektu
     */
    public function __destruct()
    {
        $this->closeConnection();
    }
}
?>