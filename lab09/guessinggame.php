<?php
session_start(); // start the session 
if (!isset($_SESSION["number"])) { // check if session variable exists 
    $_SESSION["number"] = 0; // create the session variable 
}

$num = $_SESSION["number"]; // copy the value to a variable 
if (!isset($_SESSION["guessnumber"])) {
    $randNum = rand(1, 100);
    $_SESSION["guessnumber"] = $randNum;
}
$hiddennum = $_SESSION["guessnumber"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Chi Pham" />
    <title>Web Programming - Lab09</title>
</head>

<body>
    <h1>Guessing Game</h1>
    <p>Enter a number between 1 and 100, then press the Guess button.</p>
    <form action="guessinggame.php" method="POST">
        <input type="text" name="guessnumber" />
        <input type="submit" name="guess" value="Guess" />
    </form>
    <?php
    if (isset($_POST["guessnumber"]) && !empty($_POST["guessnumber"])) {
        $num++;
        $_SESSION["number"] = $num;
        $guessnum = $_POST["guessnumber"];
        if (is_numeric($guessnum)) {
            if ($guessnum >= 1 && $guessnum <= 100) {
                if ($guessnum > $hiddennum) {
                    echo "<p>Your guess is higher than the hidden number.</p>";
                } elseif ($guessnum < $hiddennum) {
                    echo "<p>Your guess is lower than the hidden number.</p>";
                } else {
                    echo "<p style = 'color:green'>Congratulations! You guessed the hidden number.</p>";
                }
            } else {
                echo "<p>Your number must be from 1 to 100.</p>";
            }
        } else {
            echo "<p>Please fill in a number.</p>";
        }
    } else {
        echo "<p>Please enter your answer</p>";
    }
    echo "<p>Number of guesses: $num</p>";
    ?>
    <p><a href="giveup.php">Give up</a></p>
    <p><a href="startover.php">Start over</a></p>
</body>

</html>