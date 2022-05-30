<?php
include('db_connect.php'); 


session_start();
if(isset($_SESSION['username'])){
   header("Location: admin_page.php");
}


if(isset($_POST['submit'])){

    //process for login
    //1. Get the data from Login form
    $email = $_POST['email'];
    $password = $_POST['password'];


    //2. SQL to check whether the user with email and password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE email='$email' AND password='$password' ";

    
    //3. Execute the query
    $result = mysqli_query($con, $sql);


    if($result -> num_rows > 0){
        // User available and login success & Redirect to home page
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        header('location:admin_page.php');
    }else{
        // User not available and login fail & Redirect to login page
        header('location:admin_login.php');
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login.css">

</head>
<body>

<!-- header section starts  -->

<header class="header">

   <section class="flex">

      <a href="#home" class="logo"><img src="images/logo.jpg" alt=""></a>

      <nav class="navbar">
         <a href="index.php">Home</a>
         <a href="register.php">Register</a>
      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>

   </section>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<div class="home-bg">

   <section class="home" id="home">

      <div class="content">
         <h3>Tasty Passion</h3>
      </div>

   </section>

</div>

<!-- home section ends -->

<!-- contact section starts  -->

<section class="login" id="login">

   <div class="heading">
      <h3>Login Here</h3>
   </div>

   <div class="row">

      <form action="" name="myform" method="post">
         <input type="email" name="email" id="email" required class="box" placeholder="Enter your email address">
         <input type="password" name="password" id="pass" required class="box" placeholder="Enter your password">
         <input type="submit" name="submit" value="login" class="btn">
      </form>

   </div>

</section>

<!-- contact section ends -->

<!-- footer section starts  -->

<section class="footer">

   <div class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>mr. web designer</span> | all rights reserved! </div>

</section>

<!-- footer section ends -->



<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>