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
    
    <h1>Script - User Configuration Pages</h1>

    <?php
    include_once("repif_db.php");
    include_once ("usernav.php");

    if(isset($_POST["groupToDelete"])){
        $sqlDelete = $connection->prepare("Delete from Groups where GroupNo = ?");
        if(!$sqlDelete)
        die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["groupToDelete"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if(isset($_POST["groupToEdit"])){
        $sqlEdit = $connection->prepare("Edit from Groups where GroupNo = ?");
        if(!$sqlEdit)
        die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["groupToEdit"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    $UserSmartbox = $connection->prepare("SELECT * from Manage m join SmartBox s on m.HostName = s.HostName where m.UserNo = ?");
    $UserSmartbox->bind_param("i",$_SESSION["UserNo"]);
    $UserSmartbox->execute();
    $result = $UserSmartbox->get_result();
    $UserSmartbox->close();
    print("<table>");
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?= $row["GroupName"] ?></td>
            <td><?= $row["Description"] ?></td>
            <td><?= $row["HostName"] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="groupToDelete" value="<?= $row["PinNo"] ?>">
                    <input type="submit" value="Remove">
                </form>
                <form method="POST">
                    <input type="hidden" name="groupToEdit" value="<?= $row["PinNo"] ?>">
                    <input type="submit" value="Edit">
                </form>
            </td>
        </tr>

    <?php
    }
    print("</table>");

    if(isset($_POST["GroupName"], $_POST["Description"], $_POST["HostName"])){
        $sqlInsert = $connection->prepare("INSERT INTO Groups (GroupName, Description, HostName) values (?,?,?)");
        $sqlInsert->bind_param("sss", $_POST["GroupName"], $_POST["Description"], $_POST["HostName"],);
        $resultOfExecute = $sqlInsert->execute();
        if(!$resultOfExecute){
            print "Adding a new group, failed";
        }
    }
    ?>

</table>

<form method="POST">
Add a New Group: <input name="GroupName" placeholder="Garage">
<input name="Description" placeholder="Garage Door">
<input name="HostName" placeholder="SB_1">
<input type="submit" value="Add">
</form>

</body>
</html>