<?php
include('db_connect.php'); 

session_start();


$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header("Location: admin_login.php");
}

if(isset($_GET['action']) == "cid"){
    $custid = $_GET['id'];
    $stat = $_POST["categori"];

    mysqli_query($con, "UPDATE `reservation` SET `status`='$stat' WHERE `id`='$custid'");

    $message[] = 'Status updated.';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>reservation detail page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

   <style>
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
        
        .item {
            position: relative;
            margin: 10px 390px;
        }
    
    </style>

</head>
<body>
    <?php include 'admin_header.php'; ?>


    <section class="dashboard">

        <h1 class="title">reservation details</h1>
    <center>    
        
        <table id="customers">
            <tr>
                <th>UserName</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Guests</th>
                <th>Date Added</th>
                <th>Time</th>
                <th>Update</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
                include 'db_connect.php';

                $result = mysqli_query($con, "SELECT * FROM reservation");
                while($row = mysqli_fetch_array($result))
                {
                    $order_id = $row["id"];
	        ?>
            <form action="admin_reservation.php?action=cid&id=<?php echo $order_id;?>" method="POST">
            <tr>
                <td><?php echo $row['username'];?> </td>
                <td><?php echo $row['name'];?> </td>
                <td><?php echo $row['email'];?> </td>
                <td><?php echo $row['phone'];?> </td>
                <td><?php echo $row['guests'];?> </td>
	            <td><?php echo $row['date'];?> </td>
                <td><?php echo $row['time'];?> </td>
                <td>
                    <select name="categori" id="cat_id">
                        <option></option>
                        <option value="Reservation Confirmed">Reservation Confirmed</option>
                        <option value="Reservation Cancelled">Reservation Cancelled</option>
                    </select>
                </td>
                <td><?php echo $row['status'];?> </td>
                <td><input type="submit" name="submit" value="apply" class="btn2"></td>
            </tr>
            </form>

            <?php
            }
            ?>


        </table>
        
    </center>

    </section>


    <!-- custom js file link  -->
    <script src="js/script2.js"></script>

</body>
</html>