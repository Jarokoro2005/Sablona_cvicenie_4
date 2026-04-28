-- SQL skript na vytvorenie tabuľky QnA v databáze 'formular'
-- Spustite tento skript vo svojej MySQL databáze

CREATE TABLE IF NOT EXISTS qna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    otazka VARCHAR(500) NOT NULL,
    odpoved TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_qna (otazka, odpoved)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Príklad vloženia testovacích údajov:
INSERT INTO qna (otazka, odpoved) VALUES 
('Čo je to HTML?', 'HTML je značkovací jazyk na tvorbu webových stránok.'),
('Čo je to CSS?', 'CSS je jazyk na štýlovanie webových stránok.'),
('Čo je to PHP?', 'PHP je serverový programovací jazyk na vytvorenie dynamických webových stránok.');
