<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Chi Pham" />
    <title>Web Programming - Lab08</title>
</head>

<body>
    <h1>Web Programming - Lab08</h1>
    <?php
    require_once("settings.php");

    // ## 1. open the connection
    // Connect to mysql server
    $conn = @mysqli_connect($host, $user, $pswd)
        or die('Failed to connect to server');
    // Use database
    @mysqli_select_db($conn, $dbnm)
        or die('Database not available');
    // ## 2. set up SQL string and execute 
    // get data from user, escape it, trust no-one. :)
    $query = "SELECT car_id, make, model, price FROM cars";
    $results = mysqli_query($conn, $query);
    $numberofresult = mysqli_num_rows($results);
    if ($numberofresult > 0) {
        //creating table of result
        echo '<table border="1">';
        echo '<tr style="font-weight:bold">';
        echo "<td>Car Id</td>";
        echo "<td>Make</td>";
        echo "<td>Model</td>";
        echo "<td>Price</td>";
        echo '</tr>';
        while ($row = mysqli_fetch_assoc($results)) {
            echo '<tr>';
            echo "<td>" . $row['car_id'] . "</td>";
            echo "<td>" . $row['make'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "<p>There is nothing in the table.</p>";
    }
    // ## 3. close the connection
    mysqli_free_result($results);
    mysqli_close($conn);
    ?>
</body>

</html>