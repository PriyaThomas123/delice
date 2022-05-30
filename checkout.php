<?php

include 'db_connect.php';

session_start();

$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $address = 'flat no. '. $_POST['flat'] .' '. $_POST['street'] .' '. $_POST['city'] .' '. $_POST['state'] .'  - '. $_POST['pin_code'];
   $placed_on = date('d-M-Y h:i:s');
   $status = "ordered";

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE username = '$user_id'");
   $check = mysqli_num_rows($cart_query)>0;

   if($check){
      while($cart_item = mysqli_fetch_array($cart_query)){
         $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query = mysqli_query($con, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total' AND status='$status' ");
   $checks = mysqli_num_rows($order_query)>0;

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($checks){
      $message[] = 'order placed already!';
   }else{
      $insert_order = mysqli_query($con, "INSERT INTO `orders`(username, name, number, email, address, total_products, total_price, placed_on, status) VALUES('$user_id','$name','$number','$email','$address','$total_products','$cart_total','$placed_on', '$status')");
      
      $delete_cart = mysqli_query($con, "DELETE FROM `cart` WHERE username = '$user_id'");
      $message[] = 'order placed successfully!';
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
   <link rel="stylesheet" href="css/checkout.css">

   <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

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
         <a href="orders.php">orders</a>
      </nav>
   
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <a href="search_page.php" class="fas fa-search"></a>

         <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>

      </div>

      <div class="profile">
         <a href="user_update_profile.php" class="btn">update profile</a>
         <a href="logout.php" class="delete-btn">logout</a>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div>

      
      <?php echo "<h2>".$_SESSION['username']."</h2>"; ?>

   </div>

</header>

<!-- header section ends -->


<!-- display orders amount -->

<section class="display-orders">

   <?php
      $select_cart_items = mysqli_query($con, "SELECT * FROM `cart` WHERE username = '$user_id'");
      $check = mysqli_num_rows($select_cart_items)>0;
      $cart_grand_total = 0;
      $total = 0;

      if($check){
        while($row = mysqli_fetch_assoc($select_cart_items)){
            $cart_total_price = ($row['price'] * $row['quantity']);
            $cart_grand_total = $total += $cart_total_price;
   ?>
   <p> <?php echo $row['name']; ?> <span>(<?= 'Rs.'.$row['price'].'/- x '. $row['quantity']; ?>)</span> </p>
   <?php
    }
   }else{
      echo '<p class="empty">your cart is empty!</p>';
   }
   ?><br>
   <span id="grandtotal"><?php echo $cart_grand_total; ?></span>
</section>



<!-- checkout form starts -->

<section class="checkout-orders">

   <?php
      $user_id = $_SESSION['username'];
      $edit = mysqli_query($con, "SELECT name, email, phone FROM `tbl_register` WHERE username= '$user_id'");
      $row = mysqli_fetch_array($edit);
   ?>

   <form method="POST">

      <h3>place your order</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="enter your name" class="box" required>
         </div>
         <div class="inputBox">
            <span>your phone number :</span>
            <input type="number" name="number" value="<?php echo $row['phone']; ?>" placeholder="enter your number" class="box" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="enter your email" class="box" required>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" required>
         </div>
         <div class="inputBox">
            <span>address line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. Kochi" class="box" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. Kerala" class="box" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?php ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">
   </form>
   <form action="pay.php" method="POST">
      <input type="submit" name="next" class="btn" value="next">
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