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
  if (isset($_GET["logout"])) {
    session_start();
    session_destroy();
    $_SESSION["isUserLoggedIn"] == false;
    header("Location: Login.php");
    die();
  }
  ?>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color:papayawhip;">
  <div class="container-fluid">
  <a class="navbar-brand active" href="UsersPage.php">Home</a>
  <div class="navbar-nav">
    <a class="nav-link active" href="UserSmartbox.php">Smartboxes</a>
    <a class="nav-link active" aria-current="page" href="UserPins.php">Pins</a>
    <a class="nav-link active" href="UserEvents.php">Events</a>
        <a class="nav-link active" href="UserGroup.php">Groups</a>
        <a class="nav-link active" href="UsersConcern.php">Concern</a>
        <a class="nav-link active" href="UsersSwitchExecute.php">Switch-Execute</a>
        <a class="nav-link active" href="UsersUser.php">User</a>
        </div>
    <form class="d-flex">
      <input class="btn btn-outline-dark me-2 " value="logout" name="logout" type="submit">
    </form>
  </div>
</nav>
  <br>
</body>

</html>