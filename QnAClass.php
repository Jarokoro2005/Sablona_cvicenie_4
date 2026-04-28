<?php

/**
 * Trieda QnAClass na správu otázok a odpovedí
 * 
 * Táto trieda slúži na:
 * - Čítanie otázok a odpovedí z databázy
 * - Vkladanie nových otázok a odpovedí s kontrolou duplikátov
 * - Zobrazenie otázok a odpovedí v HTML formáte
 */
class QnAClass
{
    // Privátna vlastnosť na uloženie databázového pripojenia
    private $conn;

    /**
     * Konštruktor triedy
     * Vytvorí pripojenie k databáze
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Metóda na vytvorenie pripojenia k databáze
     * Využíva PDO a databázu 'formular'
     */
    private function connect()
    {
        $host = "localhost";
        $dbname = "formular";
        $port = 3306;
        $username = "root";
        $password = "";

        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );

        try {
            $this->conn = new PDO(
                'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $port,
                $username,
                $password,
                $options
            );
        } catch (PDOException $e) {
            die("Chyba pripojenia k databáze: " . $e->getMessage());
        }
    }

    /**
     * Metóda na čítanie všetkých otázok a odpovedí z databázy
     * 
     * @return array Pole s otázkami a odpoveďami
     */
    public function getQnA()
    {
        try {
            $sql = "SELECT id, otazka, odpoved FROM qna ORDER BY id ASC";
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo "Chyba pri čítaní údajov: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Metóda na vloženie novej otázky a odpovede s kontrolou duplikátov
     * 
     * @param string $otazka - Otázka
     * @param string $odpoved - Odpoveď
     * @return boolean true ak bola úspešne vložená, false v prípade chyby alebo duplikátu
     */
    public function insertQnA($otazka, $odpoved)
    {
        // Kontrola či otázka a odpoveď prázdne
        if (empty(trim($otazka)) || empty(trim($odpoved))) {
            return false;
        }

        // Kontrola duplikátov - či už existuje taká istá otázka a odpoveď
        try {
            $sql = "SELECT COUNT(*) as pocet FROM qna WHERE otazka = :otazka AND odpoved = :odpoved";
            $statement = $this->conn->prepare($sql);
            $statement->execute([
                ':otazka' => trim($otazka),
                ':odpoved' => trim($odpoved)
            ]);

            $result = $statement->fetch();

            // Ak existuje duplikát, vráť false
            if ($result['pocet'] > 0) {
                return false;
            }

            // Vloženie novej otázky a odpovede
            $sql = "INSERT INTO qna (otazka, odpoved) VALUES (:otazka, :odpoved)";
            $statement = $this->conn->prepare($sql);

            return $statement->execute([
                ':otazka' => trim($otazka),
                ':odpoved' => trim($odpoved)
            ]);
        } catch (PDOException $e) {
            echo "Chyba pri vkladaní údajov: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Metóda na zobrazenie otázok a odpovedí v HTML formáte
     * Vráti HTML markup pre accordion
     * 
     * @return string HTML markup
     */
    public function displayQnA()
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
     * Metóda na zatvorenie databázového pripojenia
     */
    public function closeConnection()
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