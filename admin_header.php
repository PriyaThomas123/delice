
<header class="header">

   <div class="flex">

      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="admin_page.php">home</a>
         <a href="admin_products.php">products</a>
         <a href="admin_orders.php">orders</a>
         <a href="admin_users.php">users</a>
         <a href="admin_contacts.php">messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <?php
         include "db_connect.php";
         $result=mysqli_query($con,"SELECT *  FROM `tbl_admin`");
         $check = mysqli_num_rows($result)>0;
         if($check){
      ?>
      <?php    
         while($row=mysqli_fetch_array($result))
         {
      ?>

      <div class="profile">
         <a href="admin_update_profile.php?update=<?php echo $row['a_id']; ?>" class="btn">update profile</a>
         <a href="admin_logout.php" class="delete-btn">logout</a>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
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