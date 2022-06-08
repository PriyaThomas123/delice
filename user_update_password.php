<?php 
include 'db_connect.php';
session_start();

$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header("Location: login.php");
};


// change Password
if(isset($_POST['changepassword']))
{
$user_id = $_SESSION['username'];
$cpassword = $_POST['currentpassword'];
$newpassword = $_POST['newpassword'];
$query = mysqli_query($con,"select username from tbl_register where username ='$user_id' and   password='$cpassword'");
$row = mysqli_fetch_array($query);
if($row>0){
$ret = mysqli_query($con,"update tbl_register set password='$newpassword' where username ='$user_id'");
$msg = "Your password successully changed"; 
} else {

$msg="Your current password is wrong";
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
   <link rel="stylesheet" href="css/user_update_password.css">

   <style>
      h4 {
         font-size: 2em;
      }
   </style>

</head>
<body>

<!-- header section starts  -->

<header class="header">

<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

   <div class="flex">

      <a href="#home" class="logo"><img src="images/logo.jpg" alt=""></a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="menu.php">menu</a>
         <a href="reservation.php">reservation</a>
         <a href="track-order,php">track order</a>
         <a href="orders.php">orders</a>
      </nav>
   
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <a href="search_page.php" class="fas fa-search"></a>

         <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>

      </div>

      <div class="profile">
         <a href="user_update_password.php" class="btn">update password</a>
         <a href="reservation_details.php" class="btn">Reservation Details</a>
         <a href="logout.php" class="delete-btn">logout</a>
      </div>

      
      <?php echo "<h2>".$_SESSION['username']."</h2>"; ?>

   </div>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<div class="home-bg">

   <section class="home" id="home">
      <div class="content">
         <h3>Change Password</h3>
      </div>
   </section>

</div>

<!-- home section ends -->

<section class="update-profile">

<form action="" method="POST" name="changepassword">
      <div class="flex">
         <div class="inputBox">
            <span>old password :</span>
            <input type="password" name="currentpassword" id="currentpassword" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" id="newpassword" value="" name="newpassword" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" id="confirmpassword" value="" name="confirmpassword" placeholder="confirm new password" class="box">
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="update password" name="changepassword">
      </div>
   </form>

</section>



<!-- footer section starts  -->

<section class="footer">

   <div class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>mr. web designer</span> | all rights reserved! </div>

</section>

<!-- footer section ends -->



<!-- custom js file link  -->
<script src="js/script2.js"></script>


</body>
</html>