<?php

include 'db_connect.php';

if(isset($_POST['update_profile'])){

   $username = $_POST['username'];
   $email = $_POST['email'];
   $new_pass = $_POST['new_pass'];

   mysqli_query($con, "UPDATE `tbl_admin` SET username = '$username', email = '$email', password = '$new_pass' ");
   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update admin profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="update-profile">

   <h1 class="title">update profile</h1>

   <?php
      $update_id = $_GET['update'];
      $edit = mysqli_query($con, "SELECT * FROM `tbl_admin` WHERE a_id = '$update_id'");
      $row = mysqli_fetch_array($edit);
   ?>

   <form action="" method="POST">
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="username" value="<?php echo $row['username']; ?>" placeholder="update username" required class="box">
            <span>email :</span>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="update email" required class="box">
            
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $row['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="update profile" name="update_profile">
         <a href="admin_page.php" class="option-btn">go back</a>
      </div>
   </form>

</section>







<!-- custom js file link  -->
<script src="js/script2.js"></script>

</body>
</html>