<?php
defined("DS") ? NULL: define("DS", DIRECTORY_SEPARATOR );
defined("LIB_PATH") ? NULL : define("LIB_PATH", __DIR__);
//echo LIB_PATH."<BR>";


/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/



require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."functions.php");
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");

function __autolode($class_name){
require_once(LIB_PATH.DS.strtolower($class_name)."class.php");
}
?>