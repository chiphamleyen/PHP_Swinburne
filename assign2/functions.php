<?php
//create table friends and myfriends then populate data
function createTable($conn)
{
    $tableCreated = false;
    $sqlCheckTable = "SHOW TABLES LIKE 'friends';";
    $result = mysqli_query($conn, $sqlCheckTable);
    if (mysqli_num_rows($result) > 0) {
        $tableCreated = true;
        echo "<p class='introduction'>Table successfully created and populated.</p>";
    }
    if (!$tableCreated) {
        $queryCreateFriends = "CREATE TABLE IF NOT EXISTS `s103430040_db`.`friends` ( 
        `friend_id` INT NOT NULL AUTO_INCREMENT , 
        `friend_email` VARCHAR(50) NOT NULL , 
        `password` VARCHAR(20) NOT NULL, 
        `profile_name` VARCHAR(30) NOT NULL, 
        `date_started` DATE NOT NULL , 
        `num_of_friend` INT UNSIGNED , 
        PRIMARY KEY (`friend_id`)
    ) ENGINE = InnoDB;";

        if (@mysqli_query($conn, $queryCreateFriends)) {
            echo ("<p>Table friends successfully created and populated</p>");
            insertFriendsRecord($conn);
        } else {
            echo ("<p>Unable to create table friend</p>");
        }

        $queryCreateMyFriends = "CREATE TABLE IF NOT EXISTS `s103430040_db`.`myfriends` (
        friend_id1 int NOT NULL, 
        friend_id2 int NOT NULL, 
        FOREIGN KEY (friend_id1) REFERENCES friends (friend_id), 
        FOREIGN KEY (friend_id2) REFERENCES friends (friend_id)
    ) ENGINE = InnoDB;";
        if (@mysqli_query($conn, $queryCreateMyFriends)) {
            echo ("<p>Table myfriends successfully created and populated.</p>");
            insertMyFriendsRecord($conn);
        } else {
            echo ("<p>Unable to create table friend.</p>");
        }
    }
}

//insert 10 sample records to friends table
function insertFriendsRecord($conn)
{
    $queryInsertFriends = "INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friend) 
    VALUES 
        ('user1@gmail.com','password1','John Doe','2023-07-20', 6),
        ('user2@gmail.com','password2','Chi Pham','2023-07-20', 4),
        ('user3@gmail.com','password3','Minh Pham','2023-07-20', 3),
        ('user4@gmail.com','password4','Quang Pham','2023-07-20', 4),
        ('user5@gmail.com','password5','Viet Pham','2023-07-20', 5),
        ('user6@gmail.com','password6','Tu Nguyen','2023-07-20', 4),
        ('user7@gmail.com','password7','Linh Nguyen','2023-07-20', 2),
        ('user8@gmail.com','password8','Thao Le','2023-07-20', 3),
        ('user9@gmail.com','password9','Duc Nguyen','2023-07-20', 7),
        ('user10@gmail.com','password10','David Jonas','2023-07-20', 2);";
    if (mysqli_query($conn, $queryInsertFriends)) {
        echo "<p>Sample records inserted into 'friends' table successfully.</p>";
    } else {
        echo "<p>Error inserting sample records into 'friends' table: " . mysqli_error($conn) . "</p>";
    }
}

//insert 20 sample records to myfriends table
function insertMyFriendsRecord($conn)
{
    $queryInsertMyFriends = "INSERT INTO myfriends (friend_id1, friend_id2) 
    VALUES 
        (1, 2),
        (2, 3),
        (1, 3),
        (2, 4),
        (3, 5),
        (4, 5),
        (4, 6),
        (6, 7),
        (6, 9),
        (1, 8),
        (1, 6),
        (1, 10),
        (2, 9),
        (1, 5),
        (7, 9),
        (8, 9),
        (9, 10),
        (5, 8),
        (5, 9),
        (4, 9)";
    if (mysqli_query($conn, $queryInsertMyFriends)) {
        echo "<p>Sample records inserted into 'myfriends' table successfully.</p>";
    } else {
        echo "<p>Error inserting sample records into 'myfriends' table: " . mysqli_error($conn) . "</p>";
    }
}

//check email is already exist or not
function checkUniqueEmail($conn, $email)
{
    $sqlquery = 'SELECT * FROM friends WHERE friend_email = "' . $email . '";';
    $result = mysqli_query($conn, $sqlquery);
    if ($result) {
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }

}

//update number of friends to session
function updateFriendSession($conn)
{
    $query = "SELECT num_of_friend from friends where friend_id = " . $_SESSION["friend_id"] . ";";
    $result = @mysqli_query($conn, $query);
    if ($result) {
        $row = $result->fetch_assoc();
        $_SESSION["friends"] = $row['num_of_friend'];
    } else {
        echo ("<p>Unable to execute query>/p>");
    }
}

//remove data from myfriends table
function unfriend($conn, $friend1, $friend_ids)
{
    foreach ($friend_ids as $id) {
        if (isset($_POST[$id])) {
            $sqlquery = "DELETE FROM myfriends WHERE 
            (friend_id1 = '$friend1' AND friend_id2 = '$id') OR 
            (friend_id1 = '$id' AND friend_id2 = '$friend1');";
            $result = mysqli_query($conn, $sqlquery);
            if ($result) {
                echo $_SESSION["friends"];
                decreaseFriendNum($conn, $friend1, $id);
                // mysqli_free_result($result);
            } else {
                echo "<p>Connot unfriend</p>";
            }
        }
    }
}

//decrease number of friend in friends table
function decreaseFriendNum($conn, $friend1, $friend2)
{
    $sqlquery = "SELECT num_of_friend FROM friends WHERE friend_id IN ($friend1, $friend2);";
    $result = mysqli_query($conn, $sqlquery);

    if ($result) {
        // $row = mysqli_fetch_assoc($result);
        // $numOfFriends = $row[5];
        mysqli_free_result($result);
        // echo $numOfFriends;

        if ($_SESSION["friends"] >= 0) {
            $sqlquery = "UPDATE friends SET num_of_friend = CASE WHEN num_of_friend > 0 THEN num_of_friend - 1 ELSE 0 END WHERE friend_id IN ($friend1, $friend2);";
            $result = mysqli_query($conn, $sqlquery);

            if ($result) {
                $_SESSION["friends"]--;
                echo $_SESSION["friends"];
                echo "<p>Successfully removed friend</p>";
                header("location: friendlist.php");
                exit();
            } else {
                echo "<p>Error updating num_of_friend: " . mysqli_error($conn) . "</p>";
            }
        }
    } else {
        echo "<p>Error querying the database: " . mysqli_error($conn) . "</p>";
    }
}

//count friends record
function countUsers($conn, $myfriend_id)
{
    $sqlquery = "SELECT COUNT(*) FROM friends WHERE friend_id != '$myfriend_id';";
    $result = mysqli_query($conn, $sqlquery);
    $count = 0;
    if ($result) {
        $row = mysqli_fetch_array($result);
        $count = $row[0];
    }
    mysqli_free_result($result);
    return $count;
}

//insert new data to myfriends table
function addFriend($conn, $friend1, $friend_ids)
{
    foreach ($friend_ids as $id) {
        if (isset($_POST[$id])) {
            $sqlquery = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES ('$friend1','$id');";
            $result = mysqli_query($conn, $sqlquery);
            if ($result) {
                echo $_SESSION["friends"];
                increaseFriendNum($conn, $friend1, $id);
            }
        }
    }
}

//increase number of friend in friends table
function increaseFriendNum($conn, $friend1, $friend2)
{
    $sqlquery = "SELECT num_of_friend FROM friends WHERE friend_id IN ($friend1, $friend2);";
    $result = mysqli_query($conn, $sqlquery);

    if ($result) {
        // $row = mysqli_fetch_assoc($result);
        // $numOfFriends = $row[5];
        mysqli_free_result($result);
        // echo $numOfFriends;

        if ($_SESSION["friends"] >= 0) {
            $sqlquery = "UPDATE friends SET num_of_friend = num_of_friend + 1 WHERE friend_id IN ($friend1, $friend2);";
            $result = mysqli_query($conn, $sqlquery);

            if ($result) {
                $_SESSION["friends"]++;
                echo $_SESSION["friends"];
                echo "<p>Successfully added friend</p>";
                header("location: friendadd.php");
                exit();
            } else {
                echo "<p>Error updating num_of_friend: " . mysqli_error($conn) . "</p>";
            }
        }
    } else {
        echo "<p>Error querying the database: " . mysqli_error($conn) . "</p>";
    }
}

//count mutual friends in myfriend table
function countMutualFriend($conn, $friend1Arr, $friend2)
{
    $count = 0;
    $friend2Arr = array();
    $sqlquery = "SELECT * FROM myfriends WHERE friend_id1 = '$friend2' OR friend_id2 = '$friend2';";
    $result = mysqli_query($conn, $sqlquery);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($friend2Arr, ($row["friend_id1"] == $friend2) ? $row["friend_id2"] : $row['friend_id1']);
        }
        mysqli_free_result($result);
    }
    $arrayResult = array_intersect($friend1Arr, $friend2Arr);
    $count = count($arrayResult);
    return $count;
}
?>