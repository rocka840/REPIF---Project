<?php
include_once "repif_db.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Users Configuration</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>

<body>

    <h1>Users</h1>

    <?php
    include_once("technav.php");
    include_once("repif_db.php");

    ?>

    <table class="users">
        <tr>
            <th>UserNo:</th>
            <th>LastName:</th>
            <th>FirstName:</th>
            <th>Technician:</th>
            <th>Email:</th>
            <th>Password:</th>
            <th>Hostname:</th>
        </tr>

        <?php
        var_dump($_SESSION["Users"]);
        
        foreach ($_SESSION["Users"] as $key => $value) {
            $sqlSelect = $connection->prepare("INSERT INTO User (UserNo, LastName, FirstName, Technician, Email, Passwd, HostName) values (?,?,?,?,?,?,?)");
            $sqlSelect->bind_param("issssss", $key, $value);
            $selectionWentOk = $sqlSelect->execute();

            if ($selectionWentOk) {
                $result = $sqlSelect->get_result();
                $row = $result->fetch_assoc();
        ?>
                <tr>
                    <td><?= $row["UserNo"] ?></td>
                    <td><?= $row["LastName"] ?></td>
                    <td><?= $row["FirstName"] ?></td>
                    <td><?= $row["Technician"] ?></td>
                    <td><?= $row["Email"] ?></td>
                    <td><?= $row["Passwd"] ?></td>
                    <td><?= $row["HostName"] ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="UserToDelete" value="<?= $key ?>">
                            <input type="submit" value="Remove">
                        </form>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
    </table>

</body>

</html>