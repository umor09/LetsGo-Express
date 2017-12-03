<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])){ redirect_to("../logout.php");}
$present_date = date("d-M-Y", $c_date);

if(isset($_GET['inv_id']) && !empty($_GET['inv_id'])):
$inv_no = $_GET['inv_id'];
endif;

if(empty($inv_no)):
  echo "No New Invoice Created !"; 
  return; 
endif;

if(!empty($inv_no)):	
$booking = new Booking();
$booking_obj = $booking->find_by_id($inv_no);
$service_point_id = $booking_obj->service_point_id;
$customer_id = $booking_obj->customer_id;
$status = $booking_obj->booking_status;
$entry_date = $booking_obj->entry_date;
$entry_date  = date('d-m-Y', strtotime($entry_date));
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
	$pdf->Cell(200,5,"Pending Request",'','','C');
	$pdf->Ln(5,0);
	$pdf->SetFont('times','',12);
	$pdf->Cell(8,5,"",'','','');
	$pdf->Cell(22,5,"Invoice No :",'','','L');
	$pdf->Cell(105,5,"$inv_no",'','','L');

	$pdf->Ln(5,0);
	$pdf->SetFont('times','',12);
	$pdf->Cell(8,5,"",'','','');
	$pdf->Cell(15,5,"Status :",'','','L');
	$pdf->Cell(110,5,$status,'','','L');
	$pdf->Cell(25,5,"Invoice Date :",'','','L');
	$pdf->Cell(30,5,$entry_date,'','','L');

	$pdf->Ln(6,0);
	$pdf->SetFont('times','B',10);
	$pdf->Cell(8,5,"",'','','');
	$pdf->Cell(14,4,"Sl",'1','','C');
	$pdf->Cell(20,4,"Category",'1','','C');
	$pdf->Cell(30,4,"Product Name",'1','','C');
	$pdf->Cell(20,4,"Weight",'1','','C');
	$pdf->Cell(30,4,"Receiver",'1','','C');
	$pdf->Cell(20,4,"Phone",'1','','C');
	$pdf->Cell(45,4,"Address",'1','','C');
	$pdf->Ln(0,0,"");
	$pdf->SetFont('times','',8);
		
		$sl= 1;
	
		$sql_find = "SELECT * FROM booking_details bd LEFT JOIN booking b ON(bd.booking_id = b.id) where b.id=".$inv_no." ";
		//echo $sql_find;
				
		$rr = BookingDetails::find_by_sql($sql_find);
		//var_dump($rr);
		foreach($rr as $tempdetails)
		{		       		 	
			$temp_id = $tempdetails->id; 
			$customer_id = $tempdetails->customer_id;
				if(!empty($customer_id)):
					$userObj = User::find_by_id($customer_id);
					if(!empty($userObj)):
					$full_name = $userObj->full_name;
					endif;
				endif;
			$service_point_id = $tempdetails->service_point_id;
			$product_category_id = $tempdetails->product_category_id;
			if(!empty($product_category_id)):
					$categoryObj = ProductCategory::find_by_id($product_category_id);
					if(!empty($categoryObj)):
					$category_name = $categoryObj->name;
					endif;
				endif;
			$product_name = $tempdetails->product_name;
			$product_description = $tempdetails->product_description;
			$packet_size = $tempdetails->packet_size;
			$packet_weight = $tempdetails->packet_weight;
			$packet_qty = $tempdetails->packet_qty;
			$receiver_name = $tempdetails->receiver_name;
			$receiver_phone = $tempdetails->receiver_phone;
			$receiver_email = $tempdetails->receiver_email;
			$receiver_address = $tempdetails->receiver_address;
			$receiver_email = $tempdetails->receiver_email;						
			$booking_status =$tempdetails->booking_status;							
			$entry_by  =$tempdetails->entry_by ;	
			
			$pdf->MultiCell(1,4,"");
			$pdf->Cell(8,4,"",'','','');
			$pdf->Cell(14,4,$sl,'1','','C');
			$pdf->Cell(20,4,$category_name,'1','','L');
			$pdf->Cell(30,4,$product_name,'1','','L');
			$pdf->Cell(20,4,$packet_weight,'1','','C');
			$pdf->Cell(30,4,$receiver_name,'1','','L');
			$pdf->Cell(20,4,$receiver_phone,'1','','L');
			$pdf->Cell(45,4,$receiver_address,'1','','L');
			$sl++;
		}
						
	$pdf->Ln(4, 0,"");		
	$pdf->Cell(8, 4,"",'','','R');
	$pdf->Cell(179,4,"",'1','','R');
	
$pdf->Footer("Technical support @ARS IT", $pdf->Line(10,272,250-50,272));		
$pdf->Output();
?>
