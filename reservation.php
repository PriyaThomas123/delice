<?php 
include 'db_connect.php';
session_start();

$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header("Location: login.php");
}


if(isset($_POST["submit"]))
{
$name = $_POST["visitor_name"];
$email = $_POST["visitor_email"];
$number = $_POST["visitor_phone"];
$adults = $_POST["total_adults"];
$check = $_POST["checkin"];
$time = $_POST["time_show"];
$status_r = $_POST['pending'];


   $sql = "SELECT * FROM reservation WHERE username = '$user_id'";
   $result = mysqli_query($con, $sql);
   if(!$result->num_rows > 0){
      $sql = "INSERT INTO reservation(username,name,email,phone,guests,date,time,status) VALUES ('$user_id','$name','$email','$number','$adults','$check','$time','$status_r')";
      $result = mysqli_query($con, $sql);
      if($result){
         echo "<script> alert('Table Reservation completed')</script>";
         $name = "";
         $email = "";
         $number = "";
         $adults = "";
         $check = "";
         $time = "";
      }else{
         echo "<script> alert('Something went wrong.')</script>";
      }
   }else{
      echo "<script> alert('Email already exists..')</script>";
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
   <link rel="stylesheet" href="css/reservation.css">

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
         <h3>Book a Table</h3>
      </div>

   </section>

</div>

<!-- home section ends -->
<section class="contact" id="contact">

   <div class="heading">
      <img src="images/facility.png" alt="">
      <h3>Reserve table</h3>
   </div>
<form action="reservation.php" method="post">
  <div class="elem-group">
    <label for="name">Your Name</label>
    <input type="text" id="name" name="visitor_name" placeholder="John Doe" pattern=[A-Z\sa-z]{3,20} required>
  </div>
  <div class="elem-group">
    <label for="email">Your E-mail</label>
    <input type="email" id="email" name="visitor_email" placeholder="john.doe@email.com" required>
  </div>
  <div class="elem-group">
    <label for="phone">Your Phone</label>
    <input type="tel" id="phone" name="visitor_phone" placeholder="498-348-3872" pattern=(\d{3})-?\s?(\d{3})-?\s?(\d{4}) required>
  </div>
  <hr>
  <div class="elem-group inlined">
    <label for="adult">Number Persons</label>
    <input type="number" id="adult" name="total_adults" placeholder="2" min="1" max="10" required>
  </div>
  
  <div class="elem-group inlined">
    <label for="checkin-date">Arrival Date</label>
    <input type="date" id="checkin-date" name="checkin" min="<?php echo date('Y-m-d') ?>" required>
  </div>
  <div class="elem-group">
    <label for="room-selection">Select Reservation Time</label>
    <select id="room-selection" name="time_show" required>
        <option value="">---</option>
            <option value="10:00am">10:00 am</option>
            <option value="11:00am">11:00 am</option>
            <option value="12:00pm">12:00 pm</option>
            <option value="1:00pm">1:00 pm</option>
            <option value="2:00pm">2:00 pm</option>
            <option value="3:00pm">3:00 pm</option>
            <option value="4:00pm">4:00 pm</option>
            <option value="5:00pm">5:00 pm</option>
            <option value="6:00pm">6:00 pm</option>
            <option value="7:00pm">7:00 pm</option>
            <option value="8:00pm">8:00 pm</option>
            <option value="9:00pm">9:00 pm</option>
            <option value="10:00pm">10:00 pm</option>
    </select>
  </div>
  <hr>
  
  <button type="submit" name="submit">Book The Rooms</button>
</form>

<section>

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