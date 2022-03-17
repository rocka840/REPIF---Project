<!DOCTYPE html>   
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Login Page </title>
<link rel='stylesheet' type='text/css' media='screen' href='Login.css'>
</head> 

<body>    

    <h1>Log-In into Database of User - REPIF</h1>

    <form method="POST" action="UsersPage.php">  
        <div class="container">   
            <label>Username : </label>   
            <input type="text" placeholder="Enter Username" name="username" required>  
            <label>Password : </label>   
            <input type="password" placeholder="Enter Password" name="password" required>  
            <button type="submit">Login</button> 
        </div>   
    </form>

</body>

</html>