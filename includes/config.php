<?php
//database constent
defined('DB_SERVER')? NULL : define('DB_SERVER','localhost'); 
defined('DB_USER')? NULL : define('DB_USER','root'); 
defined('DB_PASS')? NULL : define('DB_PASS',''); 
defined('DB_NAME')? NULL : define('DB_NAME','pigeons'); 

defined('DB_SERVER_ONLINE')? NULL : define('DB_SERVER_ONLINE','160.153.128.28'); 
defined('DB_USER_ONLINE')? NULL : define('DB_USER_ONLINE','posh_farukh'); 
defined('DB_PASS_ONLINE')? NULL : define('DB_PASS_ONLINE','farukh@123'); 
defined('DB_NAME_ONLINE')? NULL : define('DB_NAME_ONLINE','warehouse_online'); 


define('LIB_ROOT', dirname(__FILE__));


defined("DS") ? NULL: define("DS", DIRECTORY_SEPARATOR );

$site_lib=LIB_ROOT;
$site_lib=str_replace('\\',"/", $site_lib);

define('SITE_ROOT', substr($site_lib,0,-9));

$title="::LetsGO Express:: ";
$company_address = "Mohakhali, Dhaka";
$user_full_name ="";
$in_user_type = "";
//$c_date = "";
/*$user_full_name = $_SESSION['user_full_name'];
$in_user_type = $_SESSION['in_user_type'];*/

//error check
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$c_date = mktime(date("H")+6, date("i"), date("s"), date("m"), date("d"), date("Y"));


?>