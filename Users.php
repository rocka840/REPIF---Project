<?php
include_once "repif_db.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Users Configuration</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>

<body>

    <h1>Users</h1>

    <?php
        include_once("technav.php");
        include_once("repif_db.php");

        if(isset($_POST["UserToDelete"])){
            $sqlDelete = $connection->prepare("Delete from Users where UserNo = ?");
            if(!$sqlDelete)
            die("Error in sql delete statement");
            $sqlDelete->bind_param("i", $_POST["UserToDelete"]);
            $sqlDelete->execute();
            $sqlDelete->close();
        }

        if(isset($_POST["UserToEdit"])){
            $sqlEdit = $connection->prepare("Edit from Pins where UserNo = ?");
            if(!$sqlEdit)
            die("Error in sql delete statement");
            $sqlDelete->bind_param("i", $_POST["UserToEdit"]);
            $sqlDelete->execute();
            $sqlDelete->close();
        }

        
        $result = $connection->query("SELECT * from Users");

        if($result){
            while($row = $result->fetch_assoc()){
                ?>
                <table>
                    <tr>
                        <td><?= $row["UserNo"]?></td>
                        <td><?= $row["Name"]?></td>
                        <td><?= $row["FirstName"]?></td>
                        <td><?= $row["Technician"]?></td>
                        <td><?= $row["Email"]?></td>
                        <td><?= $row["Passwd"]?></td>
                        <td><?= $row["HostName"]?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="UserToDelete" value="<?= $row["UserNo"]?>">
                                <input type="submit" value="Remove">
                            </form>
                            <form method="POST">
                                <input type="hidden" name="UserToEdit" value="<?= $row["UserNo"] ?>">
                                <input type="submit" value="Edit">
                            </form>
                        </td>
                    </tr>
                    <?php
            }
        } else {
            print "Something went wrong selecting data";
        }

        if(isset($_POST["UserNo"], $_POST["Name"], $_POST["FirstName"], $_POST["Technician"], $_POST["Email"], $_POST["Passwd"], $_POST["HostName"])){
        $sqlInsert = $connection->prepare("INSERT INTO Users (UserNo, Name, FirstName, Technician, Email, Passwd, HostName) values (?,?,?,?,?,?,?)");
        $sqlInsert->bind_param("issssss", $_POST["UserNo"], $_POST["Name"], $_POST["FirstName"], $_POST["Technician"], $_POST["Email"], $_POST["Passwd"], $_POST["HostName"]);
        $resultOfExecute = $sqlInsert->execute();
        if(!$resultOfExecute){
            print "Adding a new User, failed!";
        }
    }
    ?>
    </table>
    <form method="POST">
        Add a New User: <input name="UserNo" placeholder="nbr">
        <input name="Name" placeholder="LastName">
        <input name="FirstName" placeholder="FirstName">
        <input name="Technician" placeholder="X">
        <input name="Email" placeholder="Email">
        <input name="Passwd" placeholder="Password">
        <input name="HostName" placeholder="SB_nbr">
        <input type="submit" value="Add">
    </form>

</body>

</html>