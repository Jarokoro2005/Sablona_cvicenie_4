<?php
include_once "functions.php";

$menu = getMenuData(type: "header");

// Čítaj tému z cookies
$theme = $_COOKIE['theme'] ?? 'light';

?>
<header class="container main-header">
    <div class="logo-holder">
        <a href="<?php echo $menu['domov']['path']; ?>">

            <img alt="img" src="img/logo.png" height="40">
        </a>
    </div>
    <nav class="main-nav">
        <ul class="main-menu" id="main-menu container">
            <a href="?theme=<?php echo $theme === "dark" ? "light" : "dark"; ?>">Dark/light theme</a>
            <?php printMenu($menu); ?>
        </ul>
        <a class="hamburger" id="hamburger">
            <i class="fa fa-bars"></i>
        </a>
    </nav>
</header>