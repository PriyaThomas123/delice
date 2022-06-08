<?php
include('db_connect.php'); 

session_start();


$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header("Location: admin_login.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
    <?php include 'admin_header.php'; ?>


    <section class="dashboard">

        <h1 class="title">dashboard</h1>
        
            <div class="box-container">

                <div class="box">
                    <p>orders placed</p>
                    <a href="admin_orders.php" class="btn">see orders</a>
                </div>

                <div class="box">
                <?php
                    $query = "SELECT * FROM products ORDER BY id";
                    $query_run = mysqli_query($con, $query);
          
                    $row = mysqli_num_rows($query_run);
                    echo "<h1>$row</h1>";
                ?>
                    <p>products added</p>
                    <a href="admin_products.php" class="btn">see products</a>
                </div>

                <div class="box">
                <?php
                    $query = "SELECT * FROM tbl_register";
                    $query_run = mysqli_query($con, $query);
          
                    $row = mysqli_num_rows($query_run);
                    echo "<h1>$row</h1>";
                ?>
                    <p>total users</p>
                    <a href="admin_users.php" class="btn">see accounts</a>
                </div>

                <div class="box">
                    <p>total staff</p>
                    <a href="admin_staff.php" class="btn">see staff</a>
                </div>

                <div class="box">
                    <p>total reservations</p>
                    <a href="admin_reservation.php" class="btn">see reservations</a>
                </div>
            </div>

    </section>


    <!-- custom js file link  -->
    <script src="js/script2.js"></script>

</body>
</html>