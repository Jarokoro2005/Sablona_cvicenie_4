<?php

/**
 * Konfigurácia databázového pripojenia
 * 
 * Namespace: App\Config
 * Táto trieda obsahuje všetky potrebné informácie
 * na pripojenie sa k databáze a vrátenie inštancie PDO
 */

namespace App\Config;

/**
 * Trieda DatabaseConfig
 * Vracia konfigurovanú inštanciu PDO pripojenia
 */
class DatabaseConfig
{
    // Databázové nastavenia
    private static $host = "localhost";
    private static $dbname = "formular";
    private static $port = 3306;
    private static $username = "root";
    private static $password = "";

    /**
     * Statická metóda na vrátenie PDO pripojenia
     * 
     * @return \PDO Pripojenie k databáze
     * @throws \PDOException Ak sa nepodari pripojenie
     */
    public static function getConnection(): \PDO
    {
        try {
            $options = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            );

            $pdo = new \PDO(
                'mysql:host=' . self::$host . ';dbname=' . self::$dbname . ';port=' . self::$port,
                self::$username,
                self::$password,
                $options
            );

            return $pdo;
        } catch (\PDOException $e) {
            throw new \PDOException("Chyba pripojenia k databáze: " . $e->getMessage());
        }
    }

    /**
     * Metóda na nastavenie vlastných parametrov pripojenia
     * (Voliteľne - pre testovacie účely)
     */
    public static function setConfig($host, $dbname, $port, $username, $password): void
    {
        self::$host = $host;
        self::$dbname = $dbname;
        self::$port = $port;
        self::$username = $username;
        self::$password = $password;
    }
}
?>