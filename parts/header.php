<?php
include_once("functions.php");

// Ak je GET parameter theme, nastav cookie a presmeruj
if (isset($_GET['theme'])) {
    setcookie('theme', $_GET['theme'], time() + (365 * 24 * 60 * 60), '/');
    $_COOKIE['theme'] = $_GET['theme'];
}

// Čítaj tému z cookies
$theme = $_COOKIE['theme'] ?? 'light';
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

<body class="<?= $theme === 'dark' ? 'dark-theme' : 'light-theme' ?>">

    <header class="container main-header">

    </header>