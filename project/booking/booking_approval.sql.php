<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}
$in_user_id = $_SESSION['in_user_id'];
$present_date = date('Y-m-d', $c_date);

//var_dump($_POST);
if(isset($_POST["inv_id"]) && isset($_POST["approval_status"]) && !empty($_POST["approval_status"])){ 
//var_dump($_POST);
$invo_id = $_POST["inv_id"];
$approval = $_POST["approval_status"];

$invoice=Booking::find_by_id($invo_id);
//$invo_id = $invoice->id;
$booking_edit = new Booking();

$booking_edit->id = $invo_id;
$booking_edit->booking_status = $approval;
$booking_edit->approve_by = $in_user_id;
$booking_edit->approve_date = $present_date;
$result=$booking_edit->save();
}


?>