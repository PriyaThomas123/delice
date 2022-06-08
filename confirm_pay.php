<?php

include 'db_connect.php';

session_start();

$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header('location:login.php');
};


if(isset($_POST['Amount'])){
    $payment_id = $_POST['razorpay_payment_id'];
    $amt = $_POST['Amount'];
    $insert = mysqli_query($con,"INSERT INTO `payments`(`payment_id`, `amt`) VALUES ('$payment_id', '$amt') ");
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

      table {
          width: 750px; 
	      border-collapse: collapse; 
	      margin:50px;
	    }

        /* Zebra striping */
        tr:nth-of-type(odd) { 
	    background: #eee; 
	    }

        th {
            background: #3498db; 
	        color: white; 
	        font-weight: bold; 
	    }

        td, th { 
	        padding: 10px; 
	        border: 1px solid #ccc; 
	        text-align: left; 
	        font-size: 18px;
	    }

        /* 
        Max width before this PARTICULAR table gets nasty
        This query will take effect for any screen smaller than 760px
        and also iPads specifically.
        */
        @media 
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px)  {

	        table { 
	  	        width: 100%; 
	        }

	    /* Force table to not be like tables anymore */
	        table, thead, tbody, th, td, tr { 
		        display: block; 
	        }
	
	    /* Hide table headers (but not display: none;, for accessibility) */
	        thead tr { 
		        position: absolute;
		        top: 99px;
		        left: 99px;
	        }
	
	        tr { border: 1px solid #ccc; }
	
	        td { 
		        /* Behave  like a "row" */
		        border: none;
		        border-bottom: 1px solid #eee; 
		        position: relative;
		        padding-left: 50%; 
	        }

	        td:before { 
		        /* Now like a table header */
		        position: absolute;
		        /* Top/left values mimic padding */
		        top: 6px;
		        left: 6px;
		        width: 45%; 
		        padding-right: 10px; 
		        white-space: nowrap;
		        /* Label the data */
		        content: attr(data-column);

		        color: #000;
		        font-weight: bold;
	        }

        }

        .GFG {
            background-color: white;
            border: 2px solid black;
            color: green;
            padding: 5px 10px;
            text-align: center;
            display: inline-block;
            font-size: 20px;
            margin: 10px 30px;
            cursor: pointer;
            text-decoration:none;
        }
        .DFD {
            background-color: white;
            border: 2px solid black;
            color: green;
            padding: 5px 10px;
            text-align: center;
            display: inline-block;
            font-size: 20px;
            margin: 10px 30px;
            cursor: pointer;
            text-decoration:none;
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
         <a href="reservation.php">Reservation</a>
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
         <a href="user_update_profile.php" class="btn">update profile</a>
         <a href="reservation_details.php" class="btn">Reservation Details</a>
         <a href="logout.php" class="delete-btn">logout</a>
      </div>

      
      <?php echo "<h2>".$_SESSION['username']."</h2>"; ?>

   </div>

</header>

<!-- header section ends -->


<!-- View checkout details section starts -->

<table>
  <thead>
    <tr>
      <th>flatnumber</th>
      <th>street</th>
      <th>city</th>
      <th>area</th>
      <th>pincode</th>
      <th>Total Products</th>
      <th>Total Price</th>
      <th>Date Added</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    
    <?php
        
        $r2 = mysqli_query($con,"SELECT * FROM orders WHERE username = '$user_id' ORDER BY id DESC LIMIT 1 ");
        while($row = mysqli_fetch_array($r2)){
            $onumber = $row['ordernumber'];
    ?>

    <form action="#" method="POST">
        <tr>
          <td><?php echo $row["flatnumber"];?></td>
          <td><?php echo $row["street"];?></td>
          <td><?php echo $row["city"];?></td>
          <td><?php echo $row["area"];?></td>
          <td><?php echo $row["pincode"];?></td>
          <td><?php echo $row["total_products"];?></td>
          <td id="grandtotal"><?php echo $row["total_price"];?></td>
          <td><?php echo $row["placed_on"];?></td>
          <td><?php echo $row["status"];?></td>
          <td>
              <a href="" class="GFG" onclick="window.open('cancelorder.php?oid=<?php echo $onumber; ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');">Cancel</a>
              <input type="submit" name="order" id="payment" class="DFD" value="pay now">
          </td>
        </tr>
    </form>
    
    <?php
        }
    ?>

  </tbody>
</table>



<!-- footer section starts  -->

<section class="footer">

   <div class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>mr. web designer</span> | all rights reserved! </div>

</section>

<!-- footer section ends -->



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
                               url: "confirm_pay.php",
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