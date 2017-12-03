<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}
$in_user_id = $_SESSION['in_user_id'];
$present_date = date('Y-m-d', $c_date);

if(isset($_POST["details_id"]) && isset($_POST["vehicle_id"]) && $_POST["vehicle_id"] !=0){ 
//var_dump($_POST);

$details_id = $_POST["details_id"];
$vehicle_id = abs($_POST["vehicle_id"]);
$comment = abs($_POST["comment"]);

$exist_assign = VehicleManagment::find_by_field('booking_details_id', $details_id);
$vehiclemanagmentObj = new VehicleManagment();

if(!empty($exist_assign)):		
	  	$vehiclemanagmentObj->id =$exist_assign[0]->id;
		$vehiclemanagmentObj->vehicle_id = $vehicle_id;
		$vehiclemanagmentObj->comment = $comment;
	  	$vehiclemanagmentObj->save();
		$vehiclemanagment_id = $exist_assign[0]->id;
	else:	
	  	$vehiclemanagmentObj->booking_details_id = $details_id;
		$vehiclemanagmentObj->vehicle_id = $vehicle_id;
		$vehiclemanagmentObj->comment = $comment;
		$vehiclemanagmentObj->entry_by = $in_user_id;
		$result=$vehiclemanagmentObj->save();
		$vehiclemanagment_id=$database->insert_id();
	endif;
}

if(!empty($vehiclemanagment_id))
{
 	$output = "";
	$objVehicle = VehicleManagment::find_by_id($vehiclemanagment_id);
	if(!empty($objVehicle)):
	
	$details_id = $objVehicle->booking_details_id;
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
		
 $output .= '  
      <div class="responsive-table">
           <table class="table table-bordered table-hover">';
     $output .= '
     <tr>  
            <td width="35%"><label>Vehicle Type</label></td>  
            <td width="65%">'.$vehicle_type.'</td>  
        </tr>
        <tr>  
            <td width="35%"><label>Brand</label></td>  
            <td width="65%">'.$brand.'</td>  
        </tr>
        <tr>  
            <td width="35%"><label>Model</label></td>  
            <td width="65%">'.$model.'</td>  
        </tr>
        <tr>  
            <td width="35%"><label>Reg No</label></td>
            <td width="65%">'.$reg_no.'</td>  
        </tr>
        <tr>  
            <td width="35%"><label>Driver</label></td>  
            <td width="65%">Driver</td>  
        </tr>';
	endif;
    $output .= '</table></div>';
    echo $output;
	//echo $bill_id;
}

?>