<!DOCTYPE html>   
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Login Page </title>
<link rel='stylesheet' type='text/css' media='screen' href='Login.css'>
</head> 

<body>    

    <?php
        include_once "repif_db.php";

        session_unset();
        session_destroy();
        $_SESSION["isUserLoggedIn"] = false;

        if(isset($_POST["LastName"], $_POST["FirstName"],$_POST["Psw"])){
           $sql = $connection->prepare("Select * from User where LastName, FirstName, Email, Psw = ????");
           if(!$sql){
               die("Error in your sql");
           }

           $sql->bind_param("ssss", $_POST["LastName"], $_POST["FirstName"], $_POST["Psw"]);
           if(!$sql->execute()){
                die("Error execute sql statement");
           }

           $result = $sql->get_result();

           if($result->num_rows==0){
               print "Your username is not in our database";
           } else {
               $row = $result->fetch_assoc();

               if(password_verify($_POST["Psw"])){
                   print "You typed the correct password. You are now logged in";
                   $_SESSION["isUserLoggedIn"] = true;
                   $_SESSION["CurrentUser"] = $_POST[""]
                   $_SESSION["UserRole"] = $row["UserRole"];
               } else {
                   print "Wrong password"
               }
            }
           
            ?>

                <h1>Log-In into Database of User - REPIF</h1>

                <form method="POST" action="UsersPage.php">  
                    <div class="container">   
                        <label>Last Name:</label>   
                        <input type="text" name="LastName" required>
                        <label>First Name:</label>   
                        <input type="text" name="FirstName" required>
                        <label>Technician?</label>
                        <input type="checkbox" name="Tech">
                        <br>
                        <label>Email:</label>   
                        <input type="text" name="Email" required>
                        <label>Password:</label>   
                        <input type="password" placeholder="Enter Password" name="Psw" required>
                        <button type="submit">Login</button> 
                    </div>   
                </form>
</body>

</html>