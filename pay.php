<?php

session_start();
include 'db_connect.php';

$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header('location:login.php');
};

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

   <div class="flex">

      <a href="#home" class="logo"><img src="images/logo.jpg" alt=""></a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="#about">about</a>
         <a href="menu.php">menu</a>
         <a href="logout.php">Logout</a>
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
      include 'db_connect.php';
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



<!-- Latest product section starts -->


<section class="shopping-cart">

   
    <div class="cart-total">
      <input type="submit" name="order" id="payment" class="btn <?php ($cart_grand_total > 1)?'':'disabled'; ?>" value="pay now">
   </div>
   

</section>


<!-- Latest product section starts -->




<!-- custom js file link  -->
<script src="js/script2.js"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script>
                document.getElementById('payment').onclick = function(e) {
                    let amt=$('#grandtotal').html();
                        var options = {
                            "key": "rzp_test_AQhgeRO5cqmqBn", // Enter the Key ID generated from the Dashboard
                            "amount": amt * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            "currency": "INR",
                            "name": "Delice",
                            "description": "Restaurant",
                            //"image": "./asset/image/logo.svg",
                            "handler": function(response) {
                                //success function
                                $.ajax({
                               url: "payment_process.php",
                               type: "POST",
                               data: {
                                razorpay_payment_id: response.razorpay_payment_id,

                                Amount:amt
                            },
                            success: function(data, status) {
                                console.log(data);
                                window.location.href = "cart.php";
                            },
                            error: function(responseData, textStatus, errorThrown) {
                               console.log(responseData, textStatus, errorThrown);
                           }
                        });

                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                        e.preventDefault();
                   

                }
            </script>


</body>
</html>