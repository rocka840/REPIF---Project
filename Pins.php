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

    if(isset($_POST["pinToDelete"])){
        unset($_SESSION["Pins"][$_POST["pinToDelete"]]);
    }
?>

<table class="pins">
    <tr>
        <th>HostName:</th>
        <th>PinNo:</th>
        <th>Input:</th>
        <th>Designation:</th>
    </tr>

    <?php
        foreach ($_SESSION["Pins"] as $key => $value){
            $sqlSelect = $connection->prepare("INSERT INTO Pins (HostName, PinNo, Input, Designation) values (?,?,?,?)");
            $sqlSelect->bind_param("siis", $key, $value);
            $selectionWentOk = $sqlSelect->execute();

            if($selectionWentOk){
                $result = $sqlSelect->get_result();
                $row = $result->fetch_assoc();

                ?>
                <tr>
                    <td><?= $row["HostName"] ?></td>
                    <td><?= $row["PinNo"]?></td>
                    <td><?= $row["Input"]?></td>
                    <td><?= $row["Designation"]?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="pinToDelete" value="<?= $key ?>">
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