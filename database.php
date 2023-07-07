<?php
$hostName = "localhost";
$dbUser ="root";
$dbPassword = "";
$dbname = "login_register";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbname);
if ( !$conn) {
    die("Something went wrong");# code...
}
?>