<?php
session_start();
error_reporting(0);
include 'db_connect.php';
if(isset($_POST['submit']))
  {
    
    $oid=$_GET['oid'];
    $ressta="Order Cancelled";
    $remark=$_POST['restremark'];
    $canclbyuser=1;
 
    
    $insert_order = mysqli_query($con,"INSERT INTO `foodtracking`(Orderid,remark,status,OrderCancelledByUser) values('$oid', '$remark', $ressta','$canclbyuser')"); 
    $query=mysqli_query($con, "update orders set status='$ressta' where ordernumber='$oid'");
    if ($query) {
       $msg="Order Has been updated";
    }
    else
    {
      $msg="Something Went Wrong. Please try again";
    }

  
}

 ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Order Cancelation</title>
</head>
<body>

<div style="margin-left:50px;">

<?php  
$oid=$_GET['oid'];
$query=mysqli_query($con,"select ordernumber, status from orders where ordernumber='$oid'");
$num=mysqli_num_rows($query);
$cnt=1;
?>

<table border="1"  cellpadding="10" style="border-collapse: collapse; border-spacing:0; width: 100%; text-align: center;">
<tr align="center">
    <th colspan="4" >Cancel Order #<?php echo  $oid;?></th> 
</tr>
<tr>
    <th>Order Number </th>
    <th>Current Status </th>
</tr>

<?php  
   while ($row=mysqli_fetch_array($query)) {
?>

<tr>
    <td><?php  echo $oid;?></td> 
    <td>
    <?php  $status=$row['status'];
        if($status=="ordered"){
            echo "Waiting for Restaurant confirmation";
        } else { 
            echo $status;
        }
    ?>
    </td> 
</tr>

<?php 
} ?>


</table>
     
<form method="post">
    <table>
        <?php if($status=="ordered" || $status=="Order Confirmed" || $status=="Food being Prepared") {?>
        <tr>
            <th>Reason for Cancel</th>
            <td>
              <textarea name="restremark" placeholder="" rows="12" cols="50" class="form-control wd-450" required="true"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" text-align="center"><button type="submit" name="submit" class="btn btn-primary">Update order</button></td>
        </tr>
    </table>

</form>

<?php } else { ?>
<?php if($status=='Order Cancelled'){?>
   
<p style="color:red; font-size:20px;"> Order Already Cancelled</p>

<?php } else { ?>

<p style="color:red; font-size:20px;"> You can't cancel this order. Order pickup for delivery or delivered</p>

<?php }  } ?>
  
</div>

</body>
</html>

     