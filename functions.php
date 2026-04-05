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

function validateMenuType(string $type): bool
{
    $menuTypes = ["header", "footer"];
    return in_array($type, $menuTypes);
}

function getMenuData(string $type): array
{
    if (!validateMenuType($type)) {
        return [];
    }

    $menu = [];

    if ($type == "header") {
        $menu = [
            "domov" => [
                "name" => "Domov",
                "path" => "index.php"
            ],
            "portfolio" => [
                "name" => "Portfólio",
                "path" => "portfolio.php"
            ],
            "qna" => [
                "name" => "Q&A",
                "path" => "qna.php"
            ],
            "kontakt" => [
                "name" => "Kontakt",
                "path" => "kontakt.php"
            ]
        ];
    }

    if ($type == "footer") {
        $menu = [
            "domov" => [
                "name" => "Domov",
                "path" => "index.php"
            ],
            "kontakt" => [
                "name" => "Kontakt",
                "path" => "kontakt.php"
            ]
        ];
    }

    return $menu;
}

function printMenu(array $menu): void
{
    foreach ($menu as $menuItem) {
        echo '<li><a href="' . $menuItem["path"] . '">' . $menuItem["name"] . '</a></li>';
    }
}

function getCSS(): void
{
    $jsonStr = file_get_contents("data/datas.json");
    $data = json_decode($jsonStr, true);

    $stranka = basename($_SERVER['REQUEST_URI']);
    $stranka = explode(".", $stranka)[0];

    if (isset($data["stranky"][$stranka])) {
        $suboryCSS = $data["stranky"][$stranka];

        foreach ($suboryCSS as $subor) {
            echo "<link rel='stylesheet' href='$subor'>";
        }
    }
}

function preparePortfolio(int $numberOfRows = 2, int $numberOfCols = 4): array
{
    $portfolio = [];
    $colIndex = 1;

    for ($i = 1; $i <= $numberOfRows; $i++) {
        for ($j = 1; $j <= $numberOfCols; $j++) {
            $portfolio[$i][$j] = $colIndex;
            $colIndex++;
        }
    }

    return $portfolio;
}

function finishPortfolio(): void
{
    $portfolio = preparePortfolio();
    $portfolioData = getPortfolioData();

    foreach ($portfolio as $row) {
        echo '<div class="row">';
        foreach ($row as $index) {
            $title = $portfolioData[$index]["title"];
            $url = $portfolioData[$index]["url"];

            echo '<div class="col-25 portfolio text-center" id="portfolio-' . $index . '">
                    <a href="' . $url . '" target="_blank" style="color: yellow; text-decoration: none;">' . $title . '</a>
                  </div>';
        }
        echo '</div>';
    }
}


function getPortfolioData(): array
{
    $jsonStr = file_get_contents("data/datas.json");
    $data = json_decode($jsonStr, true);

    return $data["portfolio"];
}
?>