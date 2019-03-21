<?php 
include_once("database.php");
session_start();
 if($_SESSION["logged_in"]!="true")
 {
     header('Location: login.php');
 }
$emailid=$_GET['email'];
$sth = $conn->prepare('SELECT * FROM login
    WHERE email = ?');
$sth->bindValue(1, $_GET['email']);
$sth->execute();
$result= $sth->fetch();

$cname = $result[2];
$gstin = $result[3];
if(isset($_POST['submit']))
{
  $sth = $conn->prepare('SELECT * FROM login
  WHERE email = ?');
$sth->bindValue(1, $_GET['email']);
$sth->execute();
$result= $sth->fetch();

$cname = $result[2];
$gstin = $result[3];
$custname = $_POST['custname'];
$custemail = $_POST['custemail'];
$phone = $_POST['phone'];
$proname=$_POST['proname'];
$price= $_POST['price'];
$quantity = $_POST['quantity'];
$discount = $_POST['discount'];
$gst = $_POST['gst'];
$discount = ($price * $discount)/100;
$tax = ($price  * $gst)/100;
$total= ($price - $discount + $tax) *$quantity;
}
$url= "invoice.php?email=$emailid";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GST Billing system</title>
    <script src="jquery-1.10.2.js"></script>
    <script src="jquery.PrintArea.js"></script>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="invoice.css">

    
</head>
<body>

<nav class="navbar  navbar-default ">
  <div class="container-fluid nav">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"  style="color:white;margin-left:10px;">GST Billing System</a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"  style="color:white">logout</a></li>
      
    </ul>
  </div>
</nav>
<div class="container-fluid" >
    <span id="cname"><? echo $cname?></span>
    <span id="gstin">GSTIN:<? echo $gstin?></span>

<div class="forms">
<form action="<? echo $url?>" method="post">
<div class="form1">

<h2>customer name</h2>
<input type="text" name="custname" id="custname">
<h2>customer Email</h2>
<input type="email" name="custemail" id="custemail">
<h2>customer Mobile no</h2>
<input type="tel" id="phone" name="phone"
       pattern="[0-9]{10}"
       required>


<!-- </form> -->
</div>
<div class="form2">
<!-- <form action="#" method="post"> -->
<h2>Product name :</h2> <input type="text" name="proname" id="proname"><br>
<h2>Quantity :</h2> <input type="number" name="quantity" id="quantity"><br>
<h2>Price : </h2><input type="number" name="price" id="price"><br>
<h2>Discount :</h2> <input type="number" name="discount" id="discount"> <br>
<h2>GST% :</h2> <input type="number" name="gst" id="gst"><br>

</div><br>
<div class="form">
<input type="submit" value="Generate Bill" name="submit" class="form3"" >
</div>
</form>
</div>
<br><br><br>
<div id="b">
 <? if(isset($_POST['submit'])){?>
<div class="bill" >
  
<span id="cname"><? echo $cname?></span>
    <span id="gstin">GSTIN:<? echo $gstin?></span><br><br><br><br><br>
    <div class="detail">
    <h2>Customer details</h2>
<h3><? echo $custname?></h3>
<h3><? echo $custemail?></h3>
<h3><?  echo $phone?></h3>
</div><br><br>
<table class="table">
    <thead>
      <tr class="info">
        <th>product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Discount%</th>
        <th>GST%</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <tr class="active">
      <td><?echo $proname?></td>
      <td><?echo $quantity?></td>
      <td><?echo $price?></td>
      <td><?echo $discount?></td>
      <td><?echo $gst?></td>
      <td> <? echo $price."<br><br>"." - ".$discount."<br><br>"."+ ".$tax."<br><br><br>" ?></td>
 </tr>
 <tr class="success">
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td rowspan=5><? echo $total ?> </td>
 </tr>
    </tbody>
  </table>
</div>

 <? } ?> 
 </div>
 <button onclick="printContent('b')">Print Content</button>
</div>



    <script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>

</body>
</html>