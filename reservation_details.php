<?php

include 'db_connect.php';

session_start();

$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header('location:login.php');
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
   <link rel="stylesheet" href="css/orders.css">

   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--JS function of button to save html to pdf-->


</head>
<body>

<!-- header section starts  -->

<header class="header">

   <div class="flex">

      <a href="#home" class="logo"><img src="images/logo.jpg" alt=""></a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="menu.php">menu</a>
         <a href="reservation.php">reservation</a>
         <a href="track-order.php">track order</a>
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


<section class="placed-orders">

   <h1 class="title">reservation details</h1>

   <div class="box-container">

   <?php
      $select_orders = mysqli_query($con, "SELECT * FROM `reservation` WHERE username = '$user_id'");
      $check = mysqli_num_rows($select_orders)>0;

      if($check){
        while($fetch_orders = mysqli_fetch_array($select_orders)){ 
   ?>
   <div class="box" id="invoice">
      <p> Username : <span><?php echo $fetch_orders['username']; ?></span> </p>
      <p> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
      <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
      <p> number : <span><?php echo $fetch_orders['phone']; ?></span> </p>
      <p> Date : <span><?php echo $fetch_orders['date']; ?></span> </p>
      <p> Time : <span><?php echo $fetch_orders['time']; ?></span> </p>
      <p> Status : <span><?php echo $fetch_orders['status']; ?></span> </p>
      <button class="fcc-btn">Cancel</button>
   </div>
   
   <?php
      }
   }else{
      echo '<p class="empty">not reserved yet!</p>';
   }
   ?>

   </div>

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