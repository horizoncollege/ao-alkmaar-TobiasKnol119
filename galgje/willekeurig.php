<!DOCTYPE html>
<html>

<head>
    <title>willekeurig</title>
</head>
<style>
    body {
        background-color: #C9AFEF;
    }

    .button {
        display: flex;
        justify-content: center;
    }

    h1 {
        display: flex;
        justify-content: center;
    }
</style>

<body>

    <a href="index.php"><button>terug</button></a>
    <form action="willekeurigspel.php">
        <h1>Je hebt gekozen om met een willekeurig woord te spelen</h1>
        <div class="button">
            <input type="submit" value="speel met dit woord">
        </div>
    </form>
    <?php
    
    session_start();
    session_destroy();
    $woord = array('computer', 'programmeren', 'galgje', 'auto');


    ?>
</body>

</html>