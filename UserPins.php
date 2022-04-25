<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Pins Configuration</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>

<body>

    <h1>Pins - User Configuration Pages</h1>

    <?php
    include_once "repif_db.php";
    include_once("usernav.php");
    $result = $connection->query("SELECT * from Pin");

    if(isset($_POST["pinToDelete"])){
        $sqlDelete = $connection->prepare("Delete from Pins where PinNo = ?");
        if(!$sqlDelete)
        die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["pinToDelete"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if(isset($_POST["pinToEdit"])){
        $sqlEdit = $connection->prepare("Edit from Pins where PinNo = ?");
        if(!$sqlEdit)
        die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["pinToEdit"]);
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
            <td><?= $row["ScriptName"] ?></td>
            <td><?= $row["Path"] ?></td>
            <td><?= $row["Description"] ?></td>
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

    if (isset($_POST["HostName"], $_POST["PinNo"], $_POST["Input"], $_POST["Designation"])) {
        $sqlInsert = $connection->prepare("INSERT INTO Pin (HostName, PinNo, Input, Designation) values (?,?,?,?)");
        $sqlInsert->bind_param("siis", $_POST["HostName"], $_POST["PinNo"], $_POST["Input"], $_POST["Designation"]);
        $resultOfExecute = $sqlInsert->execute();
        if (!$resultOfExecute) {
            print "Adding a new pin, failed!";
        }
    }
        ?>

            </table>
            <form method="POST">
                Add a New Pin: <input name="HostName" placeholder="SB_nbr">
                <input name="PinNo" placeholder="nbr">
                <input name="Input" placeholder="1 or 0">
                <input name="Designation" placeholder="GPIOnbr">
                <input type="submit" value="Add">
            </form>


</body>

</html>