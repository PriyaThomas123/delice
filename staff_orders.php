<?php
include('db_connect.php'); 

session_start();


$user_id = $_SESSION['staff_id'];
if(!isset($user_id)){
   header("Location: staff_login.php");
}
/*
$results = mysqli_query($con, "SELECT * FROM `tbl_staff` WHERE staffid = '$user_id' ");
while($rows = mysqli_fetch_array($results)){
    $uid = $rows['staffid'];
}
*/
$r1 = mysqli_query($con,"SELECT `staffid` FROM `tbl_staff` WHERE `staff_id`='$user_id'");
$rr1 = mysqli_fetch_array($r1);
$sid = $rr1['staffid'];




?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>view assigned orders</title>

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
    <?php include 'staff_header.php'; ?>


    <section class="dashboard">
        <h1><?php echo $user_id ;?></h1>

        <h1 class="title">order details</h1>
    <center>    
        <table id="customers">
            <tr>
                <!--<th>UserName</th>-->
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Total Products</th>
                <th>Total Price</th>
                <th>Date Added</th>
                <th>Update</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
                //include 'db_connect.php';

               /* $rr = mysqli_query($con, "SELECT `assign_order_id` FROM `assign_staff` WHERE `assign_del_boy` = '$uid' ");
                while($rc = mysqli_fetch_array($rr)){
                    $asscid = $rc["assign_order_id"];
                    $res = mysqli_query($con, "SELECT `id`, `username`, `name`, `number`, `email`, `address`, `total_products`, `total_price`, `placed_on`, `status` FROM `orders` WHERE `id` = '$asscid' ");
                    while($r = mysqli_fetch_array($res)){
                        $order_id = $r['id'];
                        $username1 = $r['username'] ;
                        $name1 = $r['name'];
                        $number1 = $r['number'];
                        $email1 = $r['email'];
                        $address1 = $r['address'];
                        $total_products1 = $r['total_products'];
                        $total_price1 = $r['total_price'];
                        $placed_on1 = $r['placed_on'];
*/

$r2 = mysqli_query($con,"SELECT `assign_order_id` FROM `assign_staff` WHERE `assign_del_boy`='$sid'");
while($rr2 = mysqli_fetch_array($r2)){
    $aoid = $rr2['assign_order_id'];

    $r3 = mysqli_query($con,"SELECT `name`, `number`, `email`, `address`, `total_products`, `total_price`, `placed_on`, `status` FROM `orders` WHERE `id`='$aoid'");
    $rr3 = mysqli_fetch_array($r3);

?>

             <form action="staff_orders.php?action=idd&staffid=<?php echo $order_id;?>" method="POST">

             <tr>
                <!--<td><?php //echo $username1 ?> </td>-->
                <td><?php echo $rr3['name'] ?> </td>
                <td><?php echo $rr3['number'] ?> </td>
                <td><?php echo $rr3['email'] ?> </td>
                <td><?php echo $rr3['address'] ?> </td>
                <td><?php echo $rr3['total_products'] ?> </td>
	            <td><?php echo $rr3['total_price'] ?> </td>
                <td><?php echo $rr3['placed_on'] ?> </td>
                <td>
                    <select name="categori" id="cat_id">
                        <option>On delivery</option>
                        <option>Delivered</option>
                        <option>Cancel</option>
                    </select>
                </td>
                <td><?php echo $rr3['status'];?></td>
    
                <td><a href="update_product.php?appu=<?php echo $row["id"];?>" class="GFG">Update</a></td>
            </tr>

             </form>           
	        


            <?php
                    }
                //}
            
            ?>

            <?php
               
               if(isset($_GET['action']) == "idd"){
                   $ad = $_GET['staffid'];
                   $sql4 = "SELECT `staffid` FROM `tbl_staff`   WHERE `staffid` = '$ad' ";
                   $row4 = mysqli_query($con, $sql4);
                   if($res4 = mysqli_fetch_assoc($row4)){
                       $tb = $_POST['name'];
                   }
               }
             
            ?>

        </table>
    </center>

    </section>


    <!-- custom js file link  -->
    <script src="js/script2.js"></script>

</body>
</html>