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
    $currentPage = 'about'; // Initialize variable for nav
    session_start();
    if (!isset($_SESSION['login_status']) || $_SESSION['login_status'] !== true) {
        //User have not logged in
        $_SESSION['login_status'] = false;
    } else {
        $_SESSION['login_status'] = true;
    }
    include("header.php"); //include header file
    ?>

    <h1>About</h1>
    <ul class="introduction">
        <li>Task not completed: None</li>
        <li>Special Features:
            <ol>
                <li>Style: CSS - Bootstrap.</li>
                <li>Adding the header and footer.</li>
                <li>Adding pagination for friendadd features with direct page number selection</li>
                <li>Users cannot access to friendlist and friendadd if they have not logged in. Therefore, the
                    notification will be shown with the link of login and signup page for them.</li>
                <li>Interface: button in the top right of the screen used to login or logout based on the login status
                    session</li>
            </ol>
        </li>
        <li>Parts I have troubled with: The query to add or remove friends.</li>
        <li>Improvement: The assignment does not require but I want to design and implement this project with Object
            Oriented.</li>
        <li><strong>Note:</strong> The system will check user logged in or not. So if not, there will be a notification
            in friendlist and friendadd page with the link for user to login or sign up. Or you can press the login
            button on the top right of the screen. When user logged in successfully, the friendlist and friendadd can be
            access and the top right button will change to logout. Thank you!</p>
    </ul>

    <p class="url"><a href="friendlist.php">Friend List</a></p>
    <p class="url"><a href="friendadd.php">Friend Add</a></p>
    <p class="url"><a href="index.php">Return to Home Page</a></p>

    <div>
        <p style="font-size: 18px; margin-left: 20px;">I have answered the question about login status session.</p>
        <img src="images/discussionQuestion.png" alt="Discussion Question" /><br>
        <p style="text-align: center">Question from classmate about login status session</p>

        <img src="images/discussionAnswer.png" alt="Discussion Answer" /><br>
        <p style="text-align: center">My answer for the question about login status session</p>
    </div>

    <?php
    include("footer.php"); //include footer file
    ?>
</body>

</html>