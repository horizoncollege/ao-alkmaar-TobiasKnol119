<?php

session_start();

$letters = "abcdefghijklmnopqrstuvwxyz";
$WON = false;

$guess = "HANGMAN";
$maxLetters = strlen($guess) - 1;
$responses = ["H", "G", "A"];

$bodyParts = ["nohead", "head", "body", "hand", "hands", "leg", "legs"];

$words = [
    "programmeren", "computer", "galgje", "toetsenbord", "auto",
    "tas", "oplader"
];


function getCurrentPicture($part)
{
    return "hangman_" . $part . ".png";
}


function startGame()
{
}

function restartGame()
{
    session_destroy();
    session_start();
}

function getParts()
{
    global $bodyParts;
    return isset($_SESSION["parts"]) ? $_SESSION["parts"] : $bodyParts;
}

function addPart()
{
    $parts = getParts();
    array_shift($parts);
    $_SESSION["parts"] = $parts;
}

function getCurrentPart()
{
    $parts = getParts();
    return $parts[0];
}

function getCurrentWord()
{
    global $words;
    if (!isset($_SESSION["word"]) && empty($_SESSION["word"])) {
        $key = array_rand($words);
        $_SESSION["word"] = $words[$key];
    }
    return $_SESSION["word"];
}

function getCurrentResponses()
{
    return isset($_SESSION["responses"]) ? $_SESSION["responses"] : [];
}

function addResponse($letter)
{
    $responses = getCurrentResponses();
    array_push($responses, $letter);
    $_SESSION["responses"] = $responses;
}

function isLetterCorrect($letter)
{
    $word = getCurrentWord();
    $max = strlen($word) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if ($letter == $word[$i]) {
            return true;
        }
    }
    return false;
}

function isWordCorrect()
{
    $guess = getCurrentWord();
    $responses = getCurrentResponses();
    $max = strlen($guess) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if (!in_array($guess[$i], $responses)) {
            return false;
        }
    }
    return true;
}

function isBodyComplete()
{
    $parts = getParts();

    if (count($parts) <= 1) {
        return true;
    }
    return false;
}

function gameComplete()
{
    return isset($_SESSION["gamecomplete"]) ? $_SESSION["gamecomplete"] : false;
}


function markGameAsComplete()
{
    $_SESSION["gamecomplete"] = true;
}

function markGameAsNew()
{
    $_SESSION["gamecomplete"] = false;
}

if (isset($_GET['start'])) {
    restartGame();
}


if (isset($_GET['kp'])) {
    $currentPressedKey = isset($_GET['kp']) ? $_GET['kp'] : null;
    if (
        $currentPressedKey
        && isLetterCorrect($currentPressedKey)
        && !isBodyComplete()
        && !gameComplete()
    ) {
        addResponse($currentPressedKey);
        if (isWordCorrect()) {
            $WON = true;
            markGameAsComplete();
        }
    } else {
        if (!isBodyComplete()) {
            addPart();
            if (isBodyComplete()) {
                markGameAsComplete();
            }
        } else {
            markGameAsComplete();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Galgje</title>
    <a href="index.php"><button>terug</button></a>
</head>

<body style="background: #C9AFEF">

    <div style="margin: 0 auto; background: #C9AFEF; width:900px; height:900px; padding:5px; border-radius:3px;">

        <div style="display:inline-block; width: 500px; background:#C9AFEF;">
            <img style="width:80%; display:inline-block;" src="<?php echo getCurrentPicture(getCurrentPart()); ?>" />

            <?Php if (gameComplete()) : ?>
                <h1>Spel afgelopen</h1>
            <?php endif; ?>
            <?php if ($WON  && gameComplete()) : ?>
                <p style="color: black; font-size: 25px;">Je hebt gewonnen Goed gedaan! Het woord was <?php print_r($_SESSION['word']) ?></p>
            <?php elseif (!$WON  && gameComplete()) : ?>
                <p style="color: black; font-size: 25px;">Je hebt verloren Jammurrr! Het woord was <?php print_r($_SESSION['word']) ?></p>
            <?php endif; ?>
        </div>

        <div style="float:right; display:inline; vertical-align:top;">
            <h1>Galgje</h1>
            <div style="display:inline-block;">
                <form method="get">
                    <?php
                    $max = strlen($letters) - 1;
                    for ($i = 0; $i <= $max; $i++) {
                        echo "<button type='submit' name='kp' value='" . $letters[$i] . "'>" .
                            $letters[$i] . "</button>";
                        if ($i % 7 == 0 && $i > 0) {
                            echo '<br>';
                        }
                    }
                    ?>
                    <br><br>
                    <button type="submit" name="start">Opnieuw</button>
                </form>
            </div>
        </div>

        <div style="margin-top:20px; padding:15px; background: #8D1FC4; color: #fcf8e3">

            <?php

            $guess = getCurrentWord();
            $maxLetters = strlen($guess) - 1;

            for ($j = 0; $j <= $maxLetters; $j++) :
                $l = getCurrentWord()[$j]; ?>

                <?php if (in_array($l, getCurrentResponses())) : ?>
                    <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;"><?php echo $l; ?></span>
                <?php else : ?>
                    <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;">&nbsp;&nbsp;&nbsp;</span>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

    </div>



</body>


</html>