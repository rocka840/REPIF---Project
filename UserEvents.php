<?php
include_once("repif_db.php");
if (isset($_POST["eventToDelete"])) {
    $sqlDelete = $connection->prepare("Delete from Events where EventCode = ?");
    if (!$sqlDelete)
        die("Error in sql delete statement");
    $sqlDelete->bind_param("i", $_POST["eventToDelete"]);
    $sqlDelete->execute();
    $sqlDelete->close();
    header("refresh: 0");
    die();
}

if(isset($_POST["hostnameEdit"], $_POST["pinnoEdit"], $_POST["eventcodeEdit"], $_POST["descriptionEdit"])){
    $sqlUpdate = $connection->prepare("UPDATE Events SET HostName=?, PinNo=?, EventCode=?, HostName=? WHERE EventCode = ?");

    if(!$sqlUpdate){
        die("Group couldnt be updated");
    }
    
    $sqlUpdate->bind_param("sisss", $_POST["hostnameEdit"], $_POST["pinnoEdit"], $_POST["eventcodeEdit"], $_POST["descriptionEdit"], $_POST["eventcodeEdit"]);
    $sqlUpdate->execute();

    header("refresh: 0");
    die();
}
if (isset($_POST["HostName"], $_POST["PinNo"], $_POST["EventCode"], $_POST["Description"])) {
    $sqlInsert = $connection->prepare("INSERT INTO Events (HostName, PinNo, EventCode, Description) values(?,?,?,?)");
    $sqlInsert->bind_param("siss", $_POST["HostName"], $_POST["PinNo"], $_POST["EventCode"], $_POST["Description"]);
    $resultOfExecute = $sqlInsert->execute();
    if (!$resultOfExecute) {
        print "Adding a new event, failed!";
    } else {
        header("refresh: 0");
        die();
    }
}
?>
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

    <h1 style="text-align:center">Events - User Configuration Pages</h1>

    <?php
    include_once("usernav.php");
    
    $result = $connection->query("SELECT * from Events");

    if (isset($_POST["eventToEdit"])) {
        $sqlEditEvent = $_POST["eventToEdit"];
        $sqlSelect = $connection->prepare("SELECT * FROM Events WHERE EventCode=?");
        $sqlSelect->bind_param("i", $sqlEditEvent);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
    ?>
        <form method="POST">
            <div>
                <label>HostName</label>
                <input type="text" name="hostnameEdit" value="<?= $data[0]["HostName"] ?>"disabled>
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
                <label>Description</label>
                <input type="text" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
                <input type="hidden" name="descriptionSearch" value="<?= $data[0]["Description"] ?>">
            </div>
            <button type="submit">Submit</button>
        </form>
        <?php
        die();
        }
    
      

        $sqlSelect = $connection->prepare("SELECT * from Users u JOIN Events e ON u.HostName = e.HostName where e.HostName = ?");
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
                <th>Description</th>
                <th>Buttons</th>
            </tr>
            <tr>
                <td><?= $row["HostName"] ?></td>
                <td><?= $row["PinNo"] ?></td>
                <td><?= $row["EventCode"] ?></td>
                <td><?= $row["Description"] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="eventToDelete" value="<?= $row["EventCode"] ?>">
                        <input type="submit" value="Remove" class="btn btn-outline-dark">
                    </form>
                    <form method="POST">
                        <input type="hidden" name="eventToEdit" value="<?= $row["EventCode"] ?>">
                        <input type="submit" value="Edit" class="btn btn-outline-dark">
                    </form>
                </td>
            </tr>
    <?php
                    }
                } else {
                    print "Something went wrong with selecting data";
                }
    ?>
        </table>
        <form method="POST">
            Add a New Event: <input name="HostName" placeholder="SB_nbr">
            <input name="PinNo" placeholder="nbr">
            <input name="EventCode" placeholder="letter">
            <input name="Description" placeholder="Press light switch briefly">
            <input type="submit" value="Add">
        </form>
</body>

</html>