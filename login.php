<?php
include_once("database.php");
session_start();
$_SESSION["logged_in"] = "green";
$emailer=$passer="";
if(isset($_POST['submit']))
{
   
    
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    
  
    
    
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    
       $query=$conn->prepare("SELECT email FROM login WHERE email='$email'");
       $result=$query->execute();
       $count= $query->rowCount();
       if($count==0)
       {
           $emailer="email  doesnt  exists";
       }
    
    }else
    {
        $emailer="invalid email";
    
}
if($pass!==""){
    $passer="password doesnt match";
}
$sth = $conn->prepare('SELECT *
    FROM login
    WHERE email = ? AND password = ?');
$sth->bindValue(1, $email, PDO::PARAM_STR);
$sth->bindValue(2, $pass, PDO::PARAM_STR);
$sth->execute();
$count= $sth->rowCount();
if($count==1)
{
$_SESSION['logged_in']="true";
$url= "invoice.php?email=$email";
    header('Location:'.$url);
}

}






?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GST Billing system</title>
   
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="login.css">

</head>
<body>

<nav class="navbar  navbar-default ">
  <div class="container-fluid nav">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"  style="color:white;margin-left:10px;">GST Billing System</a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="signup.php"  style="color:white"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="login.php"  style="color:white"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>
<div class="content">
<div class="square">
    <h1>Login</h1>
    <form action="login.php" method="POST">
             
             <h2>Email</h2>
             <input type="email" name="email" id="email" required>
             <p id="error">* <? if($emailer!=""){
                 echo  $emailer;
             } ?></p>
             <h2>Password</h2>
             <input type="password" name="pass" id="pass" required>
<input type="submit" name="submit" value="login" id="btn">

    </form>
</div>
</div>

</body>
</html>