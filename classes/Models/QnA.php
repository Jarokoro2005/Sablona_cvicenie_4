<?php

/**
 * Trieda QnA na správu otázok a odpovedí
 * 
 * Namespace: App\Models
 * Táto trieda rozširuje abstraktnú triedu Database
 * a slúži na:
 * - Čítanie otázok a odpovedí z databázy
 * - Vkladanie nových otázok a odpovedí s kontrolou duplikátov
 * - Zobrazenie otázok a odpovedí v HTML formáte
 */

namespace App\Models;

use App\Database\Database;

/**
 * Trieda QnA
 * Extends: Database
 * 
 * Poskytuje operácie s otázkami a odpoveďami
 */
class QnA extends Database
{
    /**
     * Tabuľka v databáze
     */
    private const TABLE = 'qna';

    /**
     * Konštruktor triedy
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Metóda na čítanie všetkých otázok a odpovedí z databázy
     * 
     * @return array Pole s otázkami a odpoveďami
     */
    public function getQnA(): array
    {
        $sql = "SELECT id, otazka, odpoved FROM " . self::TABLE . " ORDER BY id ASC";
        return $this->executeSelect($sql);
    }

    /**
     * Metóda na vloženie novej otázky a odpovede s kontrolou duplikátov
     * 
     * @param string $otazka - Otázka
     * @param string $odpoved - Odpoveď
     * @return bool true ak bola úspešne vložená, false v prípade chyby alebo duplikátu
     */
    public function insertQnA(string $otazka, string $odpoved): bool
    {
        // Kontrola či otázka a odpoveď prázdne
        if (empty(trim($otazka)) || empty(trim($odpoved))) {
            $this->lastError = "Otázka a odpoveď nesmú byť prázdne!";
            return false;
        }

        // Kontrola duplikátov - či už existuje taká istá otázka a odpoveď
        $sqlCheck = "SELECT COUNT(*) as pocet FROM " . self::TABLE . " WHERE otazka = :otazka AND odpoved = :odpoved";
        $count = $this->executeCount($sqlCheck, [
            ':otazka' => trim($otazka),
            ':odpoved' => trim($odpoved)
        ]);

        // Ak existuje duplikát, vráť false
        if ($count > 0) {
            $this->lastError = "Táto otázka a odpoveď už existujú v databáze!";
            return false;
        }

        // Vloženie novej otázky a odpovede
        $sql = "INSERT INTO " . self::TABLE . " (otazka, odpoved) VALUES (:otazka, :odpoved)";

        $result = $this->executeModify($sql, [
            ':otazka' => trim($otazka),
            ':odpoved' => trim($odpoved)
        ]);

        if (!$result) {
            $this->lastError = "Chyba pri vkladaní novej otázky a odpovede!";
        }

        return $result;
    }

    /**
     * Metóda na zobrazenie otázok a odpovedí v HTML formáte
     * Vráti HTML markup pre accordion
     * 
     * @return string HTML markup
     */
    public function displayQnA(): string
    {
        $qnaData = $this->getQnA();

        if (empty($qnaData)) {
            return '<section class="container"><p class="text-center">Zatiaľ nie sú dostupné žiadne otázky a odpovede.</p></section>';
        }

        $html = '<section class="container">';

        foreach ($qnaData as $item) {
            $html .= '<div class="accordion">
                        <div class="question">' . htmlspecialchars($item['otazka']) . '</div>
                        <div class="answer">' . htmlspecialchars($item['odpoved']) . '</div>
                      </div>';
        }

        $html .= '</section>';

        return $html;
    }

    /**
     * Metóda na zistenie, či QnA položka existuje
     * 
     * @param int $id ID položky
     * @return bool true ak existuje, false ak neexistuje
     */
    public function existsQnA(int $id): bool
    {
        $sql = "SELECT COUNT(*) as pocet FROM " . self::TABLE . " WHERE id = :id";
        return $this->executeCount($sql, [':id' => $id]) > 0;
    }

    /**
     * Metóda na zmazanie QnA položky
     * 
     * @param int $id ID položky
     * @return bool Úspešnosť operácie
     */
    public function deleteQnA(int $id): bool
    {
        if (!$this->existsQnA($id)) {
            $this->lastError = "QnA položka s ID $id neexistuje!";
            return false;
        }

        $sql = "DELETE FROM " . self::TABLE . " WHERE id = :id";
        return $this->executeModify($sql, [':id' => $id]);
    }
}
?>