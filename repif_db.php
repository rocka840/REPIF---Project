<?php
session_start();
if(!isset($_SESSION["UserLoggedIn"])){
    $_SESSION["UserLoggedIn"] = false;
}

/*if(!isset($_SESSION["Pins"])){
    $_SESSION["Pins"] = [];
}*/

$servername = "51.195.102.2";
$username = "Kath";
$password = "omi";
$dbName = "Kath_db";

$connection = mysqli_connect($servername, $username, $password, $dbName);

if(!$connection){
    die("Connection failed: " . mysqli_connect_error());
}
?>