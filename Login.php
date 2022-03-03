<!DOCTYPE html>   
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> Login Page </title>   
</head>    
<body>    
   
<?php

if($_SESSION["UserLoggedIn"]){
?>

<center> <h1>Log-In into Database of User - REPIF</h1> </center> 
    <form method="POST">  
        <div class="container">   
            <label>Username : </label>   
            <input type="text" placeholder="Enter Username" name="username" required value="username">  
            <label>Password : </label>   
            <input type="password" placeholder="Enter Password" name="password" required value="psw">  
            <button type="submit">Login</button> 
        </div>   
    </form>    
<?php

}

?>


</body>     
</html>