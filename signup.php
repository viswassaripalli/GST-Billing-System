<?php
include_once("database.php");
$emailer=$passer="";
if(isset($_POST['submit']))
{
   
    $name=$_POST['name'];
    $email=$_POST['email'];
    $cname=$_POST['cname'];
    $gstin=$_POST['gst'];
    $pass=$_POST['pass'];
    $cpass=$_POST['cpass'];
  
    
    
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    
       $query=$conn->prepare("SELECT email FROM login WHERE email='$email'");
       $result=$query->execute();
       $count= $query->rowCount();
       if($count==1)
       {
           $emailer="email already exists";
       }
    
    }else
    {
        $emailer="invalid email";
    echo $emailer;  
}
if($pass!==$cpass){
    $passer="password doesnt match";
}
if($emailer=="" && $passer=="")
{ 
    
    $query = $conn->prepare("INSERT INTO login (name,email,company_name,gstin,password) VALUES('$name','$email','$cname','$gstin','$pass')");
    $result=$query->execute();
  if($result==1)
  {
    header('Location: login.php');
  }
    

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
<link rel="stylesheet" href="signup.css">

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
    <h1>Sign up</h1>
    <form action="signup.php" method="POST">
             <h2>Name</h2>
             <input type="text" name="name" id="name" required>
             <h2>Email</h2>
             <input type="email" name="email" id="email" required>
            <p id="error">* <? if($emailer!=""){
                 echo  $emailer;
             } ?></p>
             <h2>Company name</h2>
             <input type="text" name="cname" id="cname" required>
             <h2>GSTIN number</h2>
             <input type="text" name="gst" id="gst" required >
             <h2>Password</h2>
             <input type="password" name="pass" id="pass" required>
             <p id="error"> *<? if($passer!=""){
                 echo  $passer;
             } ?></p>
             <h2> confirm password</h2>
             <input type="password" name="cpass" id="cpass" required>
<input type="submit" name="submit" value="Signup" id="btn">

    </form>
</div>
</div>

</body>
</html>