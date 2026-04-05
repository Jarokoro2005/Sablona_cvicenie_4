<?php
$menu = getMenuData("header");
?>

<header class="container main-header">
    <div class="logo-holder">
        <a href="<?php echo $menu["domov"]["path"]; ?>">
            <img src="img/logo.png" height="40">
        </a>
    </div>
    <nav class="main-nav">
        <ul class="main-menu" id="main-menu"> <!-- Opraveno: odstraněn "container" z id -->
            <?php printMenu($menu); ?>
        </ul>
        <a class="hamburger" id="hamburger">
            <i class="fa fa-bars"></i>
        </a>
    </nav>
</header>