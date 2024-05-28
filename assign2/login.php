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

    <!-- Display login form  -->
    <div class="postform">
        <h2>Login Page</h2>

        <form action="login.php" method="POST">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="email">Email</label>
                <div class="col-sm-8">
                    <input type="text" id="email" placeholder="example@gmail.com" name="email"
                        value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="password">Password</label>
                <div class="col-sm-8">
                    <input type="password" id="password" name="password">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" name="submit">Log in</button>
                        <button type="reset" class="btn btn-secondary" name="clear">Clear</button>
                    </div>
                </div>
            </div>

        </form>

        <p>All fields are required. <a href="index.php">Return to Home Page</a></p>
        <p>Do not have account? <a href="signup.php">Register</a></p>

    </div>

    <?php
    if (isset($_POST["submit"])) {
        require_once("settings.php");
        @$conn = mysqli_connect($host, $user, $pswd, $dbnm);
        if (!$conn) {
            echo "<p>Unable to connect to the database.</p>";
        } else {
            $isNull = false;

            //check null for input fields
            function checkNull($input)
            {
                if (!isset($_POST[$input]) || empty($_POST[$input])) {
                    echo "<p class='error'>Please fill in $input</p>";
                    return true;
                }
            }

            $fields = array("email", "password");
            foreach ($fields as $field) {
                if (checkNull($field)) {
                    $isNull = true;
                }
            }

            //if all fields are not null
            if ($isNull === false) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                $sqlquery = "SELECT * FROM friends WHERE friend_email = '$email' AND password = '$password'";

                $result = mysqli_query($conn, $sqlquery);

                if ($result) {
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_row($result);
                        print_r($row);
                        session_start();
                        $_SESSION["friend_id"] = $row[0];
                        $_SESSION["email"] = $row[1];
                        $_SESSION["profile_name"] = $row[3];
                        $_SESSION["friends"] = $row[5];
                        $_SESSION["login_status"] = true; //set login status to true
                        mysqli_free_result($result);
                        mysqli_close($conn);
                        header("location: friendlist.php");
                        exit();
                    } else {
                        echo "<p class='error'>Email or password is incorrect.</p>";
                    }
                } else {
                    echo "<p>Error querying the database: " . mysqli_error($conn) . "</p>";
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