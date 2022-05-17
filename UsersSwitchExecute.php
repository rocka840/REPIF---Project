<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Smartboxes Configuration</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <h1 style="text-align:center">Switch-Execute - User Configuration Pages</h1>

    <?php
    include_once("usernav.php");
    include_once("repif_db.php");

    $result = $connection->query("SELECT * from Switch_Execute");

    if (isset($_POST["switchexecuteToDelete"])) {
        $sqlDelete = $connection->prepare("Delete from Switch_Execute where TargetFunctionCode = ?");
        if (!$sqlDelete)
            die("Error in sql delete statement");
        $sqlDelete->bind_param("s", $_POST["switchexecuteToDelete"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if (isset($_POST["switchexecuteToEdit"])) {
        $sqlEditSwitchExecute = $_POST["switchexecuteToEdit"];
        $sqlSelect = $connection->prepare("SELECT * FROM Switch_Execute WHERE TargetFunctionCode=?");
        $sqlSelect->bind_param("s", $sqlEditSwitchExecute);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
    ?>
        <form method="POST">
            <div>
                <label>HostName</label>
                <input type="text" name="hostnameEdit" value="<?= $data[0]["HostName"] ?>">
                <input type="hidden" name="hostnameSearch" value="<?= $data[0]["HostName"] ?>">
            </div>

            <div>
                <label>PinNo</label>
                <input type="text" name="pinnoEdit" value="<?= $data[0]["PinNo"] ?>">
                <input type="hidden" name="pinnoSearch" value="<?= $data[0]["PinNo"] ?>">
            </div>
            <div>
                <label>EventCode</label>
                <input type="text" name="eventcodeEdit" value="<?= $data[0]["EventCode"] ?>">
                <input type="hidden" name="eventcodeSearch" value="<?= $data[0]["EventCode"] ?>">
            </div>
            <div>
                <label>GroupNo</label>
                <input type="text" name="groupnoEdit" value="<?= $data[0]["GroupNo"] ?>">
                <input type="hidden" name="eventcodeSearch" value="<?= $data[0]["GroupNo"] ?>">
            </div>
            <div>
                <label>TargetFunctionCode</label>
                <input type="text" name="targetfunctioncodeEdit" value="<?= $data[0]["TargetFunctionCode"] ?>">
                <input type="hidden" name="eventcodeSearch" value="<?= $data[0]["TargetFunctionCode"] ?>">
            </div>
            <div>
                <label>Description</label>
                <input type="text" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
                <input type="hidden" name="descriptionSearch" value="<?= $data[0]["Description"] ?>">
            </div>
            <div>
                <label>SequenceNo</label>
                <input type="text" name="sequencenoEdit" value="<?= $data[0]["SequenceNo"] ?>">
                <input type="hidden" name="sequencenoSearch" value="<?= $data[0]["SequenceNo"] ?>">
            </div>
            <div>
                <label>WaitingDuration</label>
                <input type="text" name="waitingdurationEdit" value="<?= $data[0]["WaitingDuration"] ?>">
                <input type="hidden" name="waitingdurationSearch" value="<?= $data[0]["WaitingDuration"] ?>">
            </div>
            <button type="submit">Submit</button>
        </form>
        <?php
        }
    
        if(isset($_POST["hostnameEdit"], $_POST["pinnoEdit"], $_POST["eventcodeEdit"], $_POST["groupnoEdit"], $_POST["targetfunctioncodeEdit"], $_POST["descriptionEdit"], $_POST["sequencenoEdit"], $_POST["waitingdurationEdit"], )){
            $sqlUpdate = $connection->prepare("UPDATE Switch_Execute SET HostName=?, PinNo=?, EventCode=?, GroupNo=?, TargetFunctionCode=?, Description=?, SequenceNo=?, WaitingDuration=? WHERE TargetFunctionCode = ?");

            if(!$sqlUpdate){
                die("Group couldnt be updated");
            }
            
            $sqlUpdate->bind_param("sisissiis", $_POST["hostnameEdit"], $_POST["pinnoEdit"], $_POST["eventcodeEdit"], $_POST["groupnoEdit"], $_POST["targetfunctioncodeEdit"], $_POST["descriptionEdit"], $_POST["sequencenoEdit"], $_POST["sequencenoEdit"], $_POST["waitingdurationEdit"], $_POST["targetfunctioncodeEdit"]);
            $sqlUpdate->execute();

            header("refresh: 0");
        }

        $sqlSelect = $connection->prepare("SELECT * from Users u JOIN Switch_Execute s ON u.HostName = s.HostName where s.HostName = ?");
        $sqlSelect->bind_param("i", $_SESSION["CurrentUser"]);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();

        if ($result) {
        while ($row = $result->fetch_assoc()) {
        ?>
        <table class="table table-hover table-success">
            <tr>
                <th>HostName</th>
                <th>PinNo</th>
                <th>EventCode</th>
                <th>GroupNo</th>
                <th>TargetFunctionCode</th>
                <th>Description</th>
                <th>SequenceNo</th>
                <th>WaitingDuration</th>
                <th>Buttons</th>
            </tr>
            <tr>
                <td><?= $row["HostName"] ?></td>
                <td><?= $row["PinNo"] ?></td>
                <td><?= $row["EventCode"] ?></td>
                <td><?= $row["GroupNo"] ?></td>
                <td><?= $row["TargetFunctionCode"] ?></td>
                <td><?= $row["Description"] ?></td>
                <td><?= $row["SequenceNo"] ?></td>
                <td><?= $row["WaitingDuration"] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="switchexecuteToDelete" value="<?= $row["TargetFunctionCode"] ?>">
                        <input type="submit" value="Remove" class="btn btn-outline-dark">
                    </form>
                    <form method="POST">
                        <input type="hidden" name="switchexecuteToEdit" value="<?= $row["TargetFunctionCode"] ?>">
                        <input type="submit" value="Edit" class="btn btn-outline-dark">
                    </form>
                </td>
            </tr>
    <?php
                    }
                } else {
                    print "Something went wrong with selecting data";
                }

                if (isset($_POST["HostName"], $_POST["PinNo"], $_POST["EventCode"],  $_POST["GroupNo"], $_POST["TargetFunctionCode"], $_POST["Description"], $_POST["SequenceNo"], $_POST["WaitingDuration"])) {
                    $sqlInsert = $connection->prepare("INSERT INTO Switch_Execute (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, Description, SequenceNo, WaitingDuration) values(?,?,?,?, ?, ?, ?, ?)");
                    $sqlInsert->bind_param("siss", $_POST["HostName"], $_POST["PinNo"], $_POST["EventCode"], $_POST["GroupNo"], $_POST["TargetFunctionCode"], $_POST["Description"], $_POST["SequenceNo"], $_POST["WaitingDuration"]);
                    $resultOfExecute = $sqlInsert->execute();
                    if (!$resultOfExecute) {
                        print "Adding a new event, failed!";
                    }
                }
    ?>
        </table>
        <form method="POST">
            Add a New Switch-Execute: <input name="HostName" placeholder="SB_nbr">
            <input name="PinNo" placeholder="nbr">
            <input name="EventCode" placeholder="letter">
            <input name="GroupNo" placeholder="nbr">
            <input name="TargetFunctionCode" placeholder="letter">
            <input name="Description" placeholder="Press light switch briefly">
            <input name="SequenceNo" placeholder="nbr">
            <input name="WaitingDuration" placeholder="nbr">
            <input type="submit" value="Add">
        </form>
</body>

</html>