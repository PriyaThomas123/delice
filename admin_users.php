<?php

include 'db_connect.php';


if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_users = mysqli_query($con, "DELETE FROM `tbl_register` WHERE id = '$delete_id' ");
   $delete_users->execute([$delete_id]);
   header('location:admin_users.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="user-accounts">

   <h1 class="title">user accounts</h1>

   <div class="box-container">

      <?php
         include "db_connect.php";
         $select_users = mysqli_query($con, "SELECT * FROM `tbl_register`");
         $check = mysqli_num_rows($select_users)>0;
         if($check){
            ?>
        <?php   
            while($fetch_users = mysqli_fetch_array($select_users)){
      ?>
      <div class="box" style="<?php if($fetch_users['user_id'] == $admin_id){ echo 'display:none'; }; ?>">
         <p> user id : <span><?php echo $fetch_users['user_id']; ?></span></p>
         <p> name : <span><?php echo $fetch_users['name']; ?></span></p>
         <p> email : <span><?php echo $fetch_users['email']; ?></span></p>
         <a href="admin_users.php?delete=<?php $fetch_users['user_id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete</a>
      </div>
      <?php
      }
      ?>
   </div>
   <?php 
      }
   ?>  

</section>













<script src="js/script.js"></script>

</body>
</html>