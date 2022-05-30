<?php

@include '../connection.php';


if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($con, "UPDATE `cart` SET quantity = '
      $update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      header('location:cart.php');
   };
};


if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($con, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($con, "DELETE FROM `cart`");
   header('

      ');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
      <style type="text/css">
      .shopping-cart table{
      text-align: center;
      width: 100%;
      }
      .shopping-cart table thead th{
      padding:0.8rem;
      font-size: 1.5rem;
      }
      .shopping-cart table tr td{
       padding:0.5rem;
       font-size: 1.5rem;
      }

    </style>
</head>
<body>

<?php include 'header.php'; ?>
<div class="container">
<section class="shopping-cart">
   <table>
      <thead>
         <th>image</th>
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th>action</th>
      </thead>
      <tbody>
         <?php          
         $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE username = '$user'");
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>

         <tr>
            <td><img src="../images/<?php echo $fetch_cart['image']; ?>" height="80" width="80" alt=""></td>
            <td><?php echo $fetch_cart['product_name']; ?></td>
            <td>$<?php echo number_format($fetch_cart['price']); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['id']; ?>" >
                  <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['quantity']; ?>" >
                  <input type="submit" value="update" name="update_update_btn">
               </form>  
            </td>
            <td>$<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
         </tr>
         <?php
           $grand_total += $sub_total;  
            };
         };
         ?>
         <tr class="table-bottom">
            <td><a href="../home.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
            <td colspan="3">grand total</td>

            <td id="grandtotal"><?php echo $grand_total; ?></td>
            <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
      <button class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" id="payment">procced to checkout</button>

   </div>

</section>

</div>
   
<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <script>
                document.getElementById('payment').onclick = function(e) {
                    let amt=$('#grandtotal').html();
                        var options = {
                            "key": "rzp_test_1iinIS9nRfhF1F", // Enter the Key ID generated from the Dashboard
                            "amount": amt * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            "currency": "INR",
                            "name": "E-Store",
                            "description": "Grocery Store",
                            //"image": "./asset/image/logo.svg",
                            "handler": function(response) {
                                //success function
                                $.ajax({
                           url: "./cartform.php",
                            type: "POST",
                            data: {
                                razorpay_payment_id: response.razorpay_payment_id,
                           
                                Amount:amt
                            },
                            success: function(data, status) {
                                console.log(data);
                                window.location.href = "../home.php";
                            },
                            error: function(responseData, textStatus, errorThrown) {
                               console.log(responseData, textStatus, errorThrown);
                           }
                        });

                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                        e.preventDefault();
                   

                }
            </script>
</body>
</html>
