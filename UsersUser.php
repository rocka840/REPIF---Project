<?php
    include_once("repif_db.php");

  if (isset($_POST["pswdWarning"], $_POST["usernoEdit"], $_POST["nameEdit"], $_POST["firstnameEdit"], $_POST["technicianEdit"], $_POST["emailEdit"], $_POST["passwdEdit"], $_POST["hostnameEdit"])) {
      $sqlUpdate = $connection->prepare("UPDATE Users SET UserNo=?, Name=?, FirstName=?, Technician=?, Email=?, Passwd=?, HostName=? WHERE UserNo = ?");

      if (!$sqlUpdate) {
          die("User couldnt be updated");
      }
      $hashed = password_hash($_POST["passwdEdit"], PASSWORD_DEFAULT);
      $sqlUpdate->bind_param("issssssi", $_POST["usernoEdit"], $_POST["nameEdit"], $_POST["firstnameEdit"], $_POST["technicianEdit"], $_POST["emailEdit"], $hashed, $_POST["hostnameEdit"], $_POST["usernoEdit"]);
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
    <title>Users Configuration</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>

<body>

    <h1 style="text-align:center">Users - User Configuration Pages</h1>

    <?php
   include_once("usernav.php");

    if (isset($_POST["UserToEdit"])) {
        $sqlEditUser = $_POST["UserToEdit"];
        $sqlSelect = $connection->prepare("SELECT * FROM Users WHERE UserNo=?");
        $sqlSelect->bind_param("i", $sqlEditUser);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
    ?>
        <form method="POST">
            <div>
                <label>UserNo</label>
                <input type="text" name="usernoEdit" value="<?= $data[0]["UserNo"] ?>"disabled>
                <input type="hidden" name="usernoSearch" value="<?= $data[0]["UserNo"] ?>">
            </div>
            <div>
                <label>Name</label>
                <input type="text" name="nameEdit" value="<?= $data[0]["Name"] ?>">
                <input type="hidden" name="nameSearch" value="<?= $data[0]["Name"] ?>">
            </div>
            <div>
                <label>FirstName</label>
                <input type="text" name="firstnameEdit" value="<?= $data[0]["FirstName"] ?>">
                <input type="hidden" name="firstnameSearch" value="<?= $data[0]["FirstName"] ?>">
            </div>
            <div>
                <label>Technician</label>
                <input type="text" name="technicianEdit" value="<?= $data[0]["Technician"] ?>"disabled>
                <input type="hidden" name="technicianSearch" value="<?= $data[0]["Technician"] ?>">
            </div>
            <div>
                <label>Email</label>
                <input type="text" name="emailEdit" value="<?= $data[0]["Email"] ?>">
                <input type="hidden" name="emailSearch" value="<?= $data[0]["Email"] ?>">
            </div>
            <div>
                <label>Passwd</label>
                <input type="password" name="passwdEdit">
                <input type="hidden" name="passwdSearch" value="<?= $data[0]["Passwd"] ?>">
            </div>
            <div>
                <label>HostName</label>
                <input type="text" name="hostnameEdit" value="<?= $data[0]["HostName"] ?>" disabled>
                <input type="hidden" name="hostnameSearch" value="<?= $data[0]["HostName"] ?>">
            </div>
            <div>
                <label>Are You Sure You Want A Password Change?????????</label>
                <input type="checkbox" name="pswdWarning">
            </div>
            <button type="submit">Submit</button>
        </form>
        <?php
        die();
    }
 

    $sqlSelect = $connection->prepare("SELECT * FROM Users WHERE Email=?");
    $sqlSelect->bind_param("s", $_SESSION["CurrentUser"]);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();


    if ($result) {
        while ($row = $result->fetch_assoc()) {
        ?>
            <table class="table table-hover table-success">
                <tr>
                    <th>UserNo</th>
                    <th>Name</th>
                    <th>FirstName</th>
                    <th>Technician</th>
                    <th>Email</th>
                    <th>Passwd</th>
                    <th>HostName</th>
                    <th>Buttons</th>
                </tr>
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
                            <input type="submit" value="Edit" class="btn btn-outline-dark">
                        </form>
                    </td>
                </tr>
        <?php
        }
    } else {
        print "Something went wrong selecting data";
    }
        ?>
            

</body>

</html>