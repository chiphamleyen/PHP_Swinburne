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
    <h1>Search VIP Member</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="text" name="search" placeholder="Search for member last name" required>
        <input type="submit" name="submit" value="Search">
    </form>
    <?php
    require_once("settings.php");
    if (isset($_POST["submit"]) && isset($_POST["search"]) && !empty($_POST["search"])) {
        // ## 1. open the connection
        // Connect to mysql server
        $conn = @mysqli_connect($host, $user, $pswd)
            or die('Failed to connect to server');
        // Use database
        @mysqli_select_db($conn, $dbnm)
            or die('Database not available');
        // ## 2. set up SQL string and execute 
        // get data from user, escape it, trust no-one. :)
        $lname = trim($_POST["search"]);

        $query = "SELECT member_id, fname, lname FROM vipmembers WHERE lname LIKE '%$lname%'";
        $results = mysqli_query($conn, $query);
        $numberofresult = mysqli_num_rows($results);
        if ($numberofresult > 0) {
            //creating table of result
            echo '<table border="1">';
            echo '<tr style="font-weight:bold">';
            echo "<td>Member Id</td>";
            echo "<td>First Name</td>";
            echo "<td>Last Name</td>";
            echo '</tr>';
            while ($row = mysqli_fetch_assoc($results)) {
                echo '<tr>';
                echo "<td>" . $row['member_id'] . "</td>";
                echo "<td>" . $row['fname'] . "</td>";
                echo "<td>" . $row['lname'] . "</td>";
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo "<p>There is nothing in the table.</p>";
        }
        // ## 3. close the connection
        mysqli_free_result($results);
        mysqli_close($conn);
    }
    ?>
    <p><a href="vip_member.php">Home</a></p>
    <p><a href="member_add_form.php">Add New Member Form</a></p>
    <p><a href="member_display.php">Display All Members Page</a></p>
</body>

</html>