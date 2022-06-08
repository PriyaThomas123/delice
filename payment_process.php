<?php
session_start();
include('db_connect.php');
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

