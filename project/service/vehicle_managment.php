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
//you should use json_encode, and you can parse when get back data in ajax
//echo json_encode($rows['product_name']);
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
  <div class="box">
    <table class="table table-bordered responsive-table">
      <tbody>
        <tr>
          <td width="15%">Client Name</td>
          <td><?php echo $client_name;?></td>
          <td width="15%">Booking ID</td>
          <td><?php echo $booking_id;?></td>
        </tr>
        <tr>
          <td width="15%">Booking Status</td>
          <td><?php echo $booking_status;?></td>
          <td width="15%">Request Time</td>
          <td><?php echo $request_time;?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div id="sortableTable" class="body collapse in">
    <table class="table table-bordered sortableTable table-hover responsive-table">
      <thead>
        <tr>
          <th>Sl</th>
          <th>Category</th>
          <th>Product Name</th>
          <th>Packet Size</th>
          <th>P. Weight</th>
          <th>P. Qty</th>
          <th>Vehicle</th>
          <th>Receiving Address</th>
        </tr>
      </thead>
      <tbody>
        <?php
			
		$sl = 1;
		if(!empty($booking_id)):
		$sql_find = "SELECT * FROM booking_details where booking_id=".$booking_id." ";
			$rr = BookingDetails::find_by_sql($sql_find);
			foreach($rr as $details):
			
			$details_id = $details->id;
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
				if(!empty($details_id)):
				$exist_assign = VehicleManagment::find_by_field('booking_details_id', $details_id);
					if(!empty($exist_assign)):
					$vehicle_id = $exist_assign[0]->vehicle_id;
						if(!empty($vehicle_id)):
						$vehicleObj = Vehicle::find_by_id($vehicle_id);
							if(!empty($vehicleObj)):
							$vehicle_type = $vehicleObj->vehicle_type;
							$brand = $vehicleObj->brand;
							$model = $vehicleObj->model;
							$reg_no = $vehicleObj->reg_no;
							$assign_vehicle = $brand." ".$model." ".$reg_no;
							endif;
						endif;
					else:
						$assign_vehicle = "Not Assigned";
					endif;
				endif;		
		?>
        <tr>
          <td><?php echo $sl; ?></td>
          <td><a data-toggle="modal" class="vehicleModal" details-id="<?php echo $details_id; ?>" data-target="#vehicleModal" ><?php echo $product_category; ?></a></td>
          <td><?php echo $product_name; ?></td>
          <td><?php echo $packet_size; ?></td>
          <td><?php echo $packet_weight; ?></td>
          <td><?php echo $packet_qty; ?></td>
          <td><?php echo $assign_vehicle; ?></td>
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
</div>

<script language="JavaScript" type="text/javascript">

	$('.vehicleModal').click(function(){
        var ID=$(this).attr('details-id');
		//alert(ID);
        $.ajax({url:"vehicle_allocation.php?ID="+ID,cache:false,success:function(result){
            $(".modal-vehicle").html(result);
        }});
    });

</script>
