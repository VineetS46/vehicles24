
<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/login.css">

    <style>
      .color{
        height: 100%;
  width: 300%;
  position: absolute;
  left: -100%;
  z-index: -1;
  background: -webkit-linear-gradient(right, #56d8e4, #9f01ea, #56d8e4, #9f01ea);
  transition: all 0.4s;
      }
    </style>
  </head>
  <body>
    <div class="center">
      <input type="checkbox" id="show">
      <label for="show" class="show-btn">View Form</label>
      <div class="container">
        <label for="show" class="close-btn fas fa-times" title="close"></label>
        <div class="text">
Reset Password</div>
<form method="post" autocomplete="off" class="" action="" >
          <div class="data">
            <label for="usernameemail" >Email</label>
            <input type="text" name="email" id = "usernameemail" required value="">
          </div>
<div class="data">
            <label for="password" >Password</label>
            <input type="password" name="pass" id = "password" required value="">
          </div>

<div class="btn">
            <div class="inner">
</div> 
<button  type="submit" name="submit">Reset</button>
          </div>
</form>
</div>
</div>
</body>
</html>
<?php

$a = (isset($_POST['pass']) ? $_POST['pass'] : '');

$b = (isset($_POST['email']) ? $_POST['email'] : '');

$host="localhost";
$user="vinit";
$pass="Vinit_46";
$db="vehicle";

$x=mysqli_connect($host,$user,$pass,$db);


$y="UPDATE tb_user SET password= '$a' where email='$b'";

mysqli_query($x,$y);

if(isset($_POST["submit"]))
   {    
    header("Location: login.php");
   }
 
?>
 

