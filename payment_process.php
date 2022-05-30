<?php
session_start();
include('db_connect.php');
if(isset($_POST['Amount'])){
    $user_id = $_SESSION['username'];
    $payment_id = $_POST['razorpay_payment_id'];
    $date = date('Y-m-d h:i:s');
    $amt = $_POST['Amount'];
    $insert = mysqli_query($con,"INSERT INTO `payments`(`username`, `amt`, `payment_id`, `added_on`) VALUES ('$user_id','$amt', '$payment_id', '$date') ");
    if(mysqli_query($con, $insert)){
       echo "yes";
    }
    else{
       echo "no";
    }
  }
?>

