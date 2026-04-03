<?php
function pridajPozdrav()
{
    $hour = (int) date('H');

    if ($hour < 12) {
        echo "<h3>Dobré ráno</h3>";
    } elseif ($hour < 18) {
        echo "<h3>Dobrý deň</h3>";
    } else {
        echo "<h3>Dobrý večer</h3>";
    }
    echo "Dnes je " . date("d.m.Y") . "<br>";
    echo "Aktuálny čas je " . date("H:i:s") . "<br>";
}

function generateSlides($dir)
{
    $files = glob($dir . "/*.jpg");
    $json = file_get_contents("data/datas.json");
    $data = json_decode($json, true);
    $text = $data["text_banner"];

    foreach ($files as $file) {
        echo '<div class="slide fade">';
        echo '<img src="' . $file . '">';
        echo '<div class="slide-text">';
        echo $text[basename($file)];
        echo '</div>';
        echo '</div>';
    }
}

function insertQnA()
{
    $json = file_get_contents("data/datas.json");
    $data = json_decode($json, true);
    $otazky = $data["otazky"];
    $odpovede = $data["odpovede"];

    echo '<section class="container">';

    for ($i = 0; $i < count($otazky); $i++) {
        echo '<div class="accordion">
                <div class="question">' . $otazky[$i] . '</div>
                <div class="answer">' . $odpovede[$i] . '</div>
              </div>';
    }

    echo '</section>';
}

function generatePortfolio()
{
    $json = file_get_contents("data/datas.json");
    $data = json_decode($json, true);
    $projects = $data["projects"];

    echo '<section class="container">';

    $chunks = array_chunk($projects, 4);

    foreach ($chunks as $rowIndex => $row) {
        echo '<div class="row">';

        foreach ($row as $index => $project) {
            $id = $rowIndex * 4 + $index + 1;

            echo "
                <div class='col-25 portfolio text-white text-center' id='portfolio-$id'>
                    $project
                </div>
            ";
        }

        echo '</div>';
    }

    echo '</section>';
}

?>