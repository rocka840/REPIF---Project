<?php
include "db_conn.php";
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Smart-Home</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans&display=swap" rel="stylesheet">
    <link rel='stylesheet' type='text/css' media='screen' href='admin.css'>
    <script src='main.js'></script>
</head>

<body>
    <h1 class="headlinex">Smartbox-Home</h1>
    <div id="displayBox">

        <div id="NavB">
            <form action="logout.php" method="POST">
                <a class="styleNavBLink" href="userList.php">Users</a>
                <a class="styleNavBLink" href="smartBox.php">Smartbox</a>
                <a class="styleNavBLink" href="Script.php">Script</a>
                <a class="styleNavBLink" href="overview.php">Overview</a>
                <a class="styleNavBLink"> <input class="Link" type="submit" value="Logout" name="btnDelete"><a>
            </form>
        </div>
        </br>
        </br>
        <div id="addSmartbox">
            <form method="POST">

                <label for="UserName">Name:</label> <input style="margin:2px; padding:5px;margin-left:51px" name="HostName"><br>
                <label for="UserName">Location:</label> <input style="margin:2px; padding:5px;margin-left:33px" name="Location"><br>
                <label for="UserName">Description:</label> <input style="margin:2px; padding:5px;margin-left:12px" name="Description"><br>
                <input type="hidden" name="addSmartBox">

                <input type="submit" value="Add" style="padding:10px; margin-left:210px;">
            </form>

            <form method="POST">
                <label for="UserName">ID:</label> <input style="margin:2px; padding:5px;margin-left:78px" name="SBNO"><br>
                <label for="UserName">Name:</label> <input style="margin:2px; padding:5px;margin-left:51px" name="HostName"><br>
                <label for="UserName">Location:</label> <input style="margin:2px; padding:5px;margin-left:33px" name="Location"><br>
                <label for="UserName">Description:</label> <input style="margin:2px; padding:5px;margin-left:12px" name="Description"><br>
                <input type="hidden" name="updateSmartBox">

                <input type="submit" value="update" style="padding:10px; margin-left:192px;">
            </form>
        </div>
        <?php
        //.............................................! Add
        if (isset($_POST["addSmartBox"])) {
            if (
                isset($_POST["HostName"], $_POST["Description"], $_POST["Location"]) &&
                (empty($_POST['HostName']) ||
                    empty($_POST['Description']) ||
                    empty($_POST['Location']))
            ) {
                echo "Error to Add User pls check Insert Again!";
            } else {
                if (isset($_POST["HostName"], $_POST["Description"], $_POST["Location"])) {
                    $sql = $conn->prepare("INSERT INTO smartbox  (HostName, Description, Location) VALUES (?,?,?)");
                    if (!$sql) {
                        die("Error in your sql");
                    }

                    $sql->bind_param("sss", $_POST["HostName"], $_POST["Description"], $_POST["Location"]);
                    if (!$sql->execute()) {

                        die("Error execute sql statement");
                    } else {
                        echo "User Added!";
                    }
                }
            }
            //.............................................! Update
        } else if (isset($_POST["updateSmartBox"])) {
            if (
                isset($_POST["SBNO"], $_POST["HostName"], $_POST["Description"], $_POST["Location"]) &&
                (empty($_POST['SBNO']) ||
                    empty($_POST['HostName']) ||
                    empty($_POST['Description']) ||
                    empty($_POST['Location']))
            ) {
                echo "Error to Add update!";
            } else {
                if (isset($_POST["HostName"], $_POST["Description"], $_POST["Location"])) {
                    $sqlupdate = $conn->prepare("UPDATE smartbox SET HostName=?,Description=?, Location=? WHERE SBNO=?;");
                    $sqlupdate->bind_param("sssi", $_POST["HostName"], $_POST["Location"], $_POST["Description"], $_POST["SBNO"]);
                    if (!$sqlupdate->execute()) {
                        die("Error execute sql statement");
                    } else {
                        echo "User Added!";
                    }
                }
            }
        }
        ?>
        <table id="tablelogin">
            <tr>
                <th id="itemTable">Id</th>
                <th id="itemTable">Name</th>
                <th id="itemTable">Location</th>
                <th id="itemTable">Description</th>

                <?php
                if (isset($_POST["ProductToDelete"])) {
                    $sqlDelete = $conn->prepare("Delete from smartbox where SBNO=?");
                    if (!$sqlDelete)
                        die("Error in sql delete statement");
                    $sqlDelete->bind_param("i", $_POST["ProductToDelete"]);
                    $sqlDelete->execute();
                }
                ?>

                <?php
                $sqlSelect = $conn->prepare("SELECT * from smartbox");
                $selectionWentOK = $sqlSelect->execute();

                if ($selectionWentOK) {

                    $result = $sqlSelect->get_result();
                    while ($row = $result->fetch_assoc()) {
                ?>
            <tr>
                <td id="itemTable"><?= $row["SBNO"] ?></td>
                <td id="itemTable"><?= $row["HostName"] ?></td>
                <td id="itemTable"><?= $row["Description"] ?></td>
                <td id="itemTable"><?= $row["Location"] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="ProductToDelete" value="<?= $row['SBNO'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            <?php
                    }
            ?>
            </tr>
        <?php
                } else {
                    print "Something went wrong when selecting data";
                }
        ?>
        </table>



</body>

</html>