<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}
$in_user_id = $_SESSION['in_user_id'];
$present_date = date('Y-m-d', $c_date);

if(isset($_POST["status"]) && $_POST["status"]!= ""){
$search_status = $_POST['status'];
}

?>
<div class="gate_pass_table" style="height:405px; overflow:auto">
<table id="dataTable" width="100%" class="table table-bordered table-condensed table-hover table-striped">
  <thead>
    <tr>
      <th>Vehicle Type</th>
      <th>Brand</th>
      <th>Model</th>
      <th>Reg. No</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
			$find ="";
			if(!empty($search_status)):
				$find = "AND `status`='$search_status'";
				else:
				$find = "AND `status`='T'";
			endif;
			
			$sql= "select * from `vehicle` where `id` != '' ".$find." ORDER BY `entry_date` ";
			//echo $sql;
			$rr=Vehicle::find_by_sql($sql);
			foreach($rr as $vehicleObj){
			
			$vehicle_id = $vehicleObj->id;  
			$vehicle_type = $vehicleObj->vehicle_type;
			$brand = $vehicleObj->brand;
			$model = $vehicleObj->model;
			$reg_no = $vehicleObj->reg_no;
			$vehicle_status =$vehicleObj->status; 
					
			?>
    <tr>
      <td><?php echo $vehicle_type; ?></td>
      <td><?php echo $brand; ?></td>
      <td><?php echo $model; ?></td>
      <td><?php echo $reg_no; ?></td>
      <td align="center"><?php echo $vehicle_status; ?></td>
      <td><input type="checkbox" id="vehicle" class="vehicle" data-id="<?php echo $vehicle_id; ?>" name="status<?php if(!empty($vehicle_id)) echo $vehicle_id; ?>" value="F" <?php if($vehicle_status == "F") echo 'checked="checked"'; ?> />
        Pass </td>
    </tr>
    <?php
       }
    ?>
  </tbody>
</table>
</div>
<script>


</script>
