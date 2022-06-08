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
   $flat_number = $_POST['flat'];
   $streetname = $_POST['street'];
   $city = $_POST['city'];
   $area = $_POST['area'];
   $pincode = $_POST['pin_code'];
   $placed_on = date('d-M-Y h:i:s');
   $status = "ordered";
   //genrating order number
   $orderno= mt_rand(100000000, 999999999);

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

   $order_query = mysqli_query($con, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND flatnumber = '$flat_number' AND street = '$streetname' AND city = '$city' AND area = '$area' AND pincode = '$pincode' AND total_products = '$total_products' AND total_price = '$cart_total' AND status='$status' AND ordernumber='$orderno'");
   $checks = mysqli_num_rows($order_query)>0;

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($checks){
      $message[] = 'order placed already!';
   }else{
      $insert_order = mysqli_query($con, "INSERT INTO `orders`(username, name, number, email, flatnumber, street, city, area, pincode, total_products, total_price, placed_on, status, ordernumber) VALUES('$user_id','$name','$number','$email','$flat_number', '$streetname', '$city', '$area', '$pincode', '$total_products','$cart_total','$placed_on', '$status', '$orderno')");
      
      $delete_cart = mysqli_query($con, "DELETE FROM `cart` WHERE username = '$user_id'");
      $message[] = 'order placed successfully. Your Order number is: '.$orderno.'';
   }

};


if(isset($_POST['Amount'])){
   $payment_id = $_POST['razorpay_payment_id'];
   $amt = $_POST['Amount'];
   $insert = mysqli_query($con,"INSERT INTO `orders`(`payment_id`) VALUES ('$payment_id') ");
   if(mysqli_query($con, $insert)){
      echo "yes";
   }
   else{
      echo "no";
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
         <a href="reservation_details.php" class="btn">Reservation Details</a>
         <a href="logout.php" class="delete-btn">logout</a>
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
   <h4>grand total : <span id="grandtotal"><?php echo $cart_grand_total; ?></span></h4>
</section>



<!-- checkout form starts -->

<section class="checkout-orders">

   <?php
      $user_id = $_SESSION['username'];
      $edit = mysqli_query($con, "SELECT name, email, phone FROM `tbl_register` WHERE username= '$user_id'");
      $row = mysqli_fetch_array($edit);
   ?>

   <form action="" method="POST" name="myform">

      <h3>place your order</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="enter your name" class="box" onblur="validation()">
            <p id = "cname" style="color:red;font-size:20px;"></p>
         </div>
         <div class="inputBox">
            <span>your phone number :</span>
            <input type="text" name="number" id="phone" value="<?php echo $row['phone']; ?>" placeholder="enter your number" class="box" onblur="validation2()">
            <p id = "cnum" style="color:red;font-size:20px;"></p>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" id="checkemail" value="<?php echo $row['email']; ?>" placeholder="enter your email" class="box" onblur="validation3()">
            <p id = "cemail" style="color:red;font-size:20px;"></p>
         </div>
         <div class="inputBox">
            <span>Flat Number :</span>
            <input type="text" name="flat" id="flatnum" placeholder="e.g. flat number" class="box" onblur="validation4()" required>
            <p id = "cflat" style="color:red;font-size:20px;"></p>
         </div>
         <div class="inputBox">
            <span>Street Name :</span>
            <input type="text" name="street" id="streetname" placeholder="e.g. street name" class="box" onblur="validation5()" required>
            <p id = "cstreet" style="color:red;font-size:20px;"></p>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" id="cityname" placeholder="e.g. Kochi" class="box" onblur="validation6()" required>
            <p id = "ccity" style="color:red;font-size:20px;"></p>
         </div>
         <div class="inputBox">
            <span>Area :</span>
            <input type="text" name="area" id="areaname" placeholder="e.g. Kochi" class="box" onblur="validation7()"required>
            <p id = "carea" style="color:red;font-size:20px;"></p>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="text" name="pin_code" id="pincode" placeholder="e.g. 123456" class="box" onblur="validation8()" required>
            <p id = "cpin" style="color:red;font-size:20px;"></p>
         </div>
      </div>

      <input type="submit" name="order" id="payment" class="btn <?php ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">
   </form>
   <form action="confirm_pay.php" ><input type="submit" name="next" class="btn :'disabled'; ?>" value="next"></form>

   

</section>



<!-- footer section starts  -->

<section class="footer">

   <div class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>mr. web designer</span> | all rights reserved! </div>

</section>

<!-- footer section ends -->



<!-- custom js file link  -->
<script src="js/script2.js"></script>


<script>
   
   function validation(){  
   var name = document.forms["myform"]["name"];  
   var pattern=/^[A-Za-z\s]+$/;
   if(name.value == ""){
      uname="Required field";
      document.getElementById("cname").innerHTML=uname;
      name.focus();
      return false;
   }
   else if(name.value.match(pattern)){
      document.getElementById("cname").innerHTML="";
      document.myform.phone.focus();
      return true;
   }
   else{
      document.getElementById("cname").innerHTML="Invalid(Enter letters only )";
      name.focus();
      return false;
   }
}  


function validation2()
  {
    var unum = document.forms["myform"]["number"];
    var pwd = /^\+{0,2}([\-\. ])?(\(?\d{0,3}\))?([\-\. ])?\(?\d{0,3}\)?([\-\. ])?\d{3}([\-\. ])?\d{4}/;
            
    if(unum.value == ""){
      document.getElementById("cnum").innerHTML="Required field";
      unum.focus();
      return false;
    }
    else if(unum.value.match(pwd)){
      document.getElementById("cnum").innerHTML="";
      document.myform.checkemail.focus();
      return true;
    }
    else{
      document.getElementById("cnum").innerHTML="Invalid Format. Please enter only digits..";
      unum.focus();
      return false;
    }
  }


function validation3(){  
var name2 = document.forms["myform"]["email"];  
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if(name2.value == ""){
    uemail="Required field";
    document.getElementById("cemail").innerHTML=uemail;
    name2.focus();
    return false;
  }
  else if(name2.value.match(mailformat)){
    document.getElementById("cemail").innerHTML="";
    document.myform.flatnum.focus();
    return true;
  }
  else{
    document.getElementById("cemail").innerHTML="You have entered an invalid email address!";
    name2.focus();
    return false;
  }
}


function validation4()
  {
    var unum = document.forms["myform"]["flat"];
    var pwd = /^[0-9]+$/;
            
    if(unum.value == ""){
      document.getElementById("cflat").innerHTML="Required field";
      unum.focus();
      return false;
    }
    else if(unum.value.match(pwd)){
      document.getElementById("cflat").innerHTML="";
      document.myform.streetname.focus();
      return true;
    }
    else{
      document.getElementById("cflat").innerHTML="Please input numeric characters only.";
      unum.focus();
      return false;
    }
  }


  function validation5(){  
   var cstreetname = document.forms["myform"]["street"];  
   var pattern=/^[A-Za-z\s]+$/;
   if(cstreetname.value == ""){
      uname="Required field";
      document.getElementById("cstreet").innerHTML=uname;
      cstreetname.focus();
      return false;
   }
   else if(cstreetname.value.match(pattern)){
      document.getElementById("cstreet").innerHTML="";
      document.myform.cityname.focus();
      return true;
   }
   else{
      document.getElementById("cstreet").innerHTML="Invalid(Enter letters only )";
      cstreetname.focus();
      return false;
   }
}


function validation6(){  
   var ccityname = document.forms["myform"]["city"];  
   var pattern=/^[A-Za-z\s]+$/;
   if(ccityname.value == ""){
      ucname="Required field";
      document.getElementById("ccity").innerHTML=ucname;
      ccityname.focus();
      return false;
   }
   else if(ccityname.value.match(pattern)){
      document.getElementById("ccity").innerHTML="";
      document.myform.areaname.focus();
      return true;
   }
   else{
      document.getElementById("ccity").innerHTML="Invalid(Enter letters only )";
      ccityname.focus();
      return false;
   }
}


function validation7(){  
   var careaname = document.forms["myform"]["area"];  
   var pattern=/^[A-Za-z\s]+$/;
   if(careaname.value == ""){
      ucaname="Required field";
      document.getElementById("carea").innerHTML=ucname;
      careaname.focus();
      return false;
   }
   else if(careaname.value.match(pattern)){
      document.getElementById("carea").innerHTML="";
      document.myform.pincode.focus();
      return true;
   }
   else{
      document.getElementById("carea").innerHTML="Invalid! (Enter letters only )";
      careaname.focus();
      return false;
   }
}


function validation8()
  {
    var unum = document.forms["myform"]["pin_code"];
    var pwd = /^\+{0,2}([\-\. ])?(\(?\d{0,3}\))?([\-\. ])?\(?\d{0,3}\)?([\-\. ])?\d{3}([\-\. ])?\d{4}/;
            
    if(unum.value == ""){
      document.getElementById("cpin").innerHTML="Required field";
      unum.focus();
      return false;
    }
    else if(unum.value.match(pwd)){
      document.getElementById("cpin").innerHTML="";
      document.myform.payment.focus();
      return true;
    }
    else{
      document.getElementById("cpin").innerHTML="Invalid Format. Please enter only digits..";
      unum.focus();
      return false;
    }
  }

  

</script>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script>
              //  document.getElementById('payment').onclick = function(e) {
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
                               url: "checkout.php",
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
                   

                }//
            </script>




</body>
</html>