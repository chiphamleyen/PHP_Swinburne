<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Pham Le Yen Chi" />
    <!-- CSS -->
    <link href="style/style.css" rel="stylesheet" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <title>Assignment 2</title>
</head>

<body>
    <?php
    session_start(); //Start the session
    $table = ''; // Initialize variable for table
    $currentPage = 'list'; // Initialize variable for nav
    include("header.php"); //include header file
    ?>

    <?php
    include("functions.php");
    if (!isset($_SESSION['login_status']) || $_SESSION['login_status'] !== true) {
        //User have not logged in
        echo '<p class="message">Please <a href="login.php">Login</a> or <a href="signup.php">Singup</a> first.</p>';
        exit();
    } else {
        require_once("settings.php"); // Require the settings.php file for database connection information
        @$conn = mysqli_connect($host, $user, $pswd, $dbnm); // Connect to the database
        if (!$conn) {
            echo "<p>Unable to connect to the database.</p>";
        } else {
            updateFriendSession($conn); // Update the 'friends' session from the database
            $friends = $_SESSION["friends"]; //number of friends in session
            $friend_array = array();

            if ($friends > 0) {
                // Query for the list of friends from the 'myfriends' table based on the current session's friend_id
                $sqlquery = 'SELECT * FROM myfriends WHERE friend_id1 ="' . $_SESSION["friend_id"] . '" OR friend_id2 = "' . $_SESSION["friend_id"] . '";';

                $result = mysqli_query($conn, $sqlquery);

                if ($result) {
                    // Loop through the result and save the friend_id of each friend to the friend array
                    while ($row = mysqli_fetch_assoc($result)) {
                        //push to friend array with the value of friend id1 or friend id2 based on the value of friend id session
                        array_push($friend_array, ($row["friend_id1"] == $_SESSION["friend_id"]) ? $row["friend_id2"] : $row['friend_id1']);
                    }
                    $num = mysqli_num_rows($result);
                    mysqli_free_result($result);
                    $ids = implode(",", $friend_array);

                    // Query for the information of friends based on the friend_id in the friend array
                    $sqlqueryList = "SELECT friend_id, profile_name FROM friends WHERE friend_id IN ($ids);";
                    $resultList = mysqli_query($conn, $sqlqueryList);
                    if ($resultList) {
                        while ($row = mysqli_fetch_assoc($resultList)) {
                            $col = '<tr><td>' . $row["profile_name"] . '</td><td><input type="submit"  value="Unfriend" name="' . $row["friend_id"] . '"></td></tr>';
                            $table .= $col;
                        }
                        mysqli_free_result($resultList);

                    } else {

                    }
                    // Handle the unfriend action when clicking the "Unfriend" buttons
                    unfriend($conn, $_SESSION["friend_id"], $friend_array);
                    mysqli_close($conn);

                } else {
                    echo "<p>Error querying the database: " . mysqli_error($conn) . "</p>";
                }
            } else {
                // If the friend list is empty, display message
                // echo "<p class='error'>There is no friend in the list. You can add new friend.</p>";
            }
        }
    }
    ?>

    <!-- Display the form to show the list of friends -->
    <div class="postfriend">
        <h2>Friend List Page</h2>
        <h3>
            <?php echo isset($_SESSION["profile_name"]) ? $_SESSION["profile_name"] : ''; ?>'s Friend List Page
        </h3>
        <h3>Total number of friend is
            <?php echo isset($_SESSION["friends"]) ? $_SESSION["friends"] : ''; ?>
        </h3>

        <form class="friendform" action="friendlist.php" method="POST">
            <table class="table table-striped">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Unfriend</th>
                </tr>
                <?php echo $table; ?>
            </table>
        </form>

        <!-- Display the buttons in three columns -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4">
                    <p><a href="index.php">Home Page</a></p>
                </div>
                <div class="col-md-4">
                    <p><a href="friendadd.php">Add Friends</a></p>
                </div>
                <div class="col-md-4">
                    <p><a href="logout.php">Log out</a></p>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("footer.php"); //include footer file
    ?>
</body>

</html>