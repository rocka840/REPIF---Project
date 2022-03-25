<!DOCTYPE html>   
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Technician Configuration Page </title>
<link rel='stylesheet' type='text/css' media='screen' href='Login.css'>
</head>

<body>

    <h1>Technician Configuration Pages</h1>
    <?php
    include_once("technav.php");

    if(isset($_POST["logout"])){
        session_unset();
        session_destroy();
        $_SESSION["isUserLoggedIn"] == false;
    }
    ?>

    <p>Logout Section</p>
    <form method="POST">
        <input type="submit" value="logout" name="LogOut">
    </form>

</body>
</html>