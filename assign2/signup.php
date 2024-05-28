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
    $currentPage = 'post'; // Initialize variable for nav
    include("header.php"); //include header file
    ?>

    <!-- Display signup form  -->
    <div class="postform">
        <h2>Register Page</h2>

        <form action="signup.php" method="POST">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="email">Email</label>
                <div class="col-sm-8">
                    <input type="text" id="email" placeholder="example@gmail.com" name="email"
                        value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" />
                </div>
            </div>

            <div class=" form-group row">
                <label class="col-sm-3 col-form-label" for="profile_name">Profile Name</label>
                <div class="col-sm-8">
                    <input type="text" id="profile_name" placeholder="Kangaroo" name="profile_name"
                        value="<?php echo isset($_POST["profile_name"]) ? $_POST["profile_name"] : ''; ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="password">Password</label>
                <div class="col-sm-8">
                    <input type="password" id="password" name="password">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="confirm_password">Confirm Password</label>
                <div class="col-sm-8">
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" name="submit">Register</button>
                        <button type="reset" class="btn btn-secondary" name="clear">Clear</button>
                    </div>
                </div>
            </div>

        </form>

        <p>All fields are required. <a href="index.php">Return to Home Page</a></p>
        <p>Already have account? <a href="login.php">Login</a></p>

    </div>

    <?php
    if (isset($_POST["submit"])) {
        session_start();
        require_once("settings.php");
        @$conn = mysqli_connect($host, $user, $pswd, $dbnm);
        if (!$conn) {
            echo "<p>Unable to connect to the database.</p>";
        } else {
            $isNull = false;
            $invalid = false;
            $date = date("Y-m-d");

            //check null for input fields
            function checkNull($input)
            {
                if (!isset($_POST[$input]) || empty($_POST[$input])) {
                    echo "<p class='error'>Please fill in $input</p>";
                    return true;
                }
            }

            $fields = array("email", "profile_name", "password", "confirm_password");
            foreach ($fields as $field) {
                if (checkNull($field)) {
                    $isNull = true;
                }
            }

            //validation for all fields of the form
            function validation($email, $name, $password, $cfpassword, $conn)
            {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<p class='error'>Invalid Email</p>";
                    return true;
                }
                if (!preg_match("/^([A-Za-z][\s]*){1,20}$/", $name)) {
                    echo "<p class='error'>Invalid Profile Name. It must contain only letters</p>";
                    return true;
                }
                if (!preg_match("/^(\w*){1,20}$/", $password) && !preg_match("/^(\w*){1,20}$/", $cfpassword)) {
                    echo "<p class='error'>Invalid Password. It must contain only letters and numbers</p>";
                    return true;
                }
                if (strcmp($password, $cfpassword)) {
                    echo "<p class='error'>Password and Confirm Password do not match</p>";
                    return true;
                }
                require("functions.php");
                if (checkUniqueEmail($conn, $email)) {
                    echo "<p class='error'>Email Already Exists</p>";
                    return true;
                }
                return false;
            }

            //if all fields are not null
            if ($isNull === false) {
                $email = $_POST["email"];
                $name = $_POST["profile_name"];
                $password = $_POST["password"];
                $cfpassword = $_POST["confirm_password"];

                if (validation($email, $name, $password, $cfpassword, $conn)) {
                    $invalid = true;
                } else {
                    //insert new data to friends table
                    $sqlquery = "INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friend) VALUES ('$email', '$password', '$name', '$date','0');";
                    $result = mysqli_query($conn, $sqlquery);

                    if ($result) {
                        $_SESSION["email"] = $email;
                        $_SESSION["profile_name"] = $name;
                        $_SESSION["friends"] = 0;

                        //select data that have friend_email same as $email
                        $sqlquerySelect = "SELECT friend_id FROM friends WHERE friend_email = '$email'";
                        $resultSelect = mysqli_query($conn, $sqlquerySelect);
                        if ($resultSelect) {
                            $row = mysqli_fetch_row($resultSelect);
                            $_SESSION["friend_id"] = $row[0];
                            $_SESSION["login_status"] = true; //set login status to true
                            mysqli_close($conn);
                            header("location: friendadd.php");
                            // echo "<p>Sucessfully</p>";
                            exit();
                        } else {
                            echo "<p>Unable to create session</p>";
                        }
                    } else {
                        echo "<p>Failed to sign up</p>";
                        echo "<p>Error querying the database: " . mysqli_error($conn) . "</p>";
                    }
                }
            }
        }
        mysqli_close($conn);
    } else {
        // echo "<p>Have not submit!</p>";
    }
    ?>

    <?php
    include("footer.php"); //include footer file
    ?>


</body>

</html>