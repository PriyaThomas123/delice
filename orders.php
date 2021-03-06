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
    <script>
        function generatePDF() {
            const element = document.getElementById('invoice');
            html2pdf().from(element).save("Invoice.pdf");
        }
    </script>

    <style>
        #invoice {
            box-sizing: inherit;        
        }
    </style>

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

   <h1 class="title">placed orders</h1>

   <div class="box-container">

   <?php
      $select_orders = mysqli_query($con, "SELECT * FROM `orders` WHERE username = '$user_id'");
      $check = mysqli_num_rows($select_orders)>0;

      if($check){
        while($fetch_orders = mysqli_fetch_array($select_orders)){ 
   ?>
   <div class="box" id="invoice">
      <h1 itemprop="headline">Order #<?php echo $fetch_orders['ordernumber'];?> Details</h1>
      <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
      <p> Username : <span><?php echo $fetch_orders['username']; ?></span> </p>
      <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
      <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
      <p> flatnumber : <span><?php echo $fetch_orders['flatnumber']; ?></span> </p>
      <p> street : <span><?php echo $fetch_orders['street']; ?></span> </p>
      <p> city : <span><?php echo $fetch_orders['city']; ?></span> </p>
      <p> area : <span><?php echo $fetch_orders['area']; ?></span> </p>
      <p> pincode : <span><?php echo $fetch_orders['pincode']; ?></span> </p>
      <p> orders : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
      <p> total price : <span>Rs.<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
   </div>
   <button onclick="generatePDF()" class="fcc-btn">Invoice</button>
   <?php
      }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
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