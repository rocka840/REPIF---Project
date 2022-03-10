<!DOCTYPE html>   
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Login Page </title>
<link rel='stylesheet' type='text/css' media='screen' href='Login.css'>
</head>

<body>

    <?php
    include_once("repif_db.php");

    $sql = $connection->prepare("SELECT * from users");
    $sql->execute();
    $result = $sql->get_result();

    while($row=$result->fetch_assoc()){
        print $row;
    }

    ?>

</body>
</html>