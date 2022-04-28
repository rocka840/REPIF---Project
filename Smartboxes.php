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

    <h1 style="text-align:center" >Smartboxes - Technician Configuration Pages</h1>

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
                        <a href="conf.php?hostname=<?=$row["HostName"]?>" class="link-dark">create config</a>
                    </td>
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
        if (!$resultOfExecute) {
            print "Adding a new smartbox, failed!";
        }
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