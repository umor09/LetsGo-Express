<?php
require_once("includes/initialize.php");

if(isset($_POST['user']) && !empty($_POST['user'])):
$user=$_POST['user'];
$sql ="SELECT user_name FROM user where user_name LIKE '$user' ";
$user_info=User::find_by_sql($sql);
$count=count($user_info);
if($count>0){echo "yes"; } else { echo "no";}
endif;

if(isset($_POST['email']) && !empty($_POST['email'])):
$email=$_POST['email'];
$sql ="SELECT email FROM user where email LIKE '$email' ";
$user_info=User::find_by_sql($sql);
$count=count($user_info);
if($count>0){echo "yes"; } else { echo "no";}
endif;

?>