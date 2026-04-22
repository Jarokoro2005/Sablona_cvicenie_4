<?php
include_once("functions.php");

// Získanie témy z URL (?theme=dark alebo ?theme=light)
$theme = $_GET["theme"] ?? "light";
?>

<!doctype html>
<html lang="sk">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Moja stránka</title>

    <?php echo getCSS(); ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>

    <header class="container main-header <?= $theme === 'dark' ? 'dark-theme' : 'light-theme' ?>">

        <!-- Prepínač témy -->
        <a href="<?= $theme === 'dark' ? '?theme=light' : '?theme=dark' ?>">
            Zmena témy
        </a>

    </header>