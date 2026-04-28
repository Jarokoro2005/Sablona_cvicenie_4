<?php
include_once("functions.php");
?>

<?php require("parts/header.php"); ?>
<?php require("parts/nav.php"); ?>


<main>
  <main>
    <section class="banner">
      <div class="container text-white">
        <h1>Q&A</h1>
      </div>
    </section>
    <section class="container">
      <div class="row">
        <div class="col-100 text-center">
          <p><strong><em>Elit culpa id mollit irure sit. Ex ut et ea esse culpa officia ea incididunt elit velit veniam
                qui. Mollit deserunt culpa incididunt laborum commodo in culpa.</em></strong></p>
        </div>
      </div>
    </section>
    <section class="container">
      <?php
      // Načítanie autoloderu a triedy QnA s detekciou chýb
      require_once "Autoloader.php";

      use App\Models\QnA;

      try {
        $qna = new QnA();
        echo $qna->displayQnA();
      } catch (Exception $e) {
        echo '<p class="text-center" style="color: red;">Chyba pri načítaní otázok a odpovedí: ' . htmlspecialchars($e->getMessage()) . '</p>';
      }
      ?>
    </section>

    </section>
    </div>
  </main>

  <?php include("parts/footer.php"); ?>

  <script src="js/accordion.js"></script>
  <script src="js/menu.js"></script>
  </body>

  </html>