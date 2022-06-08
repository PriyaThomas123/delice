<?php 
session_start();
include('db_connect.php');

if(!isset($_SESSION['username'])){
   header("Location: login.php");
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
   <link rel="stylesheet" href="css/track-order-details.css">

    <style>
       table, th, td {
       border: 1px solid black;
       border-collapse: collapse;
    }
    </style>

</head>
<body>

<!-- header section starts  -->

<header class="header">

   <div class="flex">

      <a href="#home" class="logo"><img src="images/logo.jpg" alt=""></a>

      <nav class="navbar">
         <a href="#home">home</a>
         <a href="#about">about</a>
         <a href="menu.php">menu</a>
         <a href="track-order.php">Track Order</a>
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
         <h3>Order #<?php echo $_POST['orderno'];?>details</h3>
      </div>

   </section>

</div>

<!-- home section ends -->

<section class="details">
   <div class="container">
         <div class="content">
         <?php
         $oid= $_POST['orderno'];

         $query = mysqli_query($con,"select * from  orders  where  ordernumber='$oid'");
         $count=1;
              while($row = mysqli_fetch_array($query))
              { ?>   
            <h3>Order #<?php echo $oid; ?>Details</h3>
        </div>
        <table border="1" id="staff">
            <tr>
                <th>Order Number</th>
                <td><?php echo $row['ordernumber'];?></td>
                <th>Order Date/Time</th>
                <td><?php echo $row['placed_on'];?></td>
            </tr>
            <tr>
                <th>Order Status</th>
                <td colspan="3">
                   <?php $status=$row['status'];
                   if($status=='ordered'){
                     echo "Waiting for Restaurant confirmation";   
                    } else{
                    echo $status;
                    }
                    
                    ?> 
                </td>
            </tr>
        </table>
        <?php } ?>
   
   </div>
</section>

<!-- footer section starts  -->

<section class="footer">

   <div class="box-container">

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>our email</h3>
         <p>shaikhanas@gmail.com</p>
         <p>anasbhai@gmail.com</p>
      </div>

      <div class="box">
         <i class="fas fa-clock"></i>
         <h3>opening hours</h3>
         <p>07:00am to 09:00pm</p>
      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>shop location</h3>
         <p>mumbai, india - 400104</p>
      </div>

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>our number</h3>
         <p>+123-456-7890</p>
         <p>+111-222-3333</p>
      </div>

   </div>

   <div class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>mr. web designer</span> | all rights reserved! </div>

</section>

<!-- footer section ends -->



<!-- custom js file link  -->
<script src="js/script2.js"></script>

</body>
</html>