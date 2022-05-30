<?php
include('db_connect.php'); 

session_start();


$user_id = $_SESSION['username'];
if(!isset($user_id)){
   header("Location: admin_login.php");
}


if(isset($_POST["submit"]))
{
$name = $_POST["name"];
$email = $_POST["email"];
$number = $_POST["number"];
$uid = $_POST["userid"];
$password = $_POST["password"];
$image = $_FILES["image"]["name"];

   move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$_FILES["image"]["name"]);
   
   $sql = "SELECT * FROM tbl_staff WHERE staff_id = '$uid' AND email = '$email' ";
   $result = mysqli_query($con, $sql);
   if(!$result->num_rows > 0){
      $sql = "INSERT INTO tbl_staff (name, email, phone, staff_id, password, image) VALUES ('$name','$email','$number','$uid','$password', '$image')";
      $result = mysqli_query($con, $sql);
      if($result){
         echo "<script> alert('Registration completed')</script>";
         $name = "";
         $email = "";
         $number = "";
         $uid = "";
         $password = "";
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
   <title>Add delivey staff</title>

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
        
        .item {
            position: relative;
            margin: 10px 390px;
        }
    
    </style>

</head>
<body>
    <?php include 'admin_header.php'; ?>


    <section class="register" id="register">

       <div class="heading">
            <h3>Staff Registration</h3>
        </div>

    <div class="row">

      <form action="admin_staff.php" name="myform" method="POST" enctype="multipart/form-data">
         <input type="text" name="name" id="name" required class="box"  placeholder="Enter staff name" onblur="validation()">
         <font color="red"><p id = "ename"></p></font>
         <input type="email" name="email" id="email" required class="box" placeholder="Enter staff email address" onblur="validation2()">
         <font color="red"><p id = "eemail"></p></font>
         <input type="text" name="number" id="phone" required class="box" placeholder="Enter staff phonenumber" onblur="validation3()">
         <font color="red"><p id = "enum"></p></font>
         <input type="text" name="userid" id="usid" required class="box" placeholder="Enter staff id" onblur="validation4()">
         <font color="red"><p id = "euid"></p></font>
         <input type="password" name="password" id="pass" required class="box" placeholder="Enter password" onblur="validation5()">
         <font color="red"><p id = "epass"></p></font>
         <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
         
         <input type="submit" name="submit" value="register" class="btn2">
      </form>

    </div>

    </section>

    <section class="dashboard">

        <h1 class="title">staff details</h1>
        <center>    
        <table id="staff">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>staff_id</th>
                <th>Password</th>
                <th>Image</th>
                <th>Update</th>
            </tr>

            <?php
                include 'db_connect.php';

                $result = mysqli_query($con, "SELECT * FROM tbl_staff");
                while($row = mysqli_fetch_array($result))
                {
	        ?>
            <tr>
                <td><?php echo $row['name'];?> </td>
                <td><?php echo $row['email'];?> </td>
                <td><?php echo $row['phone'];?> </td>
                <td><?php echo $row['staff_id'];?> </td>
	             <td><?php echo $row['password'];?> </td>
                <td><img src="images/<?php echo $row["image"];?>" height="100" width="100" /></img></td>
    
                <td><a href="admin_update_staff.php?appu=<?php echo $row["id"];?>" class="GFG">Update</a></td>
            </tr>

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