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

    <h1>Users - User Configuration Pages</h1>

    <?php
    include_once("usernav.php");
    include_once("repif_db.php");

    if (isset($_POST["UserToEdit"])) {
        $sqlEdit = $connection->prepare("Edit from Pins where UserNo = ?");
        if (!$sqlEdit)
            die("Error in sql edit statement");
        $sqlDelete->bind_param("i", $_POST["UserToEdit"]);
        $sqlDelete->execute();
        $sqlDelete->close();
    }


    $result = $connection->query("SELECT * from Users");

    $UserSmartbox = $connection->prepare("SELECT * from Manage m join SmartBox s on m.HostName = s.HostName where m.UserNo = ?");
    $UserSmartbox->bind_param("i", $_SESSION["UserNo"]);
    $UserSmartbox->execute();
    $result = $UserSmartbox->get_result();
    $UserSmartbox->close();
    print("<table>");
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?= $row["UserNo"] ?></td>
            <td><?= $row["Name"] ?></td>
            <td><?= $row["FirstName"] ?></td>
            <td><?= $row["Technician"] ?></td>
            <td><?= $row["Email"] ?></td>
            <td><?= $row["Passwd"] ?></td>
            <td><?= $row["HostName"] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="UserToEdit" value="<?= $row["UserNo"] ?>">
                    <input type="submit" value="Edit">
                </form>
            </td>
        </tr>

    <?php
    }
    print("</table>");

    if (isset($_POST["UserNo"], $_POST["Name"], $_POST["FirstName"], $_POST["Technician"], $_POST["Email"], $_POST["Passwd"], $_POST["HostName"])) {
        $sqlInsert = $connection->prepare("INSERT INTO Users (UserNo, Name, FirstName, Technician, Email, Passwd, HostName) values (?,?,?,?,?,?,?)");
        $sqlInsert->bind_param("issssss", $_POST["UserNo"], $_POST["Name"], $_POST["FirstName"], $_POST["Technician"], $_POST["Email"], $_POST["Passwd"], $_POST["HostName"]);
        $resultOfExecute = $sqlInsert->execute();
        if (!$resultOfExecute) {
            print "Adding a new User, failed!";
        }
    }
    ?>
    </table>

</body>

</html>