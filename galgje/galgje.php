<a href="zelfkiezen.php"><button>terug</button></a>

<?php

session_start();

$letters = "abcdefghijklmnopqrstuvwxyz";
$WON = false;
$letter = (isset($_GET['kp']));


$bodyParts = ["nohead", "head", "body", "hand", "hands", "leg", "legs"];

$words = [];
$userInput = $_SESSION['woord'];
array_push($words, $userInput);



function getCurrentPicture($part){
    return "hangman_" . $part . ".png";
}


function startGame()
{
}

function restartGame(){ //restart de game, maakt een nieuwe session 
    session_destroy();
    session_start();
}

function getParts(){ //pakt alle onderdelen van de hangman
    global $bodyParts;
    return isset($_SESSION["parts"]) ? $_SESSION["parts"] : $bodyParts;
}

function addPart(){ //voegd de onderdelen van de hangman toe aan de foto
    $parts = getParts();
    array_shift($parts);
    $_SESSION["parts"] = $parts;
}

function getCurrentPart(){ //haald de hangman onderdelen op
    $parts = getParts();
    return $parts[0];
}

function getCurrentWord(){ //haald het woord op wat gekozen is
    global $words;
    if (!isset($_SESSION["word"]) && empty($_SESSION["word"])) {
        $key = array_rand($words);
        $_SESSION["word"] = $words[$key];
    }
    return $_SESSION["word"];
}

function getCurrentResponses(){ //haald de responses van de gebruiker op
    return isset($_SESSION["responses"]) ? $_SESSION["responses"] : [];
}

function addResponse($letter){
    $responses = getCurrentResponses();
    array_push($responses, $letter);
    $_SESSION["responses"] = $responses;
}

$letterfout = array();


function isLetterCorrect($letter){  // controlleerd of de gekozen letter in het woord zit
    $word = getCurrentWord();
    $max = strlen($word) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if ($letter == $word[$i]) {
            return true;
        }
        else { 
            isLetterinCorrect($letter);
        }
    }
}   

//  $foutletter = ($letter <= $word[$i]); 
//  $letterfout[] = $foutletter;
//  kleurveranderen();


function isLetterinCorrect($letter){  // controlleerd of de gekozen letter in het woord zit
    $word = getCurrentWord();
    $max = strlen($word) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if ($letter <= $word[$i]) {
            $foutletter = ($letter <= $word[$i]); 
            $letterfout[] = $foutletter;
            array_push($letterfout);
            return true;
        }
        else { 
        }
    }
}   
print_r($letterfout);
function kleurveranderen(){
    include_once 'style.php';
}

function isWordCorrect(){ //controlleerd of het woord compleet is
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

function isBodyComplete(){ //controlleerd of de hangman volledig is
    $parts = getParts();
    if (count($parts) <= 1) {
        return true;
    }
    return false;
}

function gameComplete(){ //zorgd ervoor dat de game stopt als het klaar is
    return isset($_SESSION["gamecomplete"]) ? $_SESSION["gamecomplete"] : false;
}

function markGameAsComplete(){ 
    $_SESSION["gamecomplete"] = true;
}

function markGameAsNew(){ //zegd dat de game nieuw is
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
 <!--<p class="testen">euhhhhhhh</p>-->
    <meta charset="UTF-8">
    <title>Galgje</title>
</head>

<body style="background: #C9AFEF">

    <div style="margin: 0 auto; background: #C9AFEF; width:900px; height:900px; padding:5px; border-radius:3px;">

        <div style="display:inline-block; width: 500px; background:#C9AFEF;">
            <img style="width:80%; display:inline-block;" src="<?php echo getCurrentPicture(getCurrentPart()); ?>" />

            <?Php if (gameComplete()) : ?>
                <h1>Spel afgelopen</h1>
            <?php endif; ?>
            <?php if ($WON  && gameComplete()) : ?>
                <p style="color: black; font-size: 25px;">Je hebt gewonnen Goed gedaan! Het woord was <?php print_r($userInput)?></p>
            <?php elseif (!$WON  && gameComplete()) : ?>
                <p style="color: black; font-size: 25px;">Je hebt verloren Jammurrr! Het woord was <?php print_r($userInput)?></p>
            <?php endif; ?>
        </div>

        <div style="float:right; display:inline; vertical-align:top;">
            <h1>Galgje</h1>
            <?php
            ?>
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
                    <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;">&nbsp;&nbsp;&nbsp; </span>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

    </div>



</body>


</html>