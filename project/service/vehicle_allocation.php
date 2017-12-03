<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}

//dataId comes from ajax (POST)
$details_id = filter_input(INPUT_GET, 'ID');

$detailsObj = BookingDetails::find_by_id($details_id);
if(!empty($detailsObj)):
$details_id = $detailsObj->id;
 $product_category_id = $detailsObj->product_category_id;
 $product_name = $detailsObj->product_name;
 $packet_size = $detailsObj->packet_size;
 $packet_weight = $detailsObj->packet_weight;
 $receiver_address = $detailsObj->receiver_address;
	 if(!empty($product_category_id)):
	 $productObj = ProductCategory::find_by_id($product_category_id);
		if(!empty($productObj)):
		$category_name = $productObj->name;
		endif;
	 endif;
	 if(!empty($details_id)):
				$exist_assign = VehicleManagment::find_by_field('booking_details_id', $details_id);
					if(!empty($exist_assign)):
					$vehicle_id = $exist_assign[0]->vehicle_id;
					$exist_comment = $exist_assign[0]->comment;
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
endif;


?>

<div class="col-lg-12">
  <table id="dataTable" width="100%" class="table table-bordered table-hover">
    <tbody>
      <tr>
        <td align="right" width="15%">Category Name:</td>
        <td align="left" width="25%"><?php echo $category_name; ?></td>
        <td align="right" width="15%">Product Name:</td>
        <td align="left" width="45%"><?php echo $product_name; ?></td>
      </tr>
      <tr>
        <td align="right">Packet Size:</td>
        <td align="left"><?php echo $packet_size; ?></td>
        <td align="right">Packet Weight:</td>
        <td align="left"><?php echo $packet_weight; ?></td>
      </tr>
      <tr>
        <td align="right" width="15%">Receiver Address:</td>
        <td align="left" colspan="3"><?php echo $receiver_address; ?></td>
      </tr>
      <tr>
        <td align="right" width="15%">Vehicle:</td>
        <td align="left" colspan="3"><?php echo $assign_vehicle; ?></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="body col-lg-7">
  <form class="form-horizontal" role="form" method="POST" name="vehiclefrm" id="vehiclefrm" action="">
    <div class="form-group">
      <label class="control-label col-lg-3">Select Vehicle</label>
      <div class="col-lg-4">
        <select class="form-control autotab" tabindex="2" name="vehicle_id" id="vehicle_id" >
          <option value="" >Select Vehicle</option>
          <?php 	
			$rr=Vehicle::find_all();
			foreach($rr as $vehicle)
			{
			?>
<option value="<?php echo $vehicle->id; ?>"<?php if(isset($vehicle_id) && $vehicle->id==$vehicle_id)
			{ 
			echo "selected class='selected'";}?>> <?php echo $vehicle->brand."- ".$vehicle->reg_no ; ?></option>
			<?php 
				}
			?>
        </select>
      </div>
    </div>
    
    <!-- /.form-group -->
    
    <div class="form-group">
      <label class="control-label col-lg-3">Comment</label>
      <div class="col-lg-4">
        <input type="text" tabindex="3" name="comment" id="comment" placeholder="Comment" class="form-control" value="<?php if(!empty($exist_comment)){ echo $exist_comment;}?>">
      </div>
    </div>
    <!-- /.form-group -->
    
    <div class="form-group">
      <div class="col-lg-3">&nbsp; </div>
      <div class="col-lg-4">
        <input type="hidden" name="details_id" id="details_id" value="<?php echo $details_id; ?>">
        <input type="button" id="allocate" tabindex="4" class="btn btn-primary btn-grad allocate" value="Assign">
      </div>
    </div>
  </form>
</div>
<div id="div-result" class="col-sm-5" style="margin-left:-12em;"> </div>
</div>
<script language="JavaScript" type="text/javascript">

$(document).ready(function(){
$(".allocate").click(function (e){  
  e.preventDefault(); 
 
   var details_id = $('#vehicleModal #details_id').val();
   var vehicle_id = $('#vehicleModal #vehicle_id').val(); 
   var comment = $('#vehicleModal #comment').val(); // As many fields you have on your Form */
	//alert(vehicle_id);
  if(details_id == "")  
  {  
   alert("Booking not found !"); 
   return false;   
  }  
  else if(vehicle_id == "" || vehicle_id == 0)  
  {  
   alert("Select a vehicale for booking");
   $('#vehicleModal #vehicle_id').focus();
   return false;   
  }  
  else  
  {  
  	//build a post data structure
  var dataString = 'details_id='+details_id+ '&vehicle_id='+vehicle_id+'&comment='+comment; 
   $.ajax({  
	  type: "POST", // HTTP method POST or GET
	  url: "vehicle_allocation.sql.php", //PHP Page where all your query will write
	  dataType:"text", // Data type, HTML, json etc.
	  data:dataString, //Form Field values 
    beforeSend:function(){  
     $('#vehicleModal #allocate').val("Saved>>");  
    },  
    success:function(data){ 
		$('#vehicleModal #vehiclefrm')[0].reset(); 
		$('#vehicleModal #div-result').html(data);	     
    }  
   });  
  }  
 });
});
</script> 
