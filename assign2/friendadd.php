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
    session_start(); //start the session
    $table = ''; // Initialize variable for table
    $currentPage = 'add'; // Initialize variable for nav
    include("header.php"); //include header file
    ?>

    <?php
    include("functions.php");

    if (!isset($_SESSION['login_status']) || $_SESSION['login_status'] !== true) {
        //User have not logged in
        $_SESSION['login_status'] = false;
        echo '<p class="message">Please <a href="login.php">Login</a> or <a href="signup.php">Singup</a> first.</p>';
        exit();
    } else {
        $_SESSION['login_status'] = true;

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        require_once("settings.php"); // Require the settings.php file for database connection information
        @$conn = mysqli_connect($host, $user, $pswd, $dbnm); // Connect to the database
        if (!$conn) {
            echo "<p>Unable to connect to the database.</p>";
        } else {
            // Initialize variables for pagination and friend list
            $table = '';
            $recordsPerPage = 5;
            // $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $recordsPerPage;
            // Get the total number of accounts
            $accounts = countUsers($conn, $_SESSION["friend_id"]);
            // Calculate the total number of pages for pagination
            $totalPages = ceil($accounts / $recordsPerPage);
            if ($accounts > 0) {
                $accounts -= $_SESSION["friends"];
            } else {
                $accounts = 0;
            }
            if ($accounts > 0) {
                // $accounts -= $_SESSION["friends"];
                //select data from my friends table have friend id1 or friend id2 same as friend id in session (self)
                $sqlquery = 'SELECT * FROM myfriends WHERE friend_id1 ="' . $_SESSION["friend_id"] . '" OR friend_id2 = "' . $_SESSION["friend_id"] . '";';
                $result = mysqli_query($conn, $sqlquery);
                if ($result) {
                    $friend_array = array();
                    $myfriend_array = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        //push to friend array with the value of friend id1 or friend id2 based on the value of friend id session
                        array_push($friend_array, ($row["friend_id1"]) == $_SESSION["friend_id"] ? $row["friend_id2"] : $row["friend_id1"]);
                    }
                    mysqli_free_result($result);
                    $ids = implode(",", $friend_array);
                    if ($_SESSION["friends"] > 0) {
                        //if have friends, select data from friends table that not contains users that already be friends and self
                        $queryNotFriend = "SELECT friend_id, profile_name FROM friends WHERE friend_id NOT IN ($ids, " . $_SESSION["friend_id"] . ") LIMIT " . $offset . ", " . $recordsPerPage . ";";
                    } else {
                        //if no friend, select data from friends table that not contains self
                        $queryNotFriend = "SELECT friend_id, profile_name FROM friends WHERE friend_id NOT IN (" . $_SESSION["friend_id"] . ") LIMIT " . $offset . ", " . $recordsPerPage . ";";
                    }
                    $resultNotFriend = mysqli_query($conn, $queryNotFriend);
                    if ($resultNotFriend) {
                        while ($row = mysqli_fetch_assoc($resultNotFriend)) {
                            //count mutual friends
                            $mutualFriends = countMutualFriend($conn, $friend_array, $row["friend_id"]);
                            //line of table
                            $col = '<tr><td>' . $row["profile_name"] . '</td><td>' . $mutualFriends . ' Mutual friend(s) </td><td><input type="submit" value="Add as friend" name="' . $row["friend_id"] . '"></td></tr>';
                            $table .= $col;
                        }
                        mysqli_free_result($resultNotFriend);
                    } else {
                        //error
                    }

                    if ($_SESSION["friends"] > 0) {
                        //if have friends, select data from friends table that not contains users that already be friends and self
                        $query1 = "SELECT friend_id, profile_name FROM friends WHERE friend_id NOT IN ($ids, " . $_SESSION["friend_id"] . ");";
                    } else {
                        //if no friend, select data from friends table that not contains self
                        $query1 = "SELECT friend_id, profile_name FROM friends WHERE friend_id NOT IN (" . $_SESSION["friend_id"] . ");";
                    }
                    $result1 = mysqli_query($conn, $query1);
                    if ($result1) {
                        while ($row = mysqli_fetch_assoc($result1)) {
                            //push to myfriend array all ids of user's friends.
                            array_push($myfriend_array, $row["friend_id"]);
                        }
                        mysqli_free_result($result1);
                    }

                    // Handle the addfriend action when clicking the "Add friend" buttons
                    addFriend($conn, $_SESSION["friend_id"], $myfriend_array);
                    mysqli_close($conn);
                }
            } else {
                //if friendadd is empty, show message
                // echo "<p class='message'>You have added all friends in this system. You can see them in Friend List.</p>";
                // $accounts = 0;
    
            }

        }
    }
    ?>

    <!-- Display the form to show the list of friends -->
    <div class="postfriend">
        <h2>Friend Add Page</h2>
        <h3>
            <?php echo isset($_SESSION["profile_name"]) ? $_SESSION["profile_name"] : ''; ?>'s Add Friend Page
        </h3>
        <h3>Total number of friend is
            <?php echo isset($_SESSION["friends"]) ? $_SESSION["friends"] : ''; ?>
        </h3>

        <form class="friendform" action="friendadd.php" method="POST">
            <table class="table table-striped">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Mutual Friends</th>
                    <th scope="col">Add Friends</th>
                </tr>
                <?php echo $table; ?>
            </table>
        </form>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            <?php
            if ($accounts > $recordsPerPage) {
                echo '<ul class="pagination">';
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
                }
                for ($i = 1; $i <= $totalPages - 1; $i++) {
                    echo '<li class="page-item';
                    if ($i == $page) {
                        echo ' active';
                    }
                    echo '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
                if ($page < $totalPages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>

        <!-- Display the buttons in three columns -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4">
                    <p><a href="index.php">Home Page</a></p>
                </div>
                <div class="col-md-4">
                    <p><a href="friendlist.php">Friend List</a></p>
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