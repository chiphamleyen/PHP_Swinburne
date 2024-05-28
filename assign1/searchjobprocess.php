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
    include("header.php"); //include header file
    
    //validate title not null and not empty
    if (isset($_GET["title"]) && !empty($_GET["title"])) {
        $title = $_GET["title"];

        $filename = "../../data/jobposts/jobs.txt";
        $dir = "../../data/jobposts";

        if (file_exists($dir) && is_readable($filename)) {
            $handle = fopen($filename, "r");
            $data = file_get_contents($filename);
            $arrayLine = explode("\n", $data);
            array_pop($arrayLine);
            sort($arrayLine);

            $search_result = array();

            //flags for search
            $matchCriteria = false;
            $positionMatch = false;
            $contractMatch = false;
            $applicationMatch = false;
            $locationMatch = false;

            echo "<h3 style='margin-top: 20px;'>Available Jobs: </h3>";
            //filtering
            foreach ($arrayLine as $line) {
                $arr = explode("\t", $line);
                if (strpos(strtolower($arr[1]), strtolower($title)) !== false) {
                    if (empty($_GET["position"]) || strpos($arr[4], $_GET["position"]) !== false) {
                        $matchCriteria = true;
                        $positionMatch = true;
                    } else {
                        $positionMatch = false;
                    }
                    if (empty($_GET["contract"]) || strpos($arr[5], $_GET["contract"]) !== false) {
                        $matchCriteria = true;
                        $contractMatch = true;
                    } else {
                        $contractMatch = false;
                    }

                    if (empty($_GET["application"])) {
                        $applicationMatch = true;
                    } else {
                        $appArr = explode(" ", $arr[6]);

                        if (count($_GET["application"]) === 1 && count($appArr) === 1) {
                            if ($appArr[0] == 'mail' && in_array('mail', $_GET["application"])) {
                                $applicationMatch = true;
                            } elseif ($appArr[0] == 'post' && in_array('post', $_GET["application"])) {
                                $applicationMatch = true;
                            } else {
                                $applicationMatch = false;
                            }
                        } elseif (count($_GET["application"]) === 1 && count($appArr) != 1) {
                            if ($appArr[1] == 'mail' && in_array('mail', $_GET["application"])) {
                                $applicationMatch = true;
                            } elseif ($appArr[0] == 'post' && in_array('post', $_GET["application"])) {
                                $applicationMatch = true;
                            } else {
                                $applicationMatch = false;
                            }
                        } elseif (count($_GET["application"]) != 1) {
                            if (in_array($_GET["application"][1], $appArr)) {
                                $applicationMatch = true;
                            } else if (in_array($_GET["application"][0], $appArr) || in_array($_GET["application"][1], $appArr)) {
                                $applicationMatch = true;
                            } else {
                                $applicationMatch = false;
                            }
                        } else {
                            $applicationMatch = false;
                        }
                    }

                    if (empty($_GET["location"]) || $arr[7] == $_GET["location"]) {
                        $matchCriteria = true;
                        $locationMatch = true;
                    } else {
                        $locationMatch = false;
                    }

                    $job_date = date_timestamp_get(date_create_from_format("d/m/y", $arr[3]));
                    $date_today = date_timestamp_get(date_create_from_format("d/m/y", date('d/m/y')));

                    if ($positionMatch == true && $contractMatch == true && $applicationMatch == true && $locationMatch == true) {
                        if ($job_date >= $date_today) {
                            $search_result[] = $arr;
                        }
                    }
                }
            }
            if (empty($search_result)) {
                echo "No jobs found matching the search criteria.";
            } else {
                usort($search_result, 'dateCompare');
                foreach ($search_result as $job) {
                    displayJob($job);
                    echo '-----------------------------------------------------';
                }
            }
        }

    } else {
        echo "Please enter the title";
    }

    //compare date function
    function dateCompare($a, $b)
    {
        $element1 = date_timestamp_get(date_create_from_format("d/m/y", $a[3]));
        $element2 = date_timestamp_get(date_create_from_format("d/m/y", $b[3]));
        return $element2 - $element1;
    }

    //display results
    function displayJob($arr)
    {
        echo "<div style='margin-left: 50px; margin-top: 20px; margin-bottom: 20px;'>";
        echo '<h4 style="color:red">' . $arr[1] . ' Information:</h4>';
        echo "Job Title: " . $arr[1] . "</br>";
        echo "Description: " . $arr[2] . "</br>";
        echo "Closing Date: " . $arr[3] . "</br>";
        echo "Position: " . $arr[4] . "</br>";
        echo "Contract: " . $arr[5] . "</br>";
        echo "Application by: " . $arr[6] . "</br>";
        echo "Location: " . $arr[7] . "</br>";
        echo "</div>";
    }

    ?>
    <div class="url">
        <p><a href="searchjobform.php">Search for another job vacancy</a></p>
        <p><a href="index.php">Return to Home Page</a></p>
    </div>
</body>

</html>