<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Smartboxes Configuration</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>

<body>

    <h1>Smartboxes - User Configuration Pages</h1>

    <?php
    include_once("repif_db.php");
    include_once ("usernav.php");

    $UserSmartbox = $connection->prepare("SELECT * from Manage m join SmartBox s on m.HostName = s.HostName where m.UserNo = ?");
    $UserSmartbox->bind_param("i",$_SESSION["UserNo"]);
    $UserSmartbox->execute();
    $result = $UserSmartbox->get_result();
    $UserSmartbox->close();
    print("<table>");
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?= $row["Description"] ?></td>
            <td><?= $row["Location"] ?></td>
        </tr>

    <?php
    }
    print("</table>");


    ?>
        
</body>

</html>