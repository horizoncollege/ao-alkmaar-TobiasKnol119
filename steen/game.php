<?php

session_start();

// Functie die bepaalt wie er wint
function bepaalWinnaar($speler1, $speler2)
{
    if ($speler1 == $speler2) {
        return "Gelijkspel!";
    } elseif ($speler1 == "steen" && $speler2 == "schaar") {
        return "Speler 1 wint!";
    } elseif ($speler1 == "papier" && $speler2 == "steen") {
        return "Speler 1 wint!";
    } elseif ($speler1 == "schaar" && $speler2 == "papier") {
        return "Speler 1 wint!";
    } else {
        return "Speler 2 wint!";
    }
}

// Controleer of er op de knop is geklikt
if (isset($_POST['submit'])) {
    $speler = $_POST['speler'];
    if ($speler) {
        // Controleer of de speler al een keuze heeft gemaakt
        if (isset($_SESSION['keuze'])) {
            $resultaat = bepaalWinnaar($speler, $_SESSION['keuze']);
            echo "Je koos: " . $speler . "<br>";
            echo "De tegenstander koos: " . $_SESSION['keuze'] . "<br>";
            echo $resultaat;
            // Reset de keuze voor de volgende ronde
            unset($_SESSION['keuze']);
        } else {
            // Sla de keuze van de speler op in de sessievariabele
            $_SESSION['keuze'] = $speler;
            echo "Wacht op de keuze van de tegenstander...";
        }
    } else {
        echo "Maak een keuze.";
    }
}

?>

<form method="post" action="game.php">
    <h2>Kies:</h2>
    <input type="radio" name="speler" value="steen">Steen
    <input type="radio" name="speler" value="papier">Papier
    <input type="radio" name="speler" value="schaar">Schaar

    <br><br>
    <input type="submit" name="submit" value="Speel">
</form>
