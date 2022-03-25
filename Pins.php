<?php
include_once "repif_db.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Pins Configuration</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>

<body>

    <h1>Pins</h1>

    <?php
    include_once("technav.php");
    $result = $connection->query("SELECT * from Pin");

    if ($result) {
        while ($row = $result->fetch_assoc()) {
    ?>
            <table>
                <tr>
                    <td><?= $row["HostName"] ?></td>
                    <td><?= $row["PinNo"] ?></td>
                    <td><?= $row["Input"] ?></td>
                    <td><?= $row["Designation"] ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="pinToDelete" value="<?= $row["PinNo"] ?>">
                            <input type="submit" value="Remove">
                        </form>
                    </td>
                </tr>
        <?php
        }
    } else {
        print "Something went wrong selecting data";
    }

    if (isset($_POST["HostName"], $_POST["PinNo"], $_POST["Input"], $_POST["Designation"])) {
        $sqlInsert = $connection->prepare("INSERT INTO Pin (HostName, PinNo, Input, Designation) values (?,?,?,?)");
        $sqlInsert->bind_param("siis", $_POST["HostName"], $_POST["PinNo"], $_POST["Input"], $_POST["Designation"]);
        $resultOfExecute = $sqlInsert->execute();
        if (!$resultOfExecute) {
            print "Adding a new pin, failed!";
        }
    }
        ?>

            </table>
            <form method="POST">
                Add a New Pin: <input name="HostName" placeholder="SB_nbr">
                <input name="PinNo" placeholder="nbr">
                <input name="Input" placeholder="1 or 0">
                <input name="Designation" placeholder="GPIOnbr">
                <input type="submit" value="Add">
            </form>


</body>

</html>