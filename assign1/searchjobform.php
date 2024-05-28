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
    $currentPage = 'search';
    include("header.php");
    ?>
    <!-- Display search form  -->
    <div class="postform">
        <h2>Job Vacancy Searching Form</h2>

        <form action="searchjobprocess.php" method="GET">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="title">Job Title: </label>
                <div class="col-sm-8">
                    <input type="text" id="title" placeholder="Developer" name="title">
                </div>
            </div>

            <div class="row">
                <label class="col-sm-3 col-form-label" for="position">Position: </label>
                <div class="col-sm-8">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="position" value="Full Time">
                        <label class="form-check-label" for="full_time">Full Time</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="position" value="Part Time">
                        <label class="form-check-label" for="part_time">Part Time</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <label class="col-sm-3 col-form-label" for="contract">Contract: </label>
                <div class="col-sm-8">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="contract" value="On-going">
                        <label class="form-check-label" for="on_going">On-going</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="contract" value="Fixed Term">
                        <label class="form-check-label" for="fixed_term">Fixed Term</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <label class="col-sm-3 col-form-label" for="application">Application by: </label>
                <div class="col-sm-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="application[]" value="post">
                        <label class="form-check-label" for="post">Post</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="application[]" value="mail">
                        <label class="form-check-label" for="mail">Mail</label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="location">Location: </label>
                <div class="col-sm-8 ">
                    <select name="location">
                        <option value="none" selected disabled hidden>---</option>
                        <option value="ACT">ACT</option>
                        <option value="NSW">NSW</option>
                        <option value="NT">NT</option>
                        <option value="QLD">QLD</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="VIC">VIC</option>
                        <option value="WA">WA</option>
                    </select>
                </div>
            </div>

            <div class="row" id="btn">
                <button type="submit">Search</button>
            </div>

        </form>

        <p><a href="index.php">Return to Home Page</a></p>
    </div>

    <?php
    include("footer.php");
    ?>
</body>

</html>