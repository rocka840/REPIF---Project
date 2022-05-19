<?php
include_once("repif_db.php");

if (isset($_POST["HostName"], $_POST["Description"], $_POST["Location"])) {
    $sqlInsert = $connection->prepare("INSERT INTO SmartBox (HostName, Description, Location) values(?,?,?)");
    $sqlInsert->bind_param("sss", $_POST["HostName"], $_POST["Description"], $_POST["Location"]);
    $resultOfExecute = $sqlInsert->execute();
    if (!$resultOfExecute) {
        print "Adding a new smartbox, failed!";
    } else {
        header("refresh: 0");
        die();
    }
}
if (isset($_POST["smartboxToDelete"])) {
    $sqlDelete = $connection->prepare("DELETE from SmartBox where HostName = ?");
    if (!$sqlDelete)
        die("Error in sql delete statement");
    $sqlDelete->bind_param("s", $_POST["smartboxToDelete"]);
    $sqlDelete->execute();
    $sqlDelete->close();
    header("refresh: 0");
    die();
}

if(isset($_POST["hostnameEdit"], $_POST["descriptionEdit"], $_POST["locationEdit"])){
    $sqlUpdate = $connection->prepare("UPDATE SmartBox SET HostName=?, Description=?, Location=? WHERE HostName = ?");

    if(!$sqlUpdate){
        die("SmartBox couldnt be updated");
    }
    
    $sqlUpdate->bind_param("ssss", $_POST["hostnameEdit"], $_POST["descriptionEdit"], $_POST["locationEdit"], $_POST["hostnameEdit"]);
    $sqlUpdate->execute();

    header("refresh: 0");
    die();
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

    <h1 style="text-align:center">Smartboxes - Technician Configuration Pages</h1>

    <?php
    include_once("technav.php");
    
    
    $result = $connection->query("SELECT * from SmartBox");

    if (isset($_POST["smartboxToEdit"])) {
        $sqlEditSmartbox = $_POST["smartboxToEdit"];
        $sqlSelect = $connection->prepare("SELECT * FROM SmartBox WHERE HostName=?");
        $sqlSelect->bind_param("s", $sqlEditSmartbox);
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
                <label>Description</label>
                <input type="text" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
                <input type="hidden" name="descriptionSearch" value="<?= $data[0]["Description"] ?>">
            </div>
            <div>
                <label>Location</label>
                <input type="text" name="locationEdit" value="<?= $data[0]["Location"] ?>">
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
                <th>HostName</th>
                <th>Description</th>
                <th>Location</th>
                <th>Buttons</th>
            </tr>
            <tr>
                <td><?= $row["HostName"] ?></td>
                <td><?= $row["Description"] ?></td>
                <td><?= $row["Location"] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="smartboxToDelete" value="<?= $row["HostName"] ?>">
                        <input type="submit" value="Remove" class="btn btn-outline-dark">
                    </form>
                    <form method="POST">
                        <input type="hidden" name="smartboxToEdit" value="<?= $row["HostName"] ?>">
                        <input type="submit" value="Edit" class="btn btn-outline-dark">
                    </form>
                    <a href="conf.php?hostname=<?= $row["HostName"] ?>" class="link-dark">create config</a>
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
            Add a New Smartbox: <input name="HostName" placeholder="SB_nbr">
            <input name="Description" placeholder="Model letter">
            <input name="Location" placeholder="Building nbr, place">
            <input type="submit" value="Add">
        </form>
</body>

</html>