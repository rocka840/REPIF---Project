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

    <h1 style="text-align:center;">Groups - User Configuration Pages</h1>

    <?php
    include_once("usernav.php");
    include_once("repif_db.php");

    $result = $connection->query("SELECT * from Groups");

    if (isset($_POST["groupToDelete"])) {
        $sqlDelete = $connection->prepare("Delete from Groups where GroupNo = ?");
        if (!$sqlDelete)
            die("Error in sql delete statement");
        $sqlDelete->bind_param("i", $_POST["groupToDelete"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    if (isset($_POST["groupToEdit"])) {
        $sqlEditSmartbox = $_POST["groupToEdit"];
        $sqlSelect = $connection->prepare("SELECT * FROM Groups WHERE GroupNo=?");
        $sqlSelect->bind_param("i", $sqlEditSmartbox);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
    ?>
        <form method="POST">
            <div>
                <label>GroupNo</label>
                <input type="text" name="groupnoEdit" value="<?= $data[0]["GroupNo"] ?>">
                <input type="hidden" name="groupnoSearch" value="<?= $data[0]["GroupNo"] ?>">
            </div>

            <div>
                <label>GroupName</label>
                <input type="text" name="groupnameEdit" value="<?= $data[0]["GroupName"] ?>">
                <input type="hidden" name="groupnameSearch" value="<?= $data[0]["GroupName"] ?>">
            </div>
            <div>
                <label>Description</label>
                <input type="text" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
                <input type="hidden" name="descriptionSearch" value="<?= $data[0]["Description"] ?>">
            </div>
            <div>
                <label>HostName</label>
                <input type="text" name="hostnameEdit" value="<?= $data[0]["HostName"] ?>">
                <input type="hidden" name="hostnameSearch" value="<?= $data[0]["HostName"] ?>">
            </div>
            <button type="submit">Submit</button>
        </form>
        <?php
        }
    
        if(isset($_POST["groupnoEdit"], $_POST["groupnameEdit"], $_POST["descriptionEdit"], $_POST["hostnameEdit"])){
            $sqlUpdate = $connection->prepare("UPDATE Groups SET GroupNo=?, GroupName=?, Description=?, HostName=? WHERE GroupNo = ?");

            if(!$sqlUpdate){
                die("Group couldnt be updated");
            }
            
            $sqlUpdate->bind_param("isssi", $_POST["groupnoEdit"], $_POST["groupnameEdit"], $_POST["descriptionEdit"], $_POST["hostnameEdit"], $_POST["groupnoEdit"]);
            $sqlUpdate->execute();

            header("refresh: 0");
        }

        $sqlSelect = $connection->prepare("SELECT * from Users u JOIN Groups g ON u.HostName = g.HostName where g.HostName = ?");
        $sqlSelect->bind_param("i", $_SESSION["CurrentUser"]);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();

        if ($result) {
        while ($row = $result->fetch_assoc()) {
        ?>
        <table class="table table-hover table-success">
            <tr>
                <th>GroupNo</th>
                <th>GroupName</th>
                <th>Description</th>
                <th>HostName</th>
                <th>Buttons</th>
            </tr>
            <tr>
                <td><?= $row["GroupNo"] ?></td>
                <td><?= $row["GroupName"] ?></td>
                <td><?= $row["Description"] ?></td>
                <td><?= $row["HostName"] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="groupToDelete" value="<?= $row["GroupNo"] ?>">
                        <input type="submit" value="Remove" class="btn btn-outline-dark">
                    </form>
                    <form method="POST">
                        <input type="hidden" name="groupToEdit" value="<?= $row["GroupNo"] ?>">
                        <input type="submit" value="Edit" class="btn btn-outline-dark">
                    </form>
                </td>
            </tr>
    <?php
                    }
                } else {
                    print "Something went wrong with selecting data";
                }

                if (isset($_POST["GroupNo"], $_POST["GroupName"], $_POST["Description"], $_POST["HostName"])) {
                    $sqlInsert = $connection->prepare("INSERT INTO Groups (GroupNo, GroupName, Description, HostName) values(?,?,?,?)");
                    $sqlInsert->bind_param("isss", $_POST["GroupNo"], $_POST["GroupName"], $_POST["Description"], $_POST["HostName"]);
                    $resultOfExecute = $sqlInsert->execute();
                    if (!$resultOfExecute) {
                        print "Adding a new group, failed!";
                    }
                }
    ?>
        </table>
        <form method="POST">
            Add a New Group: <input name="GroupNo" placeholder="nbr">
            <input name="GroupName" placeholder="GARAGE">
            <input name="Description" placeholder="Garage Door">
            <input name="HostName" placeholder="SB_nbr">
            <input type="submit" value="Add">
        </form>
</body>

</html>