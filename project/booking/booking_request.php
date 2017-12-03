<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("../logout.php");}

if(isset($_SESSION['in_user_id'])):
$in_user_id= $_SESSION['in_user_id'];
endif;
if(isset($_SESSION['in_service_point_id'])):
$in_service_point_id= $_SESSION['in_service_point_id'];
else:
$in_service_point_id= 1;
endif;

$present_date = date('Y-m-d', $c_date);
$target_page =basename($_SERVER['PHP_SELF']);

$sql="select `id`,`customer_id` from `temp_booking_details` where booking_status = 'Request' and `entry_by` ='".$in_user_id."' LIMIT 1 ";
$exist_inv = TempBookingDetails::find_by_sql($sql);
if(!empty($exist_inv)):
$search_customer = $exist_inv[0]->customer_id;
endif;

if(isset($_REQUEST["customer_id"]) && $_REQUEST["customer_id"]!=""){
$search_customer =$_REQUEST["customer_id"];
}

//file upload code
function getExtension($str) 
{
 $i = strrpos($str,".");
 if (!$i) { return ""; }
 $l = strlen($str) - $i;
 $ext = substr($str,$i+1,$l);
 return $ext;
}

$errors=0;
$FILE_PATH = "../purchase_invoice";
$image_name="";

//var_dump($_POST);

if(isset($_POST['add']) && !empty($_FILES["purchase_invoice"]['tmp_name'])):

 	$image=$_FILES['purchase_invoice']['tmp_name'];
 	if($image):
 		$filename = stripslashes($_FILES['purchase_invoice']['name']);
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
		 if((!$extension )):
			$message = 'Unknown extension!';
 			$errors=1;
 	     else:
			$size=filesize($_FILES['purchase_invoice']['tmp_name']);
			$filetype=$_FILES['purchase_invoice']['type'];
			$size=round($size/1048576, 2); //return MB in size
			//echo $_FILES['image']['tmp_name'];
				
			if($size>4):	
			$message=$message."Your uploaded file size is more than 4MB so please reduce the file size and then upload. <BR>";		
			elseif(!($filetype =="image/jpeg" || $filetype=="image/gif" || $filetype=="image/png")):
				$message=$message."Your uploaded file must be of JPG or GIF. Other file types are not allowed<BR>";
				
			else:
				if(isset($_POST["secretId"])):
				//for update first delete old file and update new file
				$sql ="SELECT `id`,`purchase_invoice` FROM `temp_booking_details` where id=".$_POST["secretId"]." limit 1 ";
				$rr=TempBookingDetails::find_by_sql($sql);
					foreach($rr as $cvd):
						$exist=is_file("../purchase_invoice/".$cvd->purchase_invoice);
						if($exist==1):
							unlink("../purchase_invoice/".$cvd->purchase_invoice);
						endif;
					endforeach;	
				//echo "re-1";
				$image_name=time().'.'.$extension;
				$newname=$FILE_PATH."/".$image_name;
				$copied = copy($_FILES['purchase_invoice']['tmp_name'], $newname);
					if(!$copied):
						$message = 'Copy unsuccessfull!';
						$errors=1;
					endif;
				else:
				//for insert
				$image_name=time().'.'.$extension;
				$newname=$FILE_PATH."/".$image_name;
				$copied = copy($_FILES['purchase_invoice']['tmp_name'], $newname);
					if(!$copied):
						$message = 'Copy unsuccessfull!';
						$errors=1;
					endif;
				endif;							
			endif;		
	     endif;	
	endif;
endif;

////////////////// add booking ///////////////////
if(isset($_POST["add"]) && isset($_POST["receiver_phone"]) && isset($_POST["receiver_phone"]) !='')
{ 
//var_dump($_POST);

	$customer_id = $_POST['customer_ids'];
	
  	$tempbookingdetails = new TempBookingDetails;
	$tempbookingdetails->customer_id = $_POST["customer_ids"];
	$tempbookingdetails->service_point_id = $in_service_point_id;
	$tempbookingdetails->product_category_id = $_POST["product_category_id"];
	$tempbookingdetails->product_name =  $_POST["product_name"];
  	$tempbookingdetails->product_description = $_POST["product_description"];	
	$tempbookingdetails->packet_size = $_POST["packet_size"];
	$tempbookingdetails->packet_weight = $_POST["packet_weight"];
	$tempbookingdetails->packet_qty =  $_POST["packet_qty"];
  	$tempbookingdetails->receiver_name = $_POST["receiver_name"];	
	$tempbookingdetails->receiver_phone = $_POST["receiver_phone"];
	$tempbookingdetails->receiver_email = $_POST["receiver_email"];
	$tempbookingdetails->receiver_address = $_POST["receiver_address"];
	$tempbookingdetails->booking_status =  "Request";
	
	$tempbookingdetails->entry_by = $in_user_id;
	
	if(isset($image_name) && $image_name!=""): 
	$tempbookingdetails->purchase_invoice = $image_name; 
	endif;
	
	$tempbookingdetails->save();
 	redirect_to($target_page."?customer_id=".$customer_id);
}

////////////////// Save Booking ///////////////////

if(isset($_POST['Save']) && !empty($search_customer)){
$sql="select `id` from `temp_booking_details` where `entry_by` ='".$in_user_id."' AND booking_status='Request' ";
$temp_booking = TempBookingDetails::find_by_sql($sql);
if(!empty($temp_booking)):
$booking = new Booking; 
$booking->customer_id = $search_customer;
$booking->service_point_id = $in_service_point_id;
$booking->booking_status = "Booked" ;
$booking->entry_by = $in_user_id;	
$result=$booking->save();	
if($result):
	$booking_id=$database->insert_id();
		if($booking_id):
		  $result3=BookingDetails::transfre_data($booking_id, $in_user_id);
		  $_SESSION['last_inv_id'] = $booking_id;
		endif;	
	endif;	
endif;
redirect_to($target_page);												
}

////////////////// Delete Booking ///////////////////

if(isset($_GET["id"]) && isset($_GET["d"])){
	
$customer_id=$_GET["customer_id"];
$objData = TempBookingDetails ::find_by_id($_GET["id"]);
$objData->delete();
redirect_to($target_page."?customer_id=".$customer_id);
}

////////////////// reset booking ////////////////	

if(isset($_POST["reset"])):
$objData=new TempBookingDetails ;
$objData->reset_booking($in_user_id);
redirect_to($target_page);										
endif;

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<!--IE Compatibility modes-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--Mobile first-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php echo $title;?>Booking request</title>
<link rel="icon" href="../images/logo_ico.png" type="image/x-icon">
<meta name="description" content="Free Admin Template Based On Twitter Bootstrap 3.x">
<meta name="author" content="">
<meta name="msapplication-TileColor" content="#5bc0de" />
<meta name="msapplication-TileImage" content="/ars_courier/project/assets/img/metis-tile.png" />

<!-- Bootstrap -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/bootstrap/css/bootstrap.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/font-awesome/css/font-awesome.css">

<!-- Metis core stylesheet -->
<link rel="stylesheet" href="/ars_courier/project/assets/css/main.css">

<!-- metisMenu stylesheet -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/metismenu/metisMenu.css">

<!-- onoffcanvas stylesheet -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/onoffcanvas/onoffcanvas.css">

<!-- animate.css stylesheet -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/animate.css/animate.css">
<link rel="stylesheet" href="/ars_courier/project/assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="/ars_courier/project/assets/lib/inputlimiter/jquery.inputlimiter.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/uniform/uniform.default.min.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/chosen/chosen.min.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/jquery-tagsinput/jquery.tagsinput.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/jasny-bootstrap/jasny-bootstrap.min.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/bootstrap-switch/bootstrap-switch.min.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<link rel="stylesheet" href="/ars_courier/project/assets/css/style-switcher.css">
<link rel="stylesheet/less" type="text/css" href="/ars_courier/project/assets/less/theme.less">
<script src="/ars_courier/project/assets/less/less.js"></script>
<script type="text/javascript" src="/ars_courier/project/gen_validatorv4.js"></script>
<script language="javascript" >

function validateFileType(){
	var fileName = document.getElementById("fileName").value;
	var idxDot = fileName.lastIndexOf(".") + 1;
	var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
	if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile=="gif"){
		//TO DO
	}else{
		document.getElementById("fileName").value = "";
		alert("Only jpg/jpeg and png files are allowed!");	
	}   
}
				
function disp_confirm()
{
return confirm("Are You Sure You want to Delete");
}
</script>
</head>

<body class="  ">
<div class="bg-dark dk" id="wrap">
  <div id="top"> 
    <!-- .navbar -->
    <?php require("../top_navigation.php"); ?>
    <!-- /.navbar -->
    <header class="head">
      <div class="search-bar">
        <form class="main-search" action="">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Live Search ...">
            <span class="input-group-btn">
            <button class="btn btn-primary btn-sm text-muted" type="button"> <i class="fa fa-search"></i> </button>
            </span> </div>
        </form>
        <!-- /.main-search --> </div>
      <!-- /.search-bar -->
      <div class="main-bar">
        <h3> <i class="fa fa-pencil"></i>&nbsp;
          Booking Request </h3>
      </div>
      <!-- /.main-bar --> 
    </header>
    <!-- /.head --> 
  </div>
  <!-- /#top -->
  <?php require("../left_menu.php"); ?>
  <!-- /#left -->
  <div id="content">
    <div class="outer">
      <div class="inner bg-light lter"> 
        <!--BEGIN INPUT TEXT FIELDS-->
        <div class="row">
          <div class="col-lg-12">
            <div class="box dark">
              <header>
                <div class="icons"><i class="fa fa-edit"></i></div>
                <h5>Booking Request</h5>
                <!-- .toolbar -->
                <div class="toolbar">
                  <nav style="padding: 8px;"> <a href="javascript:;" class="btn btn-default btn-xs collapse-box"> <i class="fa fa-minus"></i> </a> <a href="javascript:;" class="btn btn-default btn-xs full-box"> <i class="fa fa-expand"></i> </a> </nav>
                </div>
                <!-- /.toolbar --> 
              </header>
              <div id="div-1" class="body">
                <form class="form-horizontal" name="client_frm" method="post" action="<?php echo basename($_SERVER['PHP_SELF']); ?>">
                  <div class="form-group">
                    <label class="control-label col-lg-2">Client Name</label>
                    <div class="col-lg-3">
                      <select name="customer_id" id="client_id" class="form-control autotab" tabindex="1" <?php if(isset($readonly)) {echo $readonly; }?> onchange="client_frm.submit()">
                        <option value="" >Client name</option>
                        <?php $sst ="";	
						
						$user_type = 4;
                        $rr=User::find_client_user($user_type);
                        foreach($rr as $customer)
                        {
                        if(isset($search_customer) && $search_customer!="" && ($customer->id==$search_customer)){$sst="selected"; } 
                        else if (isset($search_customer) && $search_customer!="") { $sst="disabled"; }
                        ?>
                        <option value="<?php echo $customer->id; ?>" <?php if(isset($sst)) echo $sst; ?>><?php echo $customer->full_name; ?></option>
                        <?php 
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </form>
                <!-- /.form-group -->
                <form class="form-horizontal" role="form" enctype="multipart/form-data" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST" name="add_product">
                  <div class="form-group">
                    <label class="control-label col-lg-2">Poduct Category</label>
                    <div class="col-lg-3">
                      <select class="form-control autotab" tabindex="2" name="product_category_id" >
                        <option value="" >Select Category</option>
                        <?php 	
                        $rr=ProductCategory::find_all();
                        foreach($rr as $category)
						{
                        ?>
                        <option value="<?php echo $category->id; ?>"<?php if(isset($booking_edit_id) && $category->id==$product_category_id)
						{ 
                            echo "selected class='selected'";}?>> <?php echo $category->name; ?></option>
                        <?php 
                        }
                        ?>
                      </select>
                    </div>
                    <label class="control-label col-lg-2">Product Name</label>
                    <div class="col-lg-3">
                      <input type="text" tabindex="3" name="product_name" placeholder="Product Name" class="form-control" value="">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label class="control-label col-lg-2">Product Description</label>
                    <div class="col-lg-3">
                      <input type="text" name="product_description" placeholder="Product Description" class="form-control" value="">
                    </div>
                    <label class="control-label col-lg-2">Packet Size</label>
                    <div class="col-lg-3">
                      <input type="text" name="packet_size" placeholder="Packet Size" class="form-control" value="">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label class="control-label col-lg-2">Packet Weight</label>
                    <div class="col-lg-3">
                      <input type="text" name="packet_weight" placeholder="Packet Weight" class="form-control" value="">
                    </div>
                    <label class="control-label col-lg-2">Purchase invoice</label>
                    <div class="col-lg-3">
                      <input type="file" id="fileName" accept=".jpg,.jpeg,.png,.gif" onchange="validateFileType()" name="purchase_invoice" placeholder="Purchase invoice" value="">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label class="control-label col-lg-2">Packet Qty.</label>
                    <div class="col-lg-2">
                      <input type="text" name="packet_qty" placeholder="Send Qty." class="form-control" value="1">
                    </div>
                    <label class="control-label col-lg-1">&nbsp;</label>
                    <label class="control-label col-lg-2">Receive Amount</label>
                    <div class="col-lg-2">
                      <input type="text" name="receive_amount" placeholder="Receive Amount" class="form-control" value="">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label class="control-label col-lg-2">Receiver Name</label>
                    <div class="col-lg-3">
                      <input type="text" name="receiver_name" placeholder="Receiver Name" class="form-control" value="">
                    </div>
                    <label class="control-label col-lg-2">Receiver Phone</label>
                    <div class="col-lg-3">
                      <input type="text" name="receiver_phone" placeholder="Receiver Phone" class="form-control" value="">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label class="control-label col-lg-2">Receiver email</label>
                    <div class="col-lg-3">
                      <input type="email" name="receiver_email" placeholder="Receiver email" class="form-control" value="">
                    </div>
                    <label class="control-label col-lg-2">Receiver address</label>
                    <div class="col-lg-3">
                      <input type="text" name="receiver_address" placeholder="Receiver address" class="form-control" value="">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <div class="col-lg-2">&nbsp; </div>
                    <div class="col-lg-4">
                      <input type="hidden" value="<?php if(isset($search_customer)){ echo $search_customer; } ?>"  name="customer_ids"  />
                      <input type="submit" class="btn btn-primary btn-grad" name="add" onclick="return check_empty();" value="Add">
                      <input type="reset" class="btn btn-primary btn-grad" name="new" value="New" >
                    </div>
                  </div>
                </form>
              </div>
              <script language="JavaScript" type="text/javascript">
            //<![CDATA[
  			//You should create the validator only after the definition of the HTML form
			
			function check_empty(){
					var add_product=document.forms['add_product'];
					if(add_product.elements['product_category_id'].value==""){  alert("Please select Category"); return false; }else {}
					var client_frm=document.forms['client_frm'];
					if(client_frm.elements['customer_id'].value==""){  alert("Please select Client"); return false; }else {}
					}
					
  			var frmvalidator  = new Validator("add_product");
  			frmvalidator.addValidation("product_name","req","Please enter product name");
  			frmvalidator.addValidation("product_name","maxlen=30","User Name is not more than 30 character");
			frmvalidator.addValidation("packet_weight","req","Please enter product weights");
			frmvalidator.addValidation("receive_amount","number","Please enter Receiver name");
  			frmvalidator.addValidation("receiver_name","req","Please enter Receiver name");
			frmvalidator.addValidation("receiver_phone","req","Please enter Receiver phone number");
  			frmvalidator.addValidation("receiver_phone","neelmnt=receiver_name","The Receiver phone should not be same as Receiver name");
			frmvalidator.addValidation("receiver_address","req","Please enter Receiver address");
				
  			//var security_code=.$_SESSION['security_code'];
  			//frmvalidator.addValidation("txtCaptcha","eqelmnt=security_code","Security code is not Correct");
  			
			//]]></script>
              <hr>
              <!--BEGIN Table-->
              <div class="row">
                <div class="col-lg-12">
                  <div class="box">
                    <header>
                      <h5>Pending Booking request</h5>
                      <div class="toolbar">
                        <div class="btn-group"> <a href="#sortableTable" data-toggle="collapse" class="btn btn-default btn-xs collapse-box"> <i class="fa fa-minus"></i> </a> </div>
                      </div>
                    </header>
                    <div style="height:405px; padding-left:.5em; padding-top:.5em; overflow:auto">
                      <table id="dataTable" width="100%" class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                          <tr>
                            <th>Poduct Category</th>
                            <th>Poduct Name</th>
                            <th>Packet Weight</th>
                            <th>Receiver Name</th>
                            <th>Receiver Phone</th>
                            <th>Booking Status</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

					$sql= "select * from `temp_booking_details` where entry_by=".$in_user_id." AND `booking_status` = 'Request' ORDER BY `entry_date`";
							//echo $sql;
							$rr=TempBookingDetails::find_by_sql($sql);
							foreach($rr as $tempdetails){	
							
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
									
							?>
                          <tr>
                            <td><?php echo $category_name; ?></td>
                            <td><?php echo $product_name; ?></td>
                            <td><?php echo $packet_weight; ?></td>
                            <td><?php echo $receiver_name; ?></td>
                            <td><?php echo $receiver_phone; ?></td>
                            <td><?php echo $booking_status; ?></td>
                            <td><a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?id=<?php if(!empty($temp_id)) echo $temp_id."&d=1"; ?>" onclick="return disp_confirm(this)"> <span class="glyphicon glyphicon-remove-circle" style="margin-left:5px; font-size:20px; color: #EC6CA6;"></span>Delete</a></td>
                          </tr>
                          <?php
                }
                ?>
                        </tbody>
                      </table>
                    </div>
                    <form class="form-horizontal" name="final_entry" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post"  >
                      <table align="center" border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center"><input class="btn btn-primary btn-grad" tabindex="4" type="submit" value="Save" name="Save">
                            <a data-toggle="modal" data-original-title="Print" data-placement="bottom" class="btn btn-primary btn-grad" href="#printModal"> <em class="fa fa-print"></em>&nbsp;Print</a>
                            <input class="btn btn-primary btn-grad" tabindex="5" type="button" name="reset" value="New"></td>
                        </tr>
                      </table>
                    </form>
                  </div>
                </div>
                
                <!--END Table--> 
              </div>
              <!--END Row--> 
            </div>
          </div>
        </div>
      </div>
      <!-- /.row --> 
      
    </div>
  </div>
  <!-- /.inner --> 
</div>
<!-- /.outer -->
</div>
<!-- /#content -->

</div>
<!-- /#wrap -->
<?php require("../footer.php"); ?>
<!-- /#footer --> 
<!-- #printModal -->
<div id="printModal" class="modal fade" >
  <div class="modal-dialog modal-lg" >
    <div class="modal-content" style="height:42em">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Pending booking request!</h4>
      </div>
      <div class="modal-body">
        <iframe name="print" style="width:61em; height:35em;" src="print_booking.php?inv_id=<?php if(isset($_SESSION['last_inv_id'])){ echo $_SESSION['last_inv_id']; } ?>" > </iframe>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 
<!-- /#printModal --> 
<!--jQuery --> 

<script src="/ars_courier/project/assets/lib/jquery/jquery.js"></script> 
<script src="/ars_courier/project/assets/lib/jquery/jquery-ui.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/datatables/jquery.dataTables.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/datatables/dataTables.bootstrap.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/datatables/jquery.tablesorter.min.js"></script> 
<script src="/ars_courier/project/assets/lib/jquery/jquery.ui.touch-punch.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/autosize/jquery.autosize.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/jasny-bootstrap/jasny-bootstrap.min.js"></script> 
<script src="/ars_courier/project/assets/lib/inputlimiter/jquery.inputlimiter.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/bootstrap-switch/bootstrap-switch.min.js"></script> 

<!--Bootstrap --> 
<script src="/ars_courier/project/assets/lib/bootstrap/js/bootstrap.js"></script> 
<!-- MetisMenu --> 
<script src="/ars_courier/project/assets/lib/metismenu/metisMenu.js"></script> 
<!-- onoffcanvas --> 
<script src="/ars_courier/project/assets/lib/onoffcanvas/onoffcanvas.js"></script> 
<!-- Screenfull --> 
<script src="/ars_courier/project/assets/lib/screenfull/screenfull.js"></script> 

<!-- Metis core scripts --> 
<script src="/ars_courier/project/assets/js/core.js"></script> 
<!-- Metis demo scripts --> 
<script src="/ars_courier/project/assets/js/app.js"></script> 
<script>

$(function() {
  Metis.MetisTable();
  Metis.metisSortable();
});
</script> 
<script src="/ars_courier/project/assets/js/style-switcher.js"></script>
</body>
</html>
