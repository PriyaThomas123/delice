<?php 
include 'db_connect.php';
session_start();

$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header("Location: login.php");
};


if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_cart_item = mysqli_query($con, "DELETE FROM `cart` WHERE id = '$delete_id'");
    header('location:cart.php');
 }
 
 if(isset($_GET['delete_all'])){
    $delete_cart_item = mysqli_query($con, "DELETE FROM `cart` WHERE username = '$user_id'");
    header('location:cart.php');
 }
 
 if(isset($_POST['update_qty'])){
    $cart_id = $_POST['cart_id'];
    $p_qty = $_POST['p_qty'];
    $update_qty = mysqli_query($con, "UPDATE `cart` SET quantity = $p_qty WHERE id = '$cart_id'");
    $message[] = 'cart quantity updated';
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
   <link rel="stylesheet" href="css/cart.css">

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
         <a href="#about">about</a>
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
      </div>

      
      <?php echo "<h2>".$_SESSION['username']."</h2>"; ?>

   </div>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<div class="home-bg">

   <section class="home" id="home">

   </section>

</div>

<!-- home section ends -->



<!-- Latest product section starts -->


<section class="shopping-cart">

   <h1 class="title">CART</h1>

    <div class="box-container">
        <?php
            $grand_total = 0;
            $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE username = '$user_id'");
            $check = mysqli_num_rows($select_cart) > 0;
            if($check){
        ?>
        <?php    
            while($row=mysqli_fetch_array($select_cart))
            {
        ?>
       
       <form action="" method="POST" class="box">
            <a href="cart.php?delete=<?php echo $row['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
            <img src="images/<?php echo $row['image']; ?>" alt="">
            <div class="name"><?php echo $row['name']; ?></div>
            <div class="price">Rs.<?php echo $row['price']; ?>/-</div>
            <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
            <div class="flex-btn">
                <input type="number" min="1" value="<?php echo $row['quantity']; ?>" class="qty" name="p_qty">
                <input type="submit" value="update" name="update_qty" class="option-btn">
            </div>
            <div class="sub-total"> sub total : <span>Rs.<?php echo $sub_total = ($row['price'] * $row['quantity']); ?>/-</span> </div>
        </form>
        <?php
            $grand_total += $sub_total;
            }
        }else{
        echo '<p class="empty">your cart is empty</p>';
        }
        ?>
    </div>

    <h4>grand total : <span>Rs.<p id="grandtotal"><?php echo $grand_total; ?></p></span></h4>
    
    <div class="cart-total">
      <a href="menu.php" class="option-btn">continue shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">delete all</a>
      <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>
   

</section>


<!-- Latest product section starts -->



<!-- footer section starts  -->

<section class="footer">

   <div class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>mr. web designer</span> | all rights reserved! </div>

</section>

<!-- footer section ends -->



<!-- custom js file link  -->
<script src="js/script2.js"></script>


</body>
</html>