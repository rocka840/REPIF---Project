<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Navigation</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>

  <?php
  if (isset($_POST["logout"])) {
    session_start();
    session_unset();
    session_destroy();
    $_SESSION["isUserLoggedIn"] == false;
    header("Location: ../REPIF-Project/Login.php");
    die();
  }
  ?>


  <nav class="navbar navbar-expand-lg navbar-light" style="background-color:papayawhip;">
    <div class="container-fluid">
      <a class="navbar-brand" href="TechPage.php">Home</a>
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="Pins.php">Pins</a>
        <a class="nav-link" href="Smartboxes.php">Smartboxes</a>
        <a class="nav-link" href="Script.php">Scripts</a>
        <a class="nav-link" href="Users.php">Users</a>
      </div>
      <form class="container-fluid justify-content-start" method="POST">
        <input class="btn btn-outline-dark me-2" value="logout" name="logout" type="submit">
      </form>
    </div>
  </nav>
  <br>
</body>

</html>