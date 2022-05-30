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

        <h1 class="title">order details</h1>
    <center>    
        
        <table id="customers">
            <tr>
                <th>UserName</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Total Products</th>
                <th>Total Price</th>
                <th>Date Added</th>
                <th>Status</th>
                <th>Assign Staff</th>
                <th>Update</th>
            </tr>

            <?php
                include 'db_connect.php';

                $result = mysqli_query($con, "SELECT * FROM orders");
                while($row = mysqli_fetch_array($result))
                {
                    $order_id = $row["id"];
	        ?>
            <form action="admin_orders.php?action=idd&staffid=<?php echo $order_id; ?>" method="POST">
            <tr>
                <td><?php echo $row['username'];?> </td>
                <td><?php echo $row['name'];?> </td>
                <td><?php echo $row['number'];?> </td>
                <td><?php echo $row['email'];?> </td>
                <td><?php echo $row['address'];?> </td>
                <td><?php echo $row['total_products'];?> </td>
	            <td><?php echo $row['total_price'];?> </td>
                <td><?php echo $row['placed_on'];?> </td>
                <td><?php echo $row['status'];?></td>
                <td>
                    <select name="staffname" id="cat_id">
                        <option>Select</option>
                        <?php
                           $sql = mysqli_query($con, "SELECT * FROM tbl_staff");
                           while($dstaff = mysqli_fetch_array($sql, MYSQLI_ASSOC)):;
                           {
                               $staffid = $dstaff["staffid"];
                               $staffname = $dstaff["name"];
                           }
                        ?>
                        <option value="<?php echo $staffid;?>">
                           <?php echo $staffname; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </td>
    
                <td><input type="submit" name="submit" value="apply" class="btn"></td>
            </tr>
            </form>

            <?php
            }
            ?>

            <?php
            
                if(isset($_GET['action']) == "idd"){
                    $oid = $_GET['staffid'];
                    $sql1 = "SELECT `staffid` FROM `tbl_staff`";
                    $row1 = mysqli_query($con, $sql1);
                    if($res1 = mysqli_fetch_assoc($row1)){
                        $delid = $_POST['staffname'];
                    }
                    $sql2 = "INSERT INTO `assign_staff`(`assign_order_id`, `assign_del_boy`) VALUES('$oid', '$delid') ";
                    if(mysqli_query($con, $sql2))
                    {
                        echo "<script> alert('Assigned Successfully.')</script>";
                    }
                    else{
                        echo "<script> alert('Assign failed.')</script>";
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