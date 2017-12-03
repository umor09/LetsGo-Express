<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}
$in_user_id = $_SESSION['in_user_id'];
$present_date = date('Y-m-d', $c_date);

if(isset($_POST["booking_id"]) && isset($_POST["paid_amount"]) && number_format($_POST["paid_amount"])){ 
//var_dump($_POST);
$discount_amount = 0;
$vat_amount = 0;

$booking_id = $_POST["booking_id"];
$bill_amount = abs($_POST["bill_amount"]);
$discount = abs($_POST["discount"]);
$vat_tax = 0; //abs($_POST["vat_tax"]);
$given_amount = abs($_POST["paid_amount"]);

$discount_amount = Bill::calculate_discount($bill_amount, $discount? $discount:0);
$vat_amount = Bill::calculate_discount($bill_amount, $vat_tax? $vat_tax:0);
$total_amount = (($bill_amount-$discount_amount)+$vat_amount);
//$bookingObj=Booking::find_by_id($booking_id);
$exist_bill = Bill::find_by_field('booking_id', $booking_id);
$billObj = new Bill();

if(!empty($exist_bill)):		
	  	$billObj->id =$exist_bill[0]->id;
		$paid_amount =$exist_bill[0]->paid_amount;
		$update_paid_amount = abs($paid_amount+$given_amount);
	  	$billObj->paid_amount = $update_paid_amount;
	  	$billObj->save();
		$bill_id = $exist_bill[0]->id;
	  //update
	else:
	  	$billObj->booking_id = $booking_id;
		$billObj->bill_amount = $bill_amount;
		$billObj->discount = $discount;
		$billObj->total_amount = $total_amount;
		$billObj->paid_amount = $given_amount;
		$billObj->entry_by = $in_user_id;
		$result=$billObj->save();
		$bill_id=$database->insert_id();
	endif;
}

if(!empty($bill_id))
{

 	$output = "";
	$objData=Bill::find_by_id($bill_id);
	if(!empty($objData)):	
 $output .= '  
      <div class="responsive-table">  
           <table class="table table-bordered table-hover">';
     $output .= '
     <tr>  
            <td width="35%"><label>Booking ID</label></td>  
            <td width="65%">'.$objData->booking_id.'</td>  
        </tr>
        <tr>  
            <td width="35%"><label>Bill Amount</label></td>  
            <td width="65%">'.$objData->bill_amount.'</td>  
        </tr>
        <tr>  
            <td width="35%"><label>Discount</label></td>  
            <td width="65%">'.$objData->discount.'</td>  
        </tr>
        <tr>  
            <td width="35%"><label>Total Amount</label></td>  
            <td width="65%">'.$objData->total_amount.'</td>  
        </tr>
        <tr>  
            <td width="35%"><label>Paid Amount</label></td>  
            <td width="65%">'.$objData->paid_amount.'</td>  
        </tr>';
	endif;
    $output .= '</table></div>';
    echo $output;
	//echo $bill_id;
}

?>