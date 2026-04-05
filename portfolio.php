<?php
include_once("functions.php");
?>

<?php require("parts/header.php"); ?>
<?php require("parts/nav.php"); ?>

<main class="container">
    <section>
        <div class="row">
            <div class="col-100 text-center">
                <h1>Portfólio</h1>
            </div>
        </div>

        <?php finishPortfolio(); ?>
    </section>
</main>

<?php include("parts/footer.php"); ?>

<script src="js/menu.js"></script>
</body>

</html>