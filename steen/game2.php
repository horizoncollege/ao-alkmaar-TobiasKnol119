<a href="gamecomputer.php"><input type="submit" value="terug"></a>
<?php

session_start();

// Functie die bepaalt wie er wint
function bepaalWinnaar($speler1, $computer)
{
    if ($speler1 == $computer) {
        return "Gelijkspel!";
    } elseif ($speler1 == "steen" && $computer == "schaar") {
        return "Speler 1 wint!";
    } elseif ($speler1 == "papier" && $computer == "steen") {
        return "Speler 1 wint!";
    } elseif ($speler1 == "schaar" && $computer == "papier") {
        return "Speler 1 wint!";
    } else {
        return "computer wint!";
    }
}



if (isset($_GET['speler'])) {
    $speler1 = $_GET['speler'];
    $computer = array("steen", "papier", "schaar")[rand(0, 2)]; // Bepaal keuze van de computer
    $resultaat = bepaalWinnaar($speler1, $computer);
    echo "Je koos: " . $speler1 . "<br>";
    echo "De computer koos: " . $computer . "<br>";
    echo $resultaat;
    // Reset de keuze voor de volgende ronde
    unset($_SESSION['keuze']);
}



?>