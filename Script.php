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

    <h1 style="text-align:center">Script - Technician Configuration Pages</h1>

    <?php
    include_once("technav.php");
    include_once("repif_db.php");

    $result = $connection->query("SELECT * from Script");

    if (isset($_POST["scriptToDelete"])) {
        $sqlDelete = $connection->prepare("Delete from Pins where ScriptName = ?");
        if (!$sqlDelete)
            die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["scriptToDelete"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if (isset($_POST["scriptnameEdit"], $_POST["pathEdit"], $_POST["descriptionEdit"])) {
        $sqlUpdate = $connection->prepare("UPDATE Script SET ScriptName=?, Path=?, Description=? WHERE ScriptName = ?");
        if (!$sqlUpdate) {
            die("Script couldnt be updated");
        }
        $sqlUpdate->bind_param("ssss", $_POST["scriptnameEdit"], $_POST["pathEdit"], $_POST["descriptionEdit"], $_POST["scriptnameEdit"]);
        $sqlUpdate->execute();

        header("refresh: 0");
    }
    if (isset($_POST["scriptToEdit"])) {
        $sqlEditScript = $_POST["scriptToEdit"];
        $sqlSelect = $connection->prepare("SELECT * FROM Script WHERE ScriptName=?");
        $sqlSelect->bind_param("s", $sqlEditScript);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
    ?>
        <form method="POST">
            <div>
                <label>ScriptName</label>
                <input type="text" name="scriptnameEdit" value="<?= $data[0]["ScriptName"] ?>">
                <input type="hidden" name="scriptnameSearch" value="<?= $data[0]["ScriptName"] ?>">
            </div>
            <div>
                <label>Path</label>
                <input type="text" name="pathEdit" value="<?= $data[0]["Path"] ?>">
                <input type="hidden" name="pathSearch" value="<?= $data[0]["Path"] ?>">
            </div>
            <div>
                <label>Description</label>
                <input type="text" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
                <input type="hidden" name="descriptionSearch" value="<?= $data[0]["Description"] ?>">
            </div>
            <button type="submit">Submit</button>
        </form>
        <?php
        die();
    }
   

    if ($result) {
        while ($row = $result->fetch_assoc()) {
        ?>
            <table class="table table-hover table-success">
                <tr>
                    <th>ScriptName</th>
                    <th>Path</th>
                    <th>Description</th>
                    <th>Buttons</th>
                </tr>
                <tr>
                    <td><?= $row["ScriptName"] ?></td>
                    <td><?= $row["Path"] ?></td>
                    <td><?= $row["Description"] ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="scriptToDelete" value="<?= $row["ScriptName"] ?>">
                            <input type="submit" value="Remove" class="btn btn-outline-dark">
                        </form>
                        <form method="POST">
                            <input type="hidden" name="scriptToEdit" value="<?= $row["ScriptName"] ?>">
                            <input type="submit" value="Edit" class="btn btn-outline-dark">
                        </form>
                    </td>
                </tr>
        <?php
        }
    } else {
        print "Something went wrong with selecting data";
    }

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