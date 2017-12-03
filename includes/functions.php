<?php
  //require_once(LIB_PATH.DS.'database.php');
  function strip_zeros_from_date($maked_string){
  
  //first remove the markes zeros
  $no_zeros = str_replace('*0','',$maked_string ); 
  //then romove any reaining marks
  $cleaned_string= str_replace('0','',$no_zeros );
  return $cleaned_string;
  }
  
  function redirect_to($location=NULL){
  if ($location != NULL){
	  header("Location: {$location}");
	  exit;
	  }
  }
  
  function output_message($message=""){
  
  if(!empty($message)){
  
  return "<p class=\'message\'>{$message}</p>";
	  }else {
	  return "";
	  }
  }
  
  function __autoload($class_name){
  
		  $class_name=strtolower($class_name);
		  $path=LIB_PATH.DS."{$class_name}.php";
		  if(file_exists($path)){
		  require_once($path);
		  } else {
		  die("The class name {$class_name}.php can not be found.");
		  }
		  return $class_name;
  }
  

  function langB($data){
  setlocale(LC_NUMERIC, 'bn-bd');
  return $data;
  
  }
  
  function formatDate($data){
  
  $datedata=preg_split("/\-{1,}/",$data);
  
  $e1=$datedata[0];
  $e2=$datedata[1];
  $e3=$datedata[2];
  $newdate=$e3."-".$e2."-".$e1;
  return $newdate;
  }
  
  function formatDateReverce($data){
  
  $datedata=preg_split("/\-{1,}/",$data);
  
  $e1=$datedata[0];
  $e2=$datedata[1];
  $e3=$datedata[2];
  $newdate=$e3."-".$e2."-".$e1;
  return $newdate;
  }
  
  function alter_date($date){
  $check=preg_match('/^\d{2}-\d{2}-\d{4}$/',$date);
  if($check == 1){return formatDate($date); }else {return $date; }
  }
  
  function alter_date2($date){
  $check=preg_match('/^\d{4}-\d{2}-\d{2}$/',$date);
  if($check == 1){return formatDate($date); }else {return $date; }
  }
    
  function FixEncoding($x)
  {
	  if(mb_detect_encoding($x)=='UTF-8')
	  {
		  return $x;
	  }
	  else
	  {
		  return utf8_encode($x);
	  }
  } 		
  
  function year_data()
  {
	  $startyear=date('Y');
	  $endyear='2010';
	  for($c=$startyear;$c>=$endyear;$c--)
	  {
		  $str.="<option value=".$c.">".$c.'</option>';
	  }
	  return $str;
  }
  
  //fileter \r \n to blank string
  function filter($data){ 
  return $datas=preg_replace("/\r\n|\r|\n/",'',$data);
  }

?>
