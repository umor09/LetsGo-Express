<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])){ redirect_to("../logout.php");}
$present_date = date("d-M-Y", $c_date);

if(isset($_GET['ID']) && !empty($_GET['ID'])):
$bill_no = $_GET['ID'];
endif;

if(empty($bill_no)):
  echo "No New Bill Created !"; 
  return; 
endif;

if(!empty($bill_no)):	
$billObj = Bill::find_by_id($bill_no);
	if(!empty($billObj)):
	$due_amount = 0;
	$bill_id = $billObj->id;
	$booking_id = $billObj->booking_id;
	$bill_amount = $billObj->bill_amount;
	$discount = $billObj->discount;
	$total_amount = $billObj->total_amount ;
	$paid_amount = $billObj->paid_amount;
	$due_amount = abs($total_amount-$paid_amount);
		if(!empty($booking_id)):
			$bookingObj = Booking::find_by_id($booking_id);
				if(!empty($bookingObj)):
					$customer_id = $bookingObj->customer_id;
					$booking_date = $bookingObj->approve_date;
				endif;
		endif;
		if(!empty($customer_id)):
			$userObj = User::find_by_id($customer_id);
				if(!empty($userObj)):
					$client_name = $userObj->full_name;
					$mailing_address = $userObj->mailing_address;
					$client_phone = $userObj->phone;
				endif;
		endif;
		endif;
endif;

$company = new Company();
$company_obj = $company->find_by_id(1);
$company_name = $company_obj->name;
$company_address = $company_obj->address;
$company_phone = $company_obj->phone ;
$compnay_mail = $company_obj->email;

/*
if(!empty($branch_id)):
$branch = new Branch();
$branch_obj = $branch->find_by_id($branch_id);
$branch_name = $branch_obj->name;
$branch_address = $branch_obj->address;
$branch_phone = $branch_obj->phone;
$branch_email = $branch_obj->email;
endif;
*/

	$branch_name = "";
	$branch_address = "";
	$branch_phone = "";
	
	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->Image('../images/report_logo.jpg', 20, 5, 25);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(200,5,"$company_name",'','','C');
	$pdf->Ln(5,0);
	$pdf->SetFont('times','',14);
	$pdf->Cell(200,5,"$branch_name",'','','C');
	$pdf->Ln(5,0);
	$pdf->SetFont('times','',10);
	$pdf->Cell(200,5,"$branch_address, $branch_phone",'','','C');
	$pdf->Ln(8,0);
	$pdf->SetFont('Arial','',18);
	$pdf->Cell(200,5,"Bill invoice",'','','C');
	$pdf->Ln(5,0);
	$pdf->SetFont('times','',12);
	
	$pdf->Cell(22,5,"Bill No :",'','','L');
	$pdf->Cell(80,5,$bill_id,'','','L');
	$pdf->Cell(48, 48, $pdf->Code39(150, 20, $bill_id,1,0,0.3),0,0,'L',0);

	$pdf->Ln(5,0);
	$pdf->SetFont('times','',12);	
	$pdf->Cell(30,5,"Client name :",'','','L');
	$pdf->Cell(100,5,$client_name,'','','L');
	$pdf->Cell(30,5,"",'','','L');
	$pdf->Cell(30,5,"",'','','L');
	$pdf->Ln(5,0);
	$pdf->SetFont('times','',12);	
	$pdf->Cell(30,5,"Address :",'','','L');
	$pdf->Cell(100,5,$mailing_address,'','','L');
	$pdf->Cell(30,5,"Booking Date :",'','','L');
	$pdf->Cell(30,5,$booking_date,'','','L');

	$pdf->Ln(6,0);
	$pdf->SetFont('times','B',10);
	
	$pdf->Cell(14,4,"Sl",'1','','C');
	$pdf->Cell(20,4,"Category",'1','','C');
	$pdf->Cell(30,4,"Product Name",'1','','C');
	$pdf->Cell(20,4,"Weight",'1','','C');
	$pdf->Cell(30,4,"Receiver",'1','','C');
	$pdf->Cell(20,4,"Phone",'1','','C');
	$pdf->Cell(53,4,"Address",'1','','C');
	$pdf->Ln(0,0,"");
	$pdf->SetFont('times','',8);
		
		$sl= 1;
	
		$sql_find = "SELECT * FROM booking_details bd LEFT JOIN booking b ON(bd.booking_id = b.id) where b.id=".$booking_id." ";
		//echo $sql_find;
				
		$rr = BookingDetails::find_by_sql($sql_find);
		//var_dump($rr);
		foreach($rr as $details)
		{		       		 	
			$temp_id = $details->id; 
			$customer_id = $details->customer_id;
				if(!empty($customer_id)):
					$userObj = User::find_by_id($customer_id);
					if(!empty($userObj)):
					$full_name = $userObj->full_name;
					endif;
				endif;
			$service_point_id = $details->service_point_id;
			$product_category_id = $details->product_category_id;
			if(!empty($product_category_id)):
					$categoryObj = ProductCategory::find_by_id($product_category_id);
					if(!empty($categoryObj)):
					$category_name = $categoryObj->name;
					endif;
				endif;
			$product_name = $details->product_name;
			$product_description = $details->product_description;
			$packet_size = $details->packet_size;
			$packet_weight = $details->packet_weight;
			$packet_qty = $details->packet_qty;
			$receiver_name = $details->receiver_name;
			$receiver_phone = $details->receiver_phone;
			$receiver_email = $details->receiver_email;
			$receiver_address = $details->receiver_address;
			$receiver_email = $details->receiver_email;						
			$booking_status =$details->booking_status;							
			$entry_by  =$details->entry_by ;	
			
			$pdf->MultiCell(1,4,"");
			$pdf->Cell(14,4,$sl,'1','','C');
			$pdf->Cell(20,4,$category_name,'1','','L');
			$pdf->Cell(30,4,$product_name,'1','','L');
			$pdf->Cell(20,4,$packet_weight,'1','','C');
			$pdf->Cell(30,4,$receiver_name,'1','','L');
			$pdf->Cell(20,4,$receiver_phone,'1','','L');
			$pdf->Cell(53,4,$receiver_address,'1','','L');
			$sl++;
		}
						
	$pdf->Ln(4, 0,"");
	$pdf->SetFont('times','B',10);
	$pdf->Cell(167,4,"Bill Amount",'1','','R');
	$pdf->Cell(20,4,$bill_amount,'1','','R');
	$pdf->Ln(4, 0,"");
	$pdf->SetFont('times','',10);
	$pdf->Cell(167,4,"Discount",'1','','R');
	$pdf->Cell(20,4,$discount,'1','','R');
	$pdf->Ln(4, 0,"");
	$pdf->Cell(167,4,"Total Amount",'1','','R');
	$pdf->Cell(20,4,$total_amount,'1','','R');
	$pdf->Ln(4, 0,"");
	$pdf->Cell(167,4,"Paid Amount",'1','','R');
	$pdf->Cell(20,4,$paid_amount,'1','','R');
	$pdf->Ln(4, 0,"");
	$pdf->SetFont('times','B',10);
	$pdf->Cell(167,4,"Due Amount",'1','','R');
	$pdf->Cell(20,4,$due_amount,'1','','R');
	$pdf->Ln(4, 0,"");		
	$pdf->Cell(187,6,"",'1','','R');
	
$pdf->Footer("Technical support @ ARS IT", $pdf->Line(10,272,250-50,272));		
$pdf->Output();
?>
