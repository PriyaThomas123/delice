<?php
include 'db_connect.php';


if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $price = $_POST['price'];
   $category = $_POST['category'];
   $details = $_POST['details'];
   $image = $_FILES["image"]["name"];

   move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$_FILES["image"]["name"]);

   $select_products = mysqli_query($con, "SELECT * FROM `products` WHERE name = '$name' ");
   $select_product = mysqli_num_rows($select_products);

   if($select_product > 0){
      $message[] = 'product name already exist!';
   }else{
      mysqli_query($con,"INSERT INTO `products`(`name`, `category`, `details`, `price`, `image`) VALUES('$name', '$category', '$details', '$price', '$image')");
      $message[] = 'new product added!';

   }

};


if(isset($_GET['delete'])){

   $delete_id= $_GET['delete'];
   $sql = mysqli_query($con,"SELECT `image` FROM products WHERE id='$delete_id'");
   $row = mysqli_fetch_array($sql);
   unlink("images/".$row['image']);

   mysqli_query($con,"DELETE FROM `products` WHERE id='$delete_id'");
   
   header('location:admin_products.php');


}


?>


<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-products">

   <h1 class="title">add new product</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
         <input type="text" name="name" class="box" required placeholder="enter product name">
         <select name="category" class="box" required>
            <option value="" selected disabled>select category</option>
               <option value="veg">Veg</option>
               <option value="nonveg">Non-Veg</option>
               <option value="desserts">Desserts</option>
               <option value="drinks">Drinks</option>
         </select>
         </div>
         <div class="inputBox">
         <input type="number" min="0" name="price" class="box" required placeholder="enter product price">
         <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
         </div>
      </div>
      <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea>
      <input type="submit" class="btn" value="add product" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="title">products added</h1>

   <div class="box-container">

      <?php
         include "db_connect.php";
         $result=mysqli_query($con,"SELECT *  FROM `products`");
         $check = mysqli_num_rows($result)>0;
         if($check){
      ?>
      <?php    
         while($row=mysqli_fetch_array($result))
         {
      ?>
      
      <div class="box">
         <div class="price">$<?php echo $row['price']; ?>/-</div>
         <img src="images/<?php echo $row['image']; ?>" alt="">
         <div class="name"><?php echo $row['name']; ?></div>
         <div class="cat"><?php echo $row['category']; ?></div>
         <div class="details"><?php echo $row['details']; ?></div>
         <div class="flex-btn">
            <a href="admin_update_product.php?update=<?php echo $row["id"]; ?>" class="option-btn">update</a>
            <a href="admin_products.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
         </div>

      </div>
      <?php
         }
      ?>

   <?php 
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>  
</div>

</section>


<!-- custom js file link  -->
<script src="js/script2.js"></script>

</body>
</html>