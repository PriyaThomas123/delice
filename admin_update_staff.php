<?php

include 'db_connect.php';

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["number"];
    $uid = $_POST["userid"];
    $password = $_POST["password"];

    if($_FILES["image"]["tmp_name"]!="")
      $image = $_FILES["image"]["name"];
    else
	  $image = $row['image'];
    move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$_FILES["image"]["name"]);
    
    mysqli_query($con,"UPDATE `tbl_staff` SET `name`='$name', `email`='$email', `phone`='$phone',`staff_id`='$uid', `password`='$password',`image`= '$image' WHERE id='$id'");
	header("Location:admin_staff.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update staff</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">


</head>
<body>
    <?php include 'admin_header.php'; ?>


    <section class="register" id="register">

        <div class="heading">
            <h3>Update Staff Details</h3>
        </div>

    <div class="row">
      <?php
      
        $id = $_GET['appu'];
        $edit = mysqli_query($con, "SELECT * FROM `tbl_staff` WHERE id='$id' ");
        $row = mysqli_fetch_array($edit);

      ?>

      <form action="admin_update_staff.php" name="myform" method="POST" enctype="multipart/form-data">
        
         <img src="images/<?php echo $row["image"];?>" height="100" width="100"/></img>

         <input type="text" name="name" id="name" value="<?php echo $row["name"]; ?>" required class="box" onblur="validation()">
         <font color="red"><p id = "ename"></p></font>
         <input type="email" name="email" id="email" value="<?php echo $row["email"]; ?>" required class="box" onblur="validation2()">
         <font color="red"><p id = "eemail"></p></font>
         <input type="text" name="number" id="phone" value="<?php echo $row["phone"]; ?>" required class="box" onblur="validation3()">
         <font color="red"><p id = "enum"></p></font>
         <input type="text" name="userid" id="usid" value="<?php echo $row["staff_id"]; ?>" required class="box" onblur="validation4()">
         <font color="red"><p id = "euid"></p></font>
         <input type="password" name="password" id="pass" value="<?php echo $row["password"]; ?>" required class="box" onblur="validation5()">
         <font color="red"><p id = "epass"></p></font>
         
         <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">

         <input type="submit" name="submit" value="register" class="btn2">
      </form>

    </div>

    </section>



    <!-- custom js file link  -->
    <script src="js/script2.js"></script>

</body>
</html>