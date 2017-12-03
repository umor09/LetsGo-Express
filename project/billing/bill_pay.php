<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}

//dataId comes from ajax (POST)
$booking_id = filter_input(INPUT_GET, 'ID');

$bookingObj = Booking::find_by_id($booking_id);
if(!empty($bookingObj)):
 $service_point_id = $bookingObj->service_point_id;
 $customer_id = $bookingObj->customer_id;
 $booking_status = $bookingObj->booking_status;
 $request_time = $bookingObj->request_time;
	 if(!empty($customer_id)):
	 $clientObj = User::find_by_id($customer_id);
		if(!empty($clientObj)):
		$client_name = $clientObj->full_name;
		endif;
	 endif;
endif;

$exist_bill = Bill::find_by_field('booking_id', $booking_id);
if(!empty($exist_bill)):
$exist_id =$exist_bill[0]->id;
$exist_amount =$exist_bill[0]->bill_amount;
$exist_discount =$exist_bill[0]->discount;
$exist_paid =$exist_bill[0]->paid_amount;
$readonly = "readonly";
endif;
?>

<div class="col-lg-12">
  <div class="box" style="height:2em">
    <div class="form-group">
      <label class="control-label col-lg-2" align="right">Client Name:</label>
      <div class="col-lg-3"> <?php echo $client_name;?> </div>
      <label class="control-label col-lg-2" align="right">Booking Status:</label>
      <div class="col-lg-3"> <?php echo $booking_status;?> </div>
    </div>
  </div>
  <div style="height:280px; overflow:auto">
    <table class="table table-bordered sortableTable table-hover responsive-table">
      <thead>
        <tr>
          <th>Sl</th>
          <th>category</th>
          <th>Product Name</th>
          <th>Packet Size</th>
          <th>P. Weight</th>
          <th>P. Qty</th>
          <th>Receiver</th>
          <th>Receiving Address</th>
        </tr>
      </thead>
      <tbody>
        <?php
		   $sl = 1;
				if(!empty($booking_id)):
					$sql_find = "SELECT * FROM booking_details bd LEFT JOIN booking b ON(bd.booking_id = b.id) where b.id=".$booking_id." ";
					$rr = BookingDetails::find_by_sql($sql_find);
					foreach($rr as $details):
						
						$product_category_id = $details->product_category_id;  
						$product_name = $details->product_name;
						$packet_size = $details->packet_size ;
						$packet_weight  = $details->packet_weight ;
						$packet_qty =$details->packet_qty;
						$receiver_name = $details->receiver_name ;
						$receiver_phone = $details->receiver_phone ;
						$receiver_address = $details->receiver_address ;
							if($product_category_id != 0 && $product_category_id != '' ):
							$categoryObj = ProductCategory::find_by_id($product_category_id);
							$product_category = $categoryObj->name;
							endif;
							
					?>
                    <tr>
                      <td><?php echo $sl; ?></td>
                      <td><?php echo $product_category; ?></td>
                      <td><?php echo $product_name; ?></td>
                      <td><?php echo $packet_size; ?></td>
                      <td><?php echo $packet_weight; ?></td>
                      <td><?php echo $packet_qty; ?></td>
                      <td><?php echo $receiver_name; ?></td>
                      <td><?php echo $receiver_address; ?></td>
                    </tr>
        <?php
				  $sl++;
                endforeach;
			endif;
         ?>
      </tbody>
    </table>
  </div>
  <div class="body col-lg-7">
    <form class="form-horizontal" role="form" method="POST" name="billfrm" id="billfrm" action="">
      <div class="form-group">
        <label class="control-label col-lg-3">Bill Amount</label>
        <div class="col-lg-4">
          <input type="text" tabindex="1" name="bill_amount" id="bill_amount" <?php if(!empty($readonly)){ echo $readonly;}?> placeholder="Bill Amount" class="form-control" value="<?php if(!empty($exist_bill)){ echo $exist_amount;}?>">
        </div>
      </div>
      <!-- /.form-group -->
      
      <div class="form-group">
        <label class="control-label col-lg-3">Discount</label>
        <div class="col-lg-4">
          <input type="text" tabindex="2" name="discount" id="discount" placeholder="Discount" <?php if(!empty($readonly)){ echo $readonly;}?> class="form-control" value="<?php if(!empty($exist_bill)){ echo $exist_discount;}?>">
        </div>
      </div>
      <!-- /.form-group -->
      
      <div class="form-group">
        <label class="control-label col-lg-3">Paid amount</label>
        <div class="col-lg-4">
          <input type="text" tabindex="3" name="paid_amount" id="paid_amount" placeholder="Paid amount" class="form-control" value="<?php if(!empty($exist_bill)){ echo $exist_paid;}?>">
        </div>
      </div>
      <!-- /.form-group -->
      
      <div class="form-group">
        <div class="col-lg-3">&nbsp; </div>
        <div class="col-lg-4">
        <input type="hidden" name="booking_id" id="booking_id" value="<?php echo $booking_id; ?>">
          <input type="button" id="payment" tabindex="4" class="btn btn-primary btn-grad payment" value="Payment">
          <!--<a data-toggle="modal" data-original-title="Print" data-placement="bottom" class="btn btn-primary btn-grad printModal" data-id="<?php //echo $booking_id; ?>" data-target="#printModal"> <em class="fa fa-print"></em>&nbsp;Print</a>--> 
        </div>
      </div>
    </form>
  </div>
  <div id="div-result" class="col-sm-5" style="margin:-1.5em">
  </div>
</div>

<script language="JavaScript" type="text/javascript">

$(document).ready(function(){
$(".payment").click(function (e){  
  e.preventDefault(); 
 
   var booking_id = $('#detailsModal #booking_id').val();
   var bill_amount = $('#detailsModal #bill_amount').val(); 
   var discount = $('#detailsModal #discount').val();
   var paid_amount = $('#detailsModal #paid_amount').val(); // As many fields you have on your Form */
 //console.log(bill_amount);
 //alert(bill_amount);
  
  if(booking_id == "")  
  {  
   alert("Booking ID not found !"); 
   return false;   
  }  
  else if(bill_amount == "" || !Number(bill_amount))  
  {  
   alert("Enter Bill amount as a Number");
   $('#detailsModal #bill_amount').focus();
   return false;   
  }  
 /* else if(discount != "" && discount != 0)  
  {  
   alert("Enter Discount amount as a Number (%)");
   $('#detailsModal #discount').focus();
   return false;   
  }  */
  else if(paid_amount == "" || !Number(paid_amount))
  {  
   alert("Enter Paid amount as a Number");
   $('#detailsModal #paid_amount').focus();
   return false; 
  }
   
  else  
  {  
  	//build a post data structure
  var dataString = 'booking_id='+ booking_id + '&bill_amount='+ bill_amount+ '&discount='+ discount+ '&paid_amount='+ paid_amount ; 
   $.ajax({  
	  type: "POST", // HTTP method POST or GET
	  url: "bill_pay.sql.php", //PHP Page where all your query will write
	  dataType:"text", // Data type, HTML, json etc.
	  data:dataString, //Form Field values 
    beforeSend:function(){  
     $('#detailsModal #payment').val("Saved>>");  
    },  
    success:function(data){ 
		$('#detailsModal #billfrm')[0].reset(); 
		$('#detailsModal #div-result').html(data);
		     
    },
	 
   });  
  }  
 });
});
</script>

