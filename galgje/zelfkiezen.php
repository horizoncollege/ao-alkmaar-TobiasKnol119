<!DOCTYPE html>
<html>

<head>
    <title>zelf kiezen</title>
</head>
<style>
    body {
        background-color: #C9AFEF;
    }

    h1 {
        display: flex;
        justify-content: center;
    }

    .text {
        display: flex;
        justify-content: center;
    }
</style>

<body>
    <a href="index.php"><button>terug</button></a>
    <h1>Je hebt gekozen om zelf een woord te kiezen</h1>
</body>

<body>
    <div class="text">
        <form action="" method="POST">
            <input type="text" name="woord">
            <input type="submit" value="submit" name="submit">
        </form>
    </div>
    <?php

    if (isset($_POST['submit'])) {
        session_start();
        session_destroy();
        session_start();
        $_SESSION['woord'] = $_POST['woord'];
        header('Location: galgje.php');
    }
    ?>
</body>

</html>