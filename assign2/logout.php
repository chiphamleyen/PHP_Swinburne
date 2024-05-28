<?php
session_start();
$_SESSION["login_status"] = false;
session_unset();
session_destroy();
header("location: index.php");
exit();
?>