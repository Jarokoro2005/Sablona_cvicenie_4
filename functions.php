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

?>