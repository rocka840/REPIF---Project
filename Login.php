<!DOCTYPE html>   
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Login Page </title>
<link rel='stylesheet' type='text/css' media='screen' href='Login.css'>
</head> 

<body>    

    <?php
        if(isset($_POST["LastName"], $_POST["FirstName"],$_POST["Psw"])){
           $sqlLog = $connection->prepare("Select * from User where LastName, FirstName, Email, Psw = ????");
           $sqlLog->bind_param("ssss", $_POST["LastName"], $_POST["FirstName"],$_POST["Psw"]);
           $sqlLog->execute();

           if($selectionWentOK){
               $result = $sqlLog->get_result();
               while ($row = $result->fetch_assoc()){
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
                <?php
                
               }
           }
        } else {
            print "Something went wrong when selecting data";
        }
    ?>


    

</body>

</html>