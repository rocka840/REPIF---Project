<?php
include_once "repif_db.php";

if(isset($_POST["Email"],$_POST["Psw"])){
   $sql = $connection->prepare("Select * from Users where Email = ?");
   if(!$sql){
       die("Error in your sql");
   }

   $sql->bind_param("s", $_POST["Email"]);
   if(!$sql->execute()){
        die("Error execute sql statement");
   }

   $result = $sql->get_result();

   if($result->num_rows==0){
       die("Your inputted data is not in our database");
   } else {
       $row = $result->fetch_assoc();

       if(password_verify($_POST["Psw"], $row["Passwd"])){
           $_SESSION["isUserLoggedIn"] = true;
           $_SESSION["CurrentUser"] = $_POST["Email"];
           $_SESSION["UserRole"] = $row["UserRole"];
           $_SESSION["UserNo"] = $row["UserNo"];

           if($row["Technician"]=="X"){
            header("Location: TechPage.php");
            die();
        } else {
            header("Location: UsersPage.php");
            die();
        }
        
       } else {
           print "Wrong password";
           var_dump($row["Passwd"]);
       }
    }
   
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Login Page </title>
<link rel='stylesheet' type='text/css' media='screen' href='Login.css'>
</head> 

<body>    
                <h1>Log-In into Database: Technician & User friendly - REPIF</h1>

                <form method="POST">  
                    <div class="container">   
                        <label>Email:</label>   
                        <input type="text" name="Email" required placeholder="example@gmail.com">
                        <label>Password:</label>   
                        <input type="password" placeholder="Enter Password" name="Psw" required>
                        <button type="submit">Login</button> 
                    </div>   
                </form>
</body>

</html>