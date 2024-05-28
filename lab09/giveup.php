<?php
session_start();
$number = $_SESSION["guessnumber"];
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
    <?php
    echo '<p style = "color:blue">The hidden number is: <strong>' . $number . '</strong></p>';
    ?>

    <p><a href="startover.php">Start over</a></p>
</body>

</html>