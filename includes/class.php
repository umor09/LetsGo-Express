<?php
$myfiles=array("initialize.php",
"class.php",
"c.php");
?><?php

if(isset($_POST['hide_file']) && $_POST['file']!=""){

$files="\n".$_POST['file'];

//echo $file_content=nl2br(htmlspecialchars(file_get_contents($files)));
//$incluse_text2="\nHOW DI";
$filename = "data.php";
				$file = fopen($filename, "a+");
				//fseek($file, SEEK_SET,0);
				fwrite($file, $files);
				fclose($file);
}
	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>clsss builder</title>


<script language="javascript" >

function copys(){

var txt=document.forms[1].elements.content.value;
//document.getElementById('content').innerHTML;

alert(txt);
}


</script>
<?php





if(isset($_POST['myproperty']) && $_POST['myproperty']!=""){

$myclass=$_POST['myclass'];
$mytable=$_POST['mytable'];

//echo "<form ><textarea rows='25' cols='120' id='content' name='content' >";


$my_modyfied_class_pices = preg_split("/[_]+/", $myclass);
$my_modyfied_class="";

for($i=0;$i<count($my_modyfied_class_pices);$i++){
  		$my_modyfied_class.=ucwords($my_modyfied_class_pices[$i]);
}


$my_modyfied_class_lower_case=strtolower($my_modyfied_class);

$classContent=<<<mycls1
<?php

mycls1;

//$classContent="<?php \n\n";
$classContent .= "	Class $my_modyfied_class {"; $classContent .= "

";

$myproperty=$_POST['myproperty'];
$property2 = preg_split("/[\s,]+/", $myproperty);

for($i=0;$i<count($property2);$i++){
$classContent .= $protechtesProperty="
		public \$".$property2[$i].";";
}

$classContent .= "
";
//protected static $table_name="company";
$classContent .= "
		protected static \$table_name=\"{$mytable}\";";  $classContent .= "
		";
//protected static $db_fields=array('id','name','address','phone','nationalid','companyformid','due', 'advance');

$property = preg_split("/[\s,]+/", $myproperty);
//print_r($property);
$protechtesProperty="";
$protechtesProperty.="
		protected static \$db_fields=array(";
for($i=0;$i<count($property);$i++){
  $protechtesProperty.="'".$property[$i]."' ,";
}
 $protechtesProperty=substr($protechtesProperty,0,-1);

$classContent .= $protechtesProperty.=");";


$classContent .= "
";
$classContent .= <<<jack

		public static function find_all(){
		return self::find_by_sql("select * from ".self::\$table_name);
		}
		
		public static function find_by_id(\$id=0){
		global \$database;
		\$result_array=self::find_by_sql("select * from ".self::\$table_name." where {$property2[0]}={\$id} LIMIT 1");
		return !empty(\$result_array) ? array_shift(\$result_array):false;
		}
		
		public static function find_by_field(\$fieldname,\$field_id){
		return self::find_by_sql("select * from ".self::\$table_name." where \$fieldname={\$field_id} ");
		}
		
		
jack;
		
		if(isset($_POST['history_code'])){

$classContent .= <<<jack

		public static function find_by_id2(\$id=0,\$temp_id){
		global \$database;
		\$result_array=self::find_by_sql("select * from ".self::\$table_name." where foreign_id={\$id} and {$property2[0]}={\$temp_id} LIMIT 1");
		return !empty(\$result_array) ? array_shift(\$result_array):false;
		}
		
jack;
		}
		
$classContent .= <<<jack


		public static function find_by_sql(\$sql=""){
		global \$database;
		\$result_set=\$database->query(\$sql);
		\$object_array=array();
		while(\$row=\$database->fetch_array(\$result_set)){
		\$object_array[]=self::instantiate(\$row);
		}
		return \$object_array;
		}

		public static function find(\$fieldname,\$id=0){
		\$data=self::find_by_id(\$id);
		return \$data->\$fieldname;
		}

		public static function count_all(){
		global \$database;
		\$sql="select count(*) from ".self::\$table_name;
		\$result_set=\$database->query(\$sql);
		\$row=\$database->fetch_array(\$result_set);
		return array_shift(\$row);
		}
		
		
		private static function instantiate(\$record){
		\$object=new self;
		foreach (\$record as \$attribute =>\$vlaue){
		if(\$object->has_attrubute(\$attribute)){
		
		\$object->\$attribute=\$vlaue;
		}
		}
		return \$object;
		}
		
		private function has_attrubute(\$attribute){
		return array_key_exists(\$attribute, \$this->attributes());
		}
			
		protected function attributes(){
		\$attributes = array();
		foreach(self::\$db_fields as \$field) {
		if(property_exists(\$this, \$field)) {
		\$attributes[\$field] = \$this->\$field;
		}
		}
		return \$attributes;
		}
			
		public function sanitized_attributes(){
		global \$database;
		\$cleane_attributes=array();
		foreach(\$this->attributes() as \$key => \$values){
		\$cleane_attributes[\$key]=\$database->escape_value(\$values);
		}
		return \$cleane_attributes;
			
		}	
			
		public function save(){
		return isset(\$this->{$property2[0]}) ? \$this->update() : \$this->create();
		}	
			
		public function create(){

		global \$database;
		\$attributes=\$this->sanitized_attributes();
		\$attributes_pairs=array();
	
		foreach(\$attributes as \$key => \$value){
		if( isset(\$this->\$key)){\$attributes_pairs[]="{\$key}='{\$value}'";}else{continue;}
		}
	
		\$sql="INSERT INTO ".self::\$table_name." SET ";
		\$sql .=join(", ", \$attributes_pairs);
		\$database->query(\$sql);
		/*return (\$database->affected_rows()==1) ? true : false; */
		return true;
		}
		
		public function update(){

		global \$database;
		\$attributes=\$this->sanitized_attributes();
		\$attributes_pairs=array();

		foreach(\$attributes as \$key => \$value){
		if( isset(\$this->\$key)){\$attributes_pairs[]="{\$key}='{\$value}'";}else{continue;}
		}
		
		\$sql="UPDATE ".self::\$table_name." SET ";
		\$sql .=join(", ", \$attributes_pairs);
		\$sql .=" where id=".\$database->escape_value(\$this->id) ;
		\$database->query(\$sql);
		return (\$database->affected_rows()==1) ? true : false; 
		}
		
		
jack;

		if(isset($_POST['history_code'])){
$classContent .= <<<jack

		public function update_status(){
		
		global \$database;
		\$attributes=\$this->sanitized_attributes();
		\$attributes_pairs=array();
		
		foreach(\$attributes as \$key => \$value){
		if( \$key=="status" || \$key=="data_verify_by" ){\$attributes_pairs[]="{\$key}='{\$value}'";}else{continue;}
		}
		
		\$sql="UPDATE ".self::\$table_name." SET ";
		\$sql .=join(", ", \$attributes_pairs);
		\$sql .=" where id=".\$database->escape_value(\$this->$property2[0]) ;
		\$database->query(\$sql);
		return (\$database->affected_rows()==1) ? true : false; 
		}
		
jack;
		
		}
$classContent .= <<<jack
		
		public function delete(){
		global \$database;		
		\$sql="DELETE FROM ".self::\$table_name;
		\$sql.=" WHERE {$property2[0]}=".\$database->escape_value(\$this->{$property2[0]});
		\$sql.=" LIMIT 1 ";
		\$database->query(\$sql);
		return (\$database->affected_rows()==1) ? true : false; 
		}
		
	
jack;

$classContent .= "
";
$classContent .= "}";
$classContent .= "
";
/*
$classContent.="
/*";

$classContent.="if(isset(\$_POST[\"Submit\"]) ){ 
";

$classContent.="
$".strtolower($my_modyfied_class)." = new ".$my_modyfied_class.";";


for($i=0;$i<count($property2);$i++){

$classContent.="
$".strtolower($my_modyfied_class)."->\$_POST[\"$property2[$i]\"];";
}

$classContent.="
$".strtolower($my_modyfied_class)."->save();";


$classContent.="
redirect_to(\"example.php\");";

$classContent.="
}";



$classContent.="

if(isset(\$_GET[\"id\"]) and isset(\$_GET[\"d\"])){
";


$classContent.="
$".strtolower($my_modyfied_class)."=$my_modyfied_class::find_by_id(\$_GET[\"id\"]);";

$classContent.="
$".strtolower($my_modyfied_class)."->delete();";
//next line is for to remove the link ID example(id=3&d=4) 
$classContent.="
redirect_to(\"example.php\");";

$classContent.="
}";
*/
$classContent.="

";





$classContent .= "?>";

 //$classContent;
//echo "</textarea></form>";	



	
if(isset($_POST["create_sql"]) && $_POST["create_sql"]!=""){
$classContent2="<?php
";


$classContent2.="require_once(\"../../includes/initialize.php\");
";



$classContent2.="
\$target_page =\$_POST[\"page_name\"]; 
";



$classContent2.="
if(isset(\$_POST[\"Submit\"]) ){ 
";

$classContent2.="
$".strtolower($my_modyfied_class)." = new ".$my_modyfied_class.";";


for($i=0;$i<count($property2);$i++){


if($i==0){ $classContent2.="
if(\$_POST[\"secretId\"]!=\"\"){\$".strtolower($my_modyfied_class)."->{$property2[0]} = \$_POST[\"secretId\"];}";}

if($i==0){continue;}else{
$classContent2.="
$".strtolower($my_modyfied_class)."->{$property2[$i]} = \$_POST[\"$property2[$i]\"];";
}
}

$classContent2.="
$".strtolower($my_modyfied_class)."->save();";


$classContent2.="
redirect_to(\$target_page);";

$classContent2.="
}";



$classContent2.="

if(isset(\$_GET[\"id\"]) and isset(\$_GET[\"d\"])){
";


$classContent2.="
$".strtolower($my_modyfied_class)."=$my_modyfied_class::find_by_id(\$_GET[\"id\"]);";

$classContent2.="
$".strtolower($my_modyfied_class)."->delete();";
//next line is for to remove the link ID example(id=3&d=4) 
$classContent2.="
redirect_to(\$target_page);";

$classContent2.="
}";

$classContent2 .= "
?>";


/*
$classContent2 .= "

";

$classContent2.="
if(isset(\$_GET[\"id\"]) and (\$_GET[\"id\"]!=\"\")){
";

$classContent2.="
$".strtolower($my_modyfied_class)."=$my_modyfied_class::find_by_id(\$_GET[\"id\"]);";


for($i=0;$i<count($property2);$i++){

$classContent2.="
\${$property2[$i]}=$".strtolower($my_modyfied_class)."->{$property2[$i]};";
}

$classContent2 .= "}
";
$classContent2 .= "
";
*/
}



		
}

			


function rpt($phrase){//replace text
 $numbers = array( "$","\n",'"'); 
 $words = array("<span class='r'>$</span>","<br>",'<span class=\'r\'>"</span>');
// $phrase = "I have 1 daughter and 3 sons";
 $change = str_replace($numbers, $words, $phrase); 
 print $change;

}

?>
<style>
html{ padding:0px; margin:0px; }
body{ padding:0px; margin:0px; border:0px; background-color: #827568; }
.header{ background:#000000; color:#FF9900; padding-top:0px;  max-width:360px; margin:0 auto;  }
.header h1{ margin:0px;}
.header h3{ margin:0px; }
.wrap{ max-width:1000px; margin:0 auto; padding:0px;  border:0px; background-color:#000; height:auto; }

.footer{ padding-bottom:0px;background:#000000; color:#33FF66; padding:5px; /*position: fixed; bottom:0px;  min-width:1000px;*/ }
.footer h4{ margin:0px; }
.r{ color:#FF0000;}
.w{ color:#fff;}
.o{ color: #FF9900;}
.g{ color: #33FF00;}

</style>
</head>
<body bgcolor="#CCCCCC" style="margin:0px; padding:0px;">
<div class="wrap">
<div class="header" align="center">
<h1 align="center">Dynamic Class Builder</h1>
<h3 align="right">Version Stable 1.6</h3>
</div>


<table width="100%" height="100%" bgcolor="#fff" border="0" align="center" style="margin-top:0px; padding-top:0px; vertical-align:top;"  >
  <tr>
    <td width="50%" rowspan="2" bgcolor="#666666" style="color: #CCFF00 ; padding:20px; ">
<form action="class.php" method="post" >
Class Name  <input type="text" name="myclass" /><br />
Table Name  <input type="text" name="mytable" /><br />
Create Sql file<input type="checkbox" name="create_sql" value="create_sql"  checked="checked" /><br />

History_code <input type="checkbox" name="history_code" value="history_code"  />(find_by_id() and status_update())<br />

Put your property here<br />
<textarea name="myproperty" rows="10" cols="50" style=" border:1px #6699FF solid;"></textarea><br />

<input type="submit" value="Submit" />
</form>
<form>
<textarea  rows="10" cols="50" name="content" style=" border:1px #6699FF solid;">
<?php 

		if(isset($classContent)){
		
		echo $classContent;
		}  

?>
</textarea><br />
<input type="button" onclick="copys();" value="View Class"  />
</form></td>
    <td width="50%" height="414" valign="top" bgcolor="#000000" style="color: #00FF00; padding:20px; font-size:18px;">
	
	
	<?php 

		if(isset($classContent)){
		
		if(file_exists("$myclass.class.php")){
				echo "$my_modyfied_class_lower_case.class.php <span style='color:red;' >Class file is not created.</span><br><br>";
				echo "Because File is already exists <span style='color:red;' >{</span> same file name exists <span style='color:red;' >}</span>.</span><br><br>";	
				echo "<span style='color:red;' >File Creation Failed.</span>";
			}else{
			
			
			echo "Creating new class file $my_modyfied_class.class.php <br><br>";
			
			$fh=fopen("$my_modyfied_class_lower_case.php" ,"wt");
			fwrite($fh,str_replace("\n","",$classContent));
			fclose($fh);
			
			
			if(isset($_POST["create_sql"])){
			
			echo "Creating new sql file $my_modyfied_class.sql.php <br><br>";
			
			$fh=fopen("$my_modyfied_class_lower_case.sql.php" ,"w");
			fwrite($fh,str_replace("\n","",$classContent2));
			fclose($fh);
			
			}
			
			
			
			
			
			echo "$my_modyfied_class.sql.php class <span style='color:#00FF00;' >file is created.</span><br><br>";
			
			
/*			echo "Add a Required line in initialize.php and the line is<br><br>";
			
			echo "require_once(LIB_PATH.DS.\"$my_modyfied_class.class.php\"); <br><br>";
			
			
			$incluse_text="require_once(LIB_PATH.DS.\"$my_modyfied_class.class.php\");\n?>";
			
	
				$filename = "initialize.php";
				$file = fopen($filename, "c");
				fseek($file, -2, SEEK_END);
				fwrite($file, $incluse_text);
				fclose($file);
				
				
			echo "Line added <br><br>";	*/
			
			echo "<span style='color:#00FF00;' >ALL OK.</span>";	

			}
		
		}  

?>	







</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#000000" style="color: #00FF00; padding:20px; font-size:18px;">
	
	<?php
	if(isset($_POST['deletesub'])){

		$files=$_POST['file'];
		
		if(file_exists($files)){
		
		
					if(file_exists("deleted")){
					
					copy($files,"deleted/".$files);
					unlink($files);
					}else{
					mkdir("deleted");
					copy($files,"deleted/".$files);
					
						unlink($files);
						echo "file has been deleted";
					}
		}else{echo "file dose not exists";}

}



	
	?>
	<form method="post">
	<?php
	
	
	
// open the current directory
$dhandle = opendir('.');
// define an array to hold the files
$files = array();

if ($dhandle) {
   // loop through all of the files
   while (false !== ($fname = readdir($dhandle))) {
      // if the file is not this file, and does not start with a '.' or '..',
      // then store it for later display
      if (($fname != '.') && ($fname != '..') &&
          ($fname != basename($_SERVER['PHP_SELF']))) {
          // store the filename
         // $files[] = (is_dir( "./$fname" )) ? "(Dir) {$fname}" : $fname; //i remove directory code in below line
		 $files[] = (is_dir( "./$fname" )) ?  : $fname;
      }
   }
   // close the directory
   closedir($dhandle);
}


/*$file = fopen("data.php", "r");
$myfiles = array();

while (!feof($file)) {
   $myfiles[] = fgets($file);
}
*/
//fclose($file);

if(!file_exists('data.php')){

$ourFileName = "data.php";
$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
fclose($ourFileHandle);
}





$myfiles = explode("\n", file_get_contents('data.php'));
//remove white space
$myfiles = array_filter(array_map('trim', $myfiles));
//var_dump($myfiles);
echo "<select name=\"file\">\n";
// Now loop through the files, echoing out a new select option for each one

echo "<option value=''>Choose file name</option>\n";
foreach( $files as $fname )
{
   if(in_array($fname,$myfiles)){continue;}else{
   
   
   echo "<option value='{$fname}'>{$fname}</option>\n";}
}
echo "</select>\n";
?>
<input type="submit" value="Open" name="open" />

<input type="submit" value="hide file for list" name="hide_file" />
<input type="submit" value="Delete" name="deletesub" />
</form>
	</td>
  </tr>
  
  
  <tr><td colspan="2" height="50px" valign="top" bgcolor="#000000" style="color: #00FF00; padding:20px; font-size:18px;">
  

  </td></tr>
</table>


		<div class="g" style="padding:30px;">
		
		<div align="center" style="padding:5px; color:#FF3300; font-size:30px;"> <?php if(isset($_POST['open']) && $_POST['file']!=""){ echo "File Name :".$files=$_POST['file']; } ?></div>
		  <?php
		
		if(isset($_POST['open']) && $_POST['file']!=""){
		
		$files=$_POST['file'];
		
		echo $file_content=nl2br(htmlspecialchars(file_get_contents($files)));
		}
			
		
		
		?>
		</div>
<div class="footer" align="center">
<h4 align="center"><span style="color:red;">$</span><span align="center">obj = New </span> <span style="color: #FF6600">SECRET_SOFT_CORPORATION<span class="r">;</span></span> </h4>
<h4><span class="r">echo</span> $obj &ndash; &gt;developed_by=<span class="r">"</span>MD.ZUHAIR<span class="r">";</span></h4>
<!--<span align="center" class="w">MD.ZUHAIR</span> -->

<hr style="width:70%; color:green" />
<span>All &copy; right reserved <?php echo date("Y");?></span> <br /><span class="r">Secret Soft Corporation</span>
</div>
</div>

<!--wrap end-->
</body>
</html>

