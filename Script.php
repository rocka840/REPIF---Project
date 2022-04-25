<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Script Creation and Input</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    
    <h1>Script - Technician Configuration Pages</h1>

    <?php
    include_once("technav.php");
    include_once("repif_db.php");

    $result = $connection->query("SELECT * from Script");

    if(isset($_POST["scriptToDelete"])){
        $sqlDelete = $connection->prepare("Delete from Pins where ScriptName = ?");
        if(!$sqlDelete)
        die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["scriptToDelete"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if(isset($_POST["scriptToEdit"])){
        $sqlEdit = $connection->prepare("Edit from Pins where ScriptName = ?");
        if(!$sqlEdit)
        die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["scriptToEdit"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if($result){
        while ($row = $result->fetch_assoc()){
            ?>
            <table>
            <tr>
                <td><?= $row["ScriptName"]?></td>
                <td><?= $row["Path"]?></td>
                <td><?= $row["Description"]?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="scriptToDelete" value="<?= ["ScriptName"]?>">
                        <input type="submit" value="Remove">
                    </form>
                    <form method="POST">
                            <input type="hidden" name="scriptToEdit" value="<?= $row["ScriptName"] ?>">
                            <input type="submit" value="Edit">
                    </form>
                </td>
            </tr>
            <?php
        }
    } else {
        print "Something went wrong with selecting data";
    }

    if(isset($_POST["ScriptName"], $_POST["Path"], $_POST["Description"])){
        $sqlInsert = $connection->prepare("INSERT INTO Script (ScriptName, Path, Description) values (?,?,?)");
        $sqlInsert->bind_param("sss", $_POST["ScriptName"], $_POST["Path"], $_POST["Description"]);
        $resultOfExecute = $sqlInsert->execute();
        if(!$resultOfExecute){
            print "Adding a new script, failed";
        }
    }
    ?>

</table>

<form method="POST">
Add a New Script: <input name="ScriptName" placeholder="Dimmer">
<input name="Path" placeholder="/Switch/Dimmer.sh">
<input name="Description" placeholder="Dim Lamp">
<input type="submit" value="Add">
</form>

</body>
</html>