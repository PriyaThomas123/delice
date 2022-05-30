<?php
include 'db_connect.php';

session_start();
if(isset($_SESSION['username'])){
   header("Location: home.php");
}

if(isset($_POST["submit"]))
{
$name = $_POST["name"];
$email = $_POST["email"];
$number = $_POST["number"];
$username = $_POST["username"];
$password = $_POST["password"];
$cpassword = $_POST["cpassword"];

if($password == $cpassword){
   $sql = "SELECT * FROM tbl_register WHERE email = '$email'";
   $result = mysqli_query($con, $sql);
   if(!$result->num_rows > 0){
      $sql = "INSERT INTO tbl_register(name,email,phone,username,password) VALUES ('$name','$email','$number','$username','$password')";
      $result = mysqli_query($con, $sql);
      if($result){
         echo "<script> alert('Registration completed')</script>";
         $name = "";
         $email = "";
         $number = "";
         $username = "";
         $password = "";
      }else{
         echo "<script> alert('Something went wrong.')</script>";
      }
   }else{
      echo "<script> alert('Email already exists..')</script>";
   }
}else{
   echo "<script> alert('Password not matched.')</script>";
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Restaurant</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/register.css">

</head>
<body>

<!-- header section starts  -->

<header class="header">

   <section class="flex">

      <a href="#home" class="logo"><img src="images/logo.jpg" alt=""></a>

      <nav class="navbar">
         <a href="index.php">Home</a>
         <a href="login.php">Login</a>
      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>

   </section>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<div class="home-bg">

   <section class="home" id="home">

      <div class="content">
         <h3>tasty passion</h3>
      </div>

   </section>

</div>

<!-- home section ends -->

<!-- contact section starts  -->

<section class="register" id="register">

   <div class="heading">
      <h3>Register Here</h3>
   </div>

   <div class="row">

      <form action="register.php" name="myform" method="POST">
         <input type="text" name="name" id="name" required class="box"  placeholder="Enter your name" onblur="validation()">
         <font color="red"><p id = "ename"></p></font>
         <input type="email" name="email" id="email" required class="box" placeholder="Enter email address" onblur="validation2()">
         <font color="red"><p id = "eemail"></p></font>
         <input type="text" name="number" id="phone" required class="box" placeholder="Enter your phonenumber" onblur="validation3()">
         <font color="red"><p id = "enum"></p></font>
         <input type="text" name="username" id="uname" required class="box" placeholder="Enter your username" onblur="validation4()">
         <font color="red"><p id = "euname"></p></font>
         <input type="password" name="password" id="pass" required class="box" placeholder="Enter your password" onblur="validation5()">
         <font color="red"><p id = "epass"></p></font>
         <input type="password" name="cpassword" id="cpass" required class="box" placeholder="Enter your confirm password" onblur="validation6()">
         <font color="red"><p id = "ecpass"></p></font>
         <input type="submit" name="submit" value="register" class="btn">
      </form>

   </div>

</section>

<!-- contact section ends -->

<!-- footer section starts  -->

<section class="footer">

   <div class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>mr. web designer</span> | all rights reserved! </div>

</section>

<!-- footer section ends -->


<script>
   function validation(){  
   var name = document.forms["myform"]["name"];  
   var pattern=/^[A-Za-z\s]+$/;
   if(name.value == ""){
      uname="Required field";
      document.getElementById("ename").innerHTML=uname;
      name.focus();
      return false;
   }
   else if(name.value.match(pattern)){
      document.getElementById("ename").innerHTML="";
      document.myform.email.focus();
      return true;
   }
   else{
      document.getElementById("ename").innerHTML="Invalid";
      name.focus();
      return false;
   }
}  

function validation2(){  
var name2 = document.forms["myform"]["email"];  
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if(name2.value == ""){
    uemail="Required field";
    document.getElementById("eemail").innerHTML=uemail;
    name2.focus();
    return false;
  }
  else if(name2.value.match(mailformat)){
    document.getElementById("eemail").innerHTML="";
    document.myform.phone.focus();
    return true;
  }
  else{
    document.getElementById("eemail").innerHTML="Invalid Format";
    name2.focus();
    return false;
  }
}

function validation3()
  {
    var unum = document.forms["myform"]["number"];
    var pwd = /^\+{0,2}([\-\. ])?(\(?\d{0,3}\))?([\-\. ])?\(?\d{0,3}\)?([\-\. ])?\d{3}([\-\. ])?\d{4}/;
            
    if(unum.value == ""){
      document.getElementById("enum").innerHTML="Required field";
      unum.focus();
      return false;
    }
    else if(unum.value.match(pwd)){
      document.getElementById("enum").innerHTML="";
      document.myform.uname.focus();
      return true;
    }
    else{
      document.getElementById("enum").innerHTML="Invalid Format";
      unum.focus();
      return false;
    }
  }

function validation4(){  
   var u_name = document.forms["myform"]["username"];  
   var pattern = /^[a-zA-Z0-9]+$/;
   if(u_name.value == ""){
      uname="Required field";
      document.getElementById("euname").innerHTML=uname;
      u_name.focus();
      return false;
   }
   else if(u_name.value.match(pattern)){
      document.getElementById("euname").innerHTML="";
      document.myform.pass.focus();
      return true;
   }
   else{
      document.getElementById("euname").innerHTML="Invalid";
      u_name.focus();
      return false;
   }
}

function validation5()
  {
    var paswd = document.forms["myform"]["password"];
    var pwd = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,10}$/; //  password between 6 to 10 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character //
            
    if(paswd.value == ""){
      document.getElementById("epass").innerHTML="Required field";
      paswd.focus();
      return false;
    }
    else if(paswd.value.match(pwd)){
      document.getElementById("epass").innerHTML="";
      document.myform.cpass.focus();
      return true;
    }
    else{
      document.getElementById("epass").innerHTML="Invalid Format";
      paswd.focus();
      return false;
    }
  }

</script>



</body>
</html>