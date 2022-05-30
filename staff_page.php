<?php
include('db_connect.php'); 

session_start();


$user_id = $_SESSION['staff_id'];
if(!isset($user_id)){
   header("Location: staff_login.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>staff page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
    <?php include 'staff_header.php'; ?>


    <section class="dashboard">

        <h1 class="title">dashboard</h1>
        
            <div class="box-container">
                

                <div class="box">
                    <p>orders placed</p>
                    <a href="staff_orders.php" class="btn">see orders</a>
                </div>


            </div>

    </section>


    <!-- custom js file link  -->
    <script src="js/script2.js"></script>

</body>
</html>