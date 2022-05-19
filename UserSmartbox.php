<?php
include_once("repif_db.php");
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

    <h1 style="text-align:center">Smartboxes - User Configuration Pages</h1>

    <?php

include_once("usernav.php");

    $sqlSelect = $connection->prepare("SELECT * from Users u JOIN SmartBox s ON u.HostName = s.HostName where s.HostName = ?");
    $sqlSelect->bind_param("i", $_SESSION["CurrentUser"]);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();

        if ($result) {
        while ($row = $result->fetch_assoc()) {
        ?>
        <table class="table table-hover table-success">
            <tr>
                <th>HostName</th>
                <th>Description</th>
                <th>Location</th>
            </tr>
            <tr>
                <td><?= $row["HostName"] ?></td>
                <td><?= $row["Description"] ?></td>
                <td><?= $row["Location"] ?></td>
            </tr>
    <?php
                    }
                } else {
                    print "Something went wrong with selecting data";
                }
    ?>
        </table>
</body>

</html>