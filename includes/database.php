<?php 
require_once(LIB_PATH.DS.'config.php');
class MySQLIDatabase{

private $connection;
public $last_query;
private $magic_quotes_active;
private $real_escape_string_existes;

private	$DB_SERVER ;
private	$DB_USER ;
private	$DB_PASS ;
private	$DB_NAME ;

function __construct($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME){

$this->DB_SERVER=$DB_SERVER;
$this->DB_USER=$DB_USER;
$this->DB_PASS=$DB_PASS;
$this->DB_NAME=$DB_NAME;


$this->open_connection();
$this->magic_quotes_active=get_magic_quotes_gpc();
$this->real_escape_string_existes=function_exists("mysql_real_escape_string");
}

public function open_connection(){
$this->connection=mysqli_connect($this->DB_SERVER ,$this->DB_USER,$this->DB_PASS,$this->DB_NAME);

if(!$this->connection){
die("Database Connection Failed ". mysqli_connect_errno()."<br>");
} 

/*		else {
$db_select=mysqli_select_db(DB_NAME , $this->connection);
if(!$db_select){
die("Database Selection Failed". mysql_error().DB_NAME);
}
}*/
}

public function close_connection(){

if(isset($this->connection)){
mysqli_close($this->connection);
unset($this->connection);
}
}

public function query($sql){
$this->last_query=$sql;
$result=mysqli_query($this->connection,$sql);
$this->confirm_query($result);
return $result;

}

public function escape_value($value){

if($this->real_escape_string_existes)
{
if($this->magic_quotes_active){$value=stripslashes($value);
}	

$value=mysqli_real_escape_string($this->connection,$value);

}
else
{
if(!$this->magic_quotes_active){$value=addslashes($value);}
}
return $value;
}

//database neutral mathods
public function fetch_object($result_set){
return mysqli_fetch_object($result_set);
}


public function fetch_array($result_set){
return mysqli_fetch_array($result_set);
}

public function num_rows($result_set){
return mysqli_num_rows($result_set);
}

public function insert_id(){
return mysqli_insert_id($this->connection);
}

public function affected_rows(){
return mysqli_affected_rows($this->connection);
}

private function confirm_query($result){

if(!$result){
$output="Database query has been Failed". mysql_error()."<br><br>";
//$output="<div align=center>কোন তথ্য পাওয়া যায় নি ?</div>";
$output .="Last SQL query: ".$this->last_query;
die($output);
}
}
}

$database=new MySQLIDatabase(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

//$database_online=new MySQLIDatabase(DB_SERVER_ONLINE, DB_USER_ONLINE, DB_PASS_ONLINE, DB_NAME_ONLINE);
?>