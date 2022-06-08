<?php

include 'db_connect.php';

if(isset($_POST["update_product"])){
   $pid = $_POST['pid'];
   $name = $_POST["pname"];
   $price = $_POST["price"];
   $category = $_POST["category"];
   $details = $_POST["details"];

   if($_FILES["image"]["tmp_name"]!="")
      $image = $_FILES["image"]["name"];
   else
      $image = $row["image"];
      move_uploaded_file($_FILES["image"]["tmp_name"], "images/".$_FILES["image"]["name"]);
      mysqli_query($con, "UPDATE `products` SET  `name` = '$name', `price` = '$price', `category` = '$category', `details` = '$details', `image` = '$image' WHERE id='$pid' ");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="update-product">

   <h1 class="title">update product</h1>
   
   <?php
      $update_id = $_GET['update'];
      $select_products = mysqli_query($con, "SELECT * FROM `products` WHERE id='$update_id' ");
      $check = mysqli_num_rows($select_products) > 0;
      if($check){
   ?>
   <?php    
      while($row=mysqli_fetch_array($select_products))
      {
   ?>

   <form action="#" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?php echo $row['id']; ?>">
      <img src="images/<?php echo $row['image']; ?>" alt=""></img>
      <input type="text" name="pname"  required class="box" value="<?php echo $row['name']; ?>">
      <input type="number" name="price" min="0" placeholder="enter product price" required class="box" value="<?php echo $row['price']; ?>">
      <select name="category" class="box" required>
         <option selected><?php echo $row['category']; ?></option>
         <option value="vegitables">Veg</option>
         <option value="fruits">Non-veg</option>
         <option value="meat">Desserts</option>
         <option value="fish">Drinks</option>
      </select>
      <input type="text" name="details" required placeholder="enter product details" class="box" cols="30" rows="10" value="<?php echo $row['details']; ?>">
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <div class="flex-btn">
         <input type="submit" class="btn" value="update product" name="update_product">
         <a href="admin_products.php" class="option-btn">go back</a>
      </div>
   </form>

   <?php
         }
      }else{
         echo '<p class="empty">no products found!</p>';
      }
   ?>
   

</section>





<!-- custom js file link  -->
<script src="js/script2.js"></script>

</body>
</html>