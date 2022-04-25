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
    include_once("usernav.php");
    include_once("repif_db.php");

    $result = $connection->query("SELECT * from Script");

    if (isset($_POST["scriptToDelete"])) {
        $sqlDelete = $connection->prepare("Delete from Script where ScriptName = ?");
        if (!$sqlDelete)
            die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["scriptToDelete"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }


    if (isset($_POST["scriptToEdit"])) {

        $editPinVal = intval($_POST["scriptToEdit"]);
        $sqlSelect = $connection->prepare("SELECT * FROM Script WHERE ScriptNo=?");
        $sqlSelect->bind_param("i", $editPinVal);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

    ?>
        <form method="POST">

            <div>
                <label>ScriptName</label>

                <select name="ScriptNameEdit">
                    <?php
                    $sqlSelect = $connection->prepare("SELECT ScriptName FROM Script");
                    $sqlSelect->execute();
                    $result = $sqlSelect->get_result();

                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <option <?php if ($data[0]["ScriptName"] == $row["ScriptName"]) {
                                    print " selected ";
                                } ?>value="<?= $row["ScriptName"] ?>"><?= $row["ScriptName"] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div>
                <label>Path</label>
                <input type="text" name="pathEdit" value="<?= $data[0]["Path"] ?>">
                <input type="hidden" name="pathSearch" value="<?= $data[0]["Path"] ?>">
            </div>

            <div>
                <label>Description</label>
                <input type="text" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
            </div>

            <button type="submit">Submit</button>

        </form>
    <?php
    }

    if (!empty($_POST["ScriptNameEdit"]) && !empty($_POST["pathEdit"]) && !empty($_POST["descriptionEdit"])) { //update

        $sqlUpdate = $connection->prepare("UPDATE Script SET ScriptName=?, Path=?, Description=? where ScriptName=?");

        if (!$sqlUpdate) {
            die("Error: the pins cannot be updated");
        }

        $sqlUpdate->bind_param("iss", $_POST["ScriptNameEdit"], $_POST["pathEdit"], $_POST["descriptionEdit"]);
        $sqlUpdate->execute();

        header("refresh: 0");
    }

    $UserSmartbox = $connection->prepare("SELECT * from Manage m join SmartBox s on m.HostName = s.HostName where m.UserNo = ?");
    $UserSmartbox->bind_param("i", $_SESSION["UserNo"]);
    $UserSmartbox->execute();
    $result = $UserSmartbox->get_result();
    $UserSmartbox->close();
    print("<table>");
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?= $row["ScriptName"] ?></td>
            <td><?= $row["Path"] ?></td>
            <td><?= $row["Designation"] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="scriptToDelete" value="<?= $row["PinNo"] ?>">
                    <input type="submit" value="Remove">
                </form>
                <form method="POST">
                    <input type="hidden" name="scriptToEdit" value="<?= $row["PinNo"] ?>">
                    <input type="submit" value="Edit">
                </form>
            </td>
        </tr>

    <?php
    }
    print("</table>");

    if (isset($_POST["ScriptName"], $_POST["Path"], $_POST["Description"])) {
        $sqlInsert = $connection->prepare("INSERT INTO Script (ScriptName, Path, Description) values (?,?,?)");
        $sqlInsert->bind_param("sss", $_POST["ScriptName"], $_POST["Path"], $_POST["Description"]);
        $resultOfExecute = $sqlInsert->execute();
        if (!$resultOfExecute) {
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