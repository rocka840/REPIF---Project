<?php
session_start();
if(!isset($_SESSION["UserLoggedIn"])){
    $_SESSION["UserLoggedIn"] = false;
}

/*if(!isset($_SESSION["Pins"])){
    $_SESSION["Pins"] = [];
}*/

$servername = "192.168.6.55";
$username = "rocka840";
$password = "Passw0rd!";
$dbName = "REPIF_db";

$connection = mysqli_connect($servername, $username, $password, $dbName);

if(!$connection){
    die("Connection failed: " . mysqli_connect_error());
}
?>