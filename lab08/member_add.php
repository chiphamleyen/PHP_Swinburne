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
    <h1>Add VIP Member</h1>
    <?php
    require_once("settings.php");

    if (isset($_POST["submit"]) && isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["gender"]) && isset($_POST["phone"])) {
        if (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && !empty($_POST["gender"]) && !empty($_POST["phone"])) {
            // Connect to mysql server
            $conn = @mysqli_connect($host, $user, $pswd)
                or die('Failed to connect to server');
            // Use database
            @mysqli_select_db($conn, $dbnm)
                or die('Database not available');
            $sqlquery = "CREATE TABLE IF NOT EXISTS vipmembers (
            member_id INT AUTO_INCREMENT PRIMARY KEY, 
            fname VARCHAR(40) NOT NULL , 
            lname VARCHAR(40) NOT NULL , 
            gender VARCHAR(1) NOT NULL , 
            email VARCHAR(40) NOT NULL , 
            phone VARCHAR(20) NOT NULL)";
            @$queryResult = mysqli_query($conn, $sqlquery) or die("<p>Unable to create new table</p>");

            $fname = addslashes($_POST["fname"]);
            $lname = addslashes($_POST["lname"]);
            $gender = addslashes($_POST["gender"]);
            $email = addslashes($_POST["email"]);
            $phone = addslashes($_POST["phone"]);
            $sqlquery = "INSERT INTO `vipmembers` (`member_id`, `fname`, `lname`, `gender`, `email`, `phone`) 
                VALUES (NULL, '$fname', '$lname', '$gender', '$email', '$phone')";
            @$queryResult = mysqli_query($conn, $sqlquery) or die("<p>Unable to insert new row</p>");
            echo "Successfully add member";
            //Close connection
            mysqli_close($conn);
        } else {
            echo "Please fill in all fields";
        }
    }
    ?>
    <p><a href="vip_member.php">Home</a></p>
    <p><a href="member_add_form.php">Add New Member Form</a></p>
    <p><a href="member_display.php">Display All Members Page</a></p>
    <p><a href="member_search.php">Search Member Page</a></p>
</body>

</html>