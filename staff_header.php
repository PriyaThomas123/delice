
<header class="header">

<?php

      if(isset($message)){
         foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
         }
      }
   ?>

<div class="flex">

   <a href="staff_page.php" class="logo">Staff<span>Panel</span></a>

   <nav class="navbar">
      <a href="staff_page.php">home</a>
      <a href="staff_orders.php">orders</a>
   </nav>

   <div class="icons">
      <div id="menu-btn" class="fas fa-bars"></div>
      <div id="user-btn" class="fas fa-user"></div>
   </div>

   <?php
      include "db_connect.php";
      $result=mysqli_query($con,"SELECT *  FROM `tbl_staff`");
      $check = mysqli_num_rows($result)>0;
      if($check){
   ?>
   <?php    
      while($row=mysqli_fetch_array($result))
      {
   ?>

   <div class="profile">
      <a href="staff_update_profile.php?update=<?php echo $row['staffid']; ?>" class="btn">update profile</a>
      <a href="staff_logout.php" class="delete-btn">logout</a>
   </div>

   <?php
      }
   ?>

</div>
<?php 
   }else{
      echo '<p class="empty">now products added yet!</p>';
   }
?>  

</header>