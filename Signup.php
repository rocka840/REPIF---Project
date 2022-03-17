<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>SignUp for Smartbox</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
<h1>Sign-Up for Smartbox Configuration</h1>
<?php
include_once("technav.php");
?>
<br>
<form method="POST">
<div><label for="UserNo">User Number</label><input name="UserNo"></div>
<div><label for="FirstName">First Name</label><input name="FirstName"></div>
<div><label for="LastName">Last Name</label><input name="LastName"></div>
<div><label for="Technician">Technician</label><input name="Tech" type="checkbox"></div>
<div><label for="Email">Email</label><input name="Email"></div>
<div><label for="Psw">Password</label><input name="Psw" type="password"></div>
<div><label for="SB">SmartBox</label><input name="SB"></div>

<input type="submit" name="submit">
</form>

</body>
</html>