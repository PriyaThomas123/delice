<?php 
include 'db_connect.php';
session_start();

$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header("Location: login.php");
};


if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];
   $p_qty = $_POST['p_qty'];

   $check_cart_numbers = mysqli_query($con, "SELECT * FROM `cart` WHERE name = '$p_name' AND username = '$user_id' ");
   $check = mysqli_num_rows($check_cart_numbers)>0;

   if($check){
      $message[] = 'already added to cart!';
   }else{

      $insert_cart = mysqli_query($con, "INSERT INTO `cart`(username, pid, name, price, quantity, image) VALUES('$user_id','$pid','$p_name','$p_price','$p_qty','$p_image')");

      $message[] = 'added to cart!';
   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">

</head>
<body>


<header class="header">

   <div class="flex">

      <a href="#home" class="logo"><img src="images/logo.jpg" alt=""></a>

      <nav class="navbar">
         <a href="#home">home</a>
         <a href="#about">about</a>
         <a href="menu.php">menu</a>
         <a href="#contact">contact</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <a href="search_page.php" class="fas fa-search"></a>

         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>()</span></a>
      </div>

      <div class="profile">
         <a href="user_update_password.php" class="btn">update password</a>
         <a href="reservation_details.php" class="btn">Reservation Details</a>
         <a href="logout.php" class="delete-btn">logout</a>
      </div>

      <?php echo "<h2>".$_SESSION['username']."</h2>"; ?>

</div>

</header>


<section class="search-form">

   <form action="" method="POST">
      <input type="text" class="box" name="search_box" placeholder="search products...">
      <input type="submit" name="search_btn" value="search" class="btn">
   </form>

</section>

<?php



?>

<section class="products" style="padding-top: 0; min-height:100vh;">

   <div class="box-container">

   <?php
      if(isset($_POST['search_btn'])){
      $search_box = $_POST['search_box'];
      $select_products = mysqli_query($con, "SELECT * FROM `products` WHERE name LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%'");
      $check = mysqli_num_rows($select_products) > 0;
      if($check){
    ?>
    <?php    
        while($row=mysqli_fetch_array($select_products))
        {
    ?>
   <form action="" class="box" method="POST">
      <div class="price">$<span><?php echo $row['price']; ?></span>/-</div>
      <img src="images/<?php echo $row['image']; ?>" alt="">
      <div class="name"><?php echo $row['name']; ?></div>
      <input type="hidden" name="pid" value="<?php echo $row['id']; ?>">
      <input type="hidden" name="p_name" value="<?php echo $row['name']; ?>">
      <input type="hidden" name="p_price" value="<?php echo $row['price']; ?>">
      <input type="hidden" name="p_image" value="<?php echo $row['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no result found!</p>';
      }
      
   };
   ?>

   </div>

</section>








<script src="js/script2.js"></script>

</body>
</html>