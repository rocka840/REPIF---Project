<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Smartboxes Configuration</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>

<body>

    <h1>Smartboxes</h1>

    <?php
    include_once("technav.php");
    include_once("repif_db.php");

    $result = $connection->query("SELECT * from SmartBox");
    
    if(isset($_POST["smartboxToDelete"])){
        $sqlDelete = $connection->prepare("Delete from Smartbox where HostName = ?");
        if(!$sqlDelete)
        die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["smartboxToDelete"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if(isset($_POST["smartboxToEdit"])){
        $sqlEdit = $connection->prepare("Edit from Pins where PinNo = ?");
        if(!$sqlEdit)
        die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["smartboxToEdit"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if ($result) {
        while ($row = $result->fetch_assoc()) {
    ?>
            <table>
                <tr>
                    <td><?= $row["HostName"] ?></td>
                    <td><?= $row["Description"] ?></td>
                    <td><?= $row["Location"] ?></td>
                </tr>
        <?php
        }
    } else {
        print "Something went wrong with selecting data";
    }

    if(isset($_POST["HostName"], $_POST["Description"], $_POST["Location"])){
        $sqlInsert = $connection->prepare("INSERT INTO SmartBox (HostName, Description, Location) values(?,?,?)");
        $sqlInsert->bind_param("sss", $_POST["HostName"], $_POST["Description"], $_POST["Location"]);
        $resultOfExecute = $sqlInsert->execute();
    }
        ?>
            </table>
        
</body>

</html>