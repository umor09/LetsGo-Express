<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}
$in_user_id = $_SESSION['in_user_id'];
$present_date = date('Y-m-d', $c_date);

//var_dump($_POST);
if(isset($_POST["id"]) && isset($_POST["status"]) && !empty($_POST["status"])){ 
//var_dump($_POST);
$vehicle_id = $_POST["id"];
$status = $_POST["status"];

$vehicleObj=Vehicle::find_by_id($vehicle_id);
//$invo_id = $invoice->id;
$vehicle_edit = new Vehicle();

$vehicle_edit->id = $vehicle_id;
$vehicle_edit->status = $status;
$vehicle_edit->approve_by = $in_user_id;
$vehicle_edit->approve_date = $present_date;
$result=$vehicle_edit->save();
}

?>
