<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Chi Pham" />
    <title>Web Programming – Lab10</title>
</head>

<body>
    <h1>Web Programming – Lab10</h1>
    <?php
    require_once("mykeys.inc.php");
    require_once("hitcounter.php");
    $counter = new HitCounter($host, $user, $pswd, $dbnm, 'hitcounter');
    $counter->setHits();
    echo '<p>This page has received ' . $counter->getHits() . ' hits</p>';

    $counter->closeConnection();
    ?>
</body>

</html>