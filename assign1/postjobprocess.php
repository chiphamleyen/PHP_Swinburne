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
    $currentPage = 'post';
    include("header.php");

    $isNull = false; // Flag to track if any input field is empty
    $invalid = false; // Flag to track if any input field is invalid
    
    function checkNull($input)
    {
        if (!isset($_POST[$input]) || empty($_POST[$input])) {
            echo "<p>Please fill in $input</p>";
            return true;
        }
        return false;
    }

    $form_field = array("position_id", "title", "description", "closing_date", "position", "contract", "application", "location");
    foreach ($form_field as $field) {
        if (checkNull($field)) {
            $isNull = true;
        }
    }

    // Function to validate input fields
    function validation($pos_id, $title, $desc, $date)
    {
        //start with letter P followed by 4 digits
        if (!preg_match("/^P\d{4}$/", $pos_id)) {
            echo ('<p>ID should start with letter P followed by 4 digits.</p> ');
            return true;
        }
        //should have 5 characters
        if (strlen($pos_id) !== 5) {
            echo ('<p>ID should have 5 characters.</p> ');
            return true;
        }
        //max 20 characters
        if (strlen($title) > 20) {
            echo ('<p>Title is too long.</p> ');
            return true;
        }
        //check alphanumeric format
        if (!preg_match("/^(\w[\s,\.\!]*){1,20}$/", $title)) {
            echo ('<p>Invalid Title input format.</p>');
            return true;
        }
        //max 260 characters
        if (strlen($desc) > 260) {
            echo "<p>Description is too long.</p>";
            return true;
        }
        //check date format
        if (!preg_match("/^((3[0|1]|2\d|1\d|0\d|[1-9])\/(1[0-2]|0\d|[1-9])\/(\d{2}))$/", $date)) {
            echo ('<p>Invalid Closing Date input format.</p>');
            return true;
        }
        return false;
    }

    if ($isNull === false) {
        $position_id = $_POST["position_id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $closing_date = $_POST["closing_date"];
        $position = $_POST["position"];
        $contract = $_POST["contract"];
        $application = $_POST["application"];
        $location = $_POST["location"];

        //input validation
        if (validation($position_id, $title, $description, $closing_date)) {
            $invalid = true;
        }

        $filename = "../../data/jobposts/jobs.txt";
        umask(0007);
        $dir = "../../data/jobposts";
        if (!file_exists($dir)) {
            mkdir($dir, 02770);
        }

        $joblist = array();
        if (file_exists($filename)) { // check if file exists for reading 
            $job = array(); // create an empty array 
            $handle = fopen($filename, "r"); // open the file in read mode 
            while (!feof($handle)) { // loop while not end of file 
                $onedata = fgets($handle); // read a line from the text file 
                if ($onedata !== "") { // ignore blank lines 
                    $data = explode("\t", $onedata); // explode string to array
                    $joblist[] = $data; // create an array element
                    $job[] = $data[0]; // create a string element 
                }
            }
            fclose($handle); // close the text file
            $newdata = !(in_array($position_id, $job)); // check if item exists in array 
        } else {
            $newdata = true; // file does not exists, thus it must be a new data 
        }

        if ($newdata && $invalid == false) {
            $handle = fopen($filename, "a"); // open the file in append mode
            $data = $position_id . "\t" . $title . "\t" . $description . "\t" .
                $closing_date . "\t" . $position . "\t" . $contract . "\t";
            foreach ($application as $checkbox) {
                $data .= $checkbox . " ";
            }
            $data .= "\t" . $location . "\t\n";
            $joblist[] = $data; // add data to array 
            fputs($handle, $data); // write string to text file 
            fclose($handle); // close the text file
            echo "<p>Job is successfully posted</p>";
        } else
            echo "<p>Job with the same ID already exist</p>";
    }

    ?>

    <p class="url">All fields are required. <a href="index.php">Return to Home Page</a></p>
</body>

</html>