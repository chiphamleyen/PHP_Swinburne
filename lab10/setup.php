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
    <form action="setup.php" method="POST">
        <label>User Name</label>
        <input type="text" name="username" />
        <label>Password</label>
        <input type="password" name="password" />
        <label>Database</label>
        <input type="text" name="database" />
        <input type="submit" name="submit" value="Set Up" />
    </form>
    <?php
    require_once("mykeys.inc.php");
    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $database = $_POST["database"];
        $conn = @mysqli_connect($host, $username, $password)
            or die('<p>Connection failed: ' . mysqli_connect_error() . '</p>');
        @mysqli_select_db($conn, $dbnm) or die('<p>Invalid Database</p>');

        $queryCreateTable = 'CREATE TABLE IF NOT EXISTS ' . $database . '.`hitcounter` (`id` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, `hits` SMALLINT NOT NULL );';
        $queryInsert = "INSERT INTO `hitcounter` (`id`, `hits`) VALUES ('1', '0');";
        $conn->query($queryCreateTable) or die('<p>Create table FAILED!</p>');
        $conn->query($queryInsert) or die('<p>Insert to table FAILED!</p>');
        echo 'Setup Completed';
        $conn->close();
    }
    ?>
</body>

</html>