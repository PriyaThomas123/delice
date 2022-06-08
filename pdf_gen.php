<?php
session_start();
require "./fpdf.php";
$pdf = new FPDF();
$connect = new PDO("mysql:host=localhost;dbname=oreo", "root", "");
$user_id = $_SESSION['username'];

$pdf->AddPage();
$pdf->Line(10, 15, 200, 15);
$pdf->Ln(8);
// $pdf->SetFont("Arial", "B", 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 20, "BOOKIT HOME SERVICES", 0, 0, "C");
$pdf->Ln();
// $pdf->SetFont("Arial", "U", 15);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(180, 20, "RECEIPT", 0, 0, "C");

$pdf->Ln(5);

// if(isset($_GET['id'])){
//     $select_query="SELECT name,lname FROM tbl_userdata WHERE id='$userid'";
//     $result=$connect->prepare($select_query);
//     $result->execute();
//     if($result->rowCount()!=0){
//         while($row=$result->fetch()){
//             $pdf->SetRightMargin(130);
//             $pdf->SetFont("Arial", "", 12);
//             $pdf->SetTextColor(0, 0, 0);
            
//             $pdf->Ln();
//             $pdf->Cell(0, 8, "Name: " . $row['name'].' '.$row['lname'] ."", 0, 0, "C");
//             $pdf->Ln();
//             $pdf->Cell(0, 5, "Date: ". date("d/m/Y"), 0, 0, "C");
//         }
//     }
//     else{
//         echo "No Record is found";
//     }

// }


// $pdf->Ln(15);
// $pdf->SetLeftMargin(30);
// $pdf->SetFont("Arial", "", 10);
// $pdf->SetTextColor(0, 0, 0);
// $pdf->Cell(20, 10, "Sl.No", "1", "0", "C");
// $pdf->Cell(40, 10, "SERVICE", "1", "0", "C");
// $pdf->Cell(50, 10, "CATEGORY", "1", "0", "C");
// $pdf->Cell(30, 10, "AMOUNT", "1", "0", "C");


// if(isset($_GET['id'])){
//     $id=$_GET['id'];
//     $select="SELECT service,category_name,service_amt FROM tbl_bookedservice WHERE id='$id'";
//     $result=$connect->prepare($select);
//     $result->execute();
//     $count=1;
//     if($result->rowCount()!=0){
//         while($row=$result->fetch()){
//             $pdf->Ln();
//             $pdf->SetLeftMargin(30);
//             $pdf->SetFont("Arial", "", 10);
//             $pdf->SetTextColor(0, 0, 0);
//             $pdf->Cell(20, 10, $count, "1", "0", "C");
//             $count++;
//             $pdf->Cell(40, 10, $row['service'], "1", "0", "C");
//             $pdf->Cell(50, 10, substr($row['category_name'],0,25)."...", "1", "0", "C");
//             $pdf->Cell(30, 10, $row['service_amt'], "1", "0", "C");
//         }
//     }else{
//         $pdf->Ln(20);
//         $pdf->SetLeftMargin(30);
//         $pdf->SetFont("Arial", "B", 10);
//         $pdf->SetTextColor(0, 0, 0);
//         $pdf->Cell(0, 20, "No Record Is Found", 0, 0, "C");
//     }}





$pdf->Output();
?>
