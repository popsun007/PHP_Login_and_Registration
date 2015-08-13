<?php 
session_start();
 ?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <title>Login_Registration</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <style type="text/css">
    	body{
    		width: 970px;
    		margin: 0 auto;
    		font-family: Arial;
    		background-color: lightgrey;
    	}
    </style>
    <body>
       	<h1>Hi~ </h1>
       	<h2><?= $_SESSION['user_name'] ?></h2>
       	<h1> You're Logged in!</h1>
       	<form action="process.php" method="post">
       		<input type="submit" name="log_out" value="Log Out!">
       	</form>
    </body>
</html>