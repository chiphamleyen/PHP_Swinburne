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
    $currentPage = 'home';
    include("header.php");
    ?>

    <main>
        <h1>Job Vacancy Posting System Introduction</h1>
        <div class="introduction">
            <p><strong>Name:</strong> Chi Pham</p>
            <p><strong>Student ID:</strong> 103430040</p>
            <p><strong>Email:</strong> 103430040@student.swin.edu.au</p>
            <p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied
                from any other student's work or from any other source.</p>
        </div>

        <div class="url">
            <p><a href="postjobform.php">Post a job vacancy</a></p>
            <p><a href="searchjobform.php">Search for a job vacancy</a></p>
            <p><a href="about.php">About this assignment</a></p>
        </div>
    </main>

    <?php
    include("footer.php");
    ?>
</body>

</html>