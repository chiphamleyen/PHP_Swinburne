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
    <title>Assignment 1</title>
</head>

<body>
    <?php
    $currentPage = 'about';
    include("header.php"); //include header file
    ?>

    <h1>About</h1>
    <ul class="introduction">
        <li>
            <?php echo 'PHP version: ' . phpversion(); ?>
        </li>
        <li>Task not completed: None</li>
        <li>Special Features:
            <ol>
                <li>Style: CSS - Bootstrap.</li>
                <li>Adding the header and footer.</li>
                <li>Form: using placeholder to suggest the input.</li>
                <li>PHP: using array to handle with the application field.</li>
                <li>PHP: using array_pop to remove the element from end of array.</li>
            </ol>
        </li>
        <li><strong>Note:</strong> I have already add some jobs in data/jobposts/jobs.txt - You can use the system to
            test the requirement. If you want to add your own data into the jobs.txt file, please follow the same
            format. Thank you!</p>
    </ul>


    <div>
        <p style="font-size: 18px; margin-left: 20px;">I have answered the question about Task 8 in Discussion Board.
        </p>
        <img src="images/discussionQuestion.png" alt="Discussion Question" /><br>
        <p style="text-align: center">Question from classmate about Task 8</p>

        <img src="images/discussionAnswer.png" alt="Discussion Answer" /><br>
        <p style="text-align: center">My answer for the question about Task 8</p>
    </div>

    <p class="url"><a href="index.php">Return to Home Page</a></p>

    <?php
    include("footer.php"); //include footer file
    ?>
</body>

</html>