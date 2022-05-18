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

    <h1 style="text-align:center">Concern - User Configuration Pages</h1>

    <?php
    include_once("usernav.php");
    include_once("repif_db.php");

    $result = $connection->query("SELECT * from Concern");

    if (isset($_POST["concernToDelete"])) {
        $sqlDelete = $connection->prepare("Delete from Concern where GroupNo = ?");
        if (!$sqlDelete)
            die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["concernToDelete"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if(isset($_POST["groupnoEdit"], $_POST["hostnameEdit"], $_POST["pinnoEdit"])){
        $sqlUpdate = $connection->prepare("UPDATE Events SET HostName=?, PinNo=?, EventCode=?, HostName=? WHERE EventCode = ?");

        if(!$sqlUpdate){
            die("Group couldnt be updated");
        }
        
        $sqlUpdate->bind_param("sisss", $_POST["hostnameEdit"], $_POST["pinnoEdit"], $_POST["eventcodeEdit"], $_POST["descriptionEdit"], $_POST["eventcodeEdit"]);
        $sqlUpdate->execute();

        header("refresh: 0");
    }
    if (isset($_POST["concernToEdit"])) {
        $sqlEditConcern = $_POST["concernToEdit"];
        $sqlSelect = $connection->prepare("SELECT * FROM Concern WHERE GroupNo=?");
        $sqlSelect->bind_param("i", $sqlEditConcern);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
    ?>
        <form method="POST">
            <div>
                <label>GroupNo</label>
                <input type="text" name="groupnoEdit" value="<?= $data[0]["GroupNo"] ?>">
                <input type="hidden" name="groupSearch" value="<?= $data[0]["GroupNo"] ?>">
            </div>

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

                if (isset($_POST["HostName"], $_POST["PinNo"], $_POST["EventCode"], $_POST["Description"])) {
                    $sqlInsert = $connection->prepare("INSERT INTO Events (HostName, PinNo, EventCode, Description) values(?,?,?,?)");
                    $sqlInsert->bind_param("siss", $_POST["HostName"], $_POST["PinNo"], $_POST["EventCode"], $_POST["Description"]);
                    $resultOfExecute = $sqlInsert->execute();
                    if (!$resultOfExecute) {
                        print "Adding a new event, failed!";
                    }
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