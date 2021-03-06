<?php
	Class DebitHead {


		public $id;
		public $debit_account;
		public $description;

		protected static $table_name="debit_head";
		
		protected static $db_fields=array('id' ,'debit_account' ,'description' );

		public static function find_all(){
		return self::find_by_sql("select * from ".self::$table_name);
		}
		
		public static function find_by_id($id=0){
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name." where id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array):false;
		}
		
		public static function find_by_field($fieldname,$field_id){
		return self::find_by_sql("select * from ".self::$table_name." where $fieldname={$field_id} ");
		}
		
		
		public static function find_by_id2($id=0,$temp_id){
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name." where foreign_id={$id} and id={$temp_id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array):false;
		}
		
		public static function find($fieldname,$id=0){
		$data=self::find_by_id($id);
		return $data->$fieldname;
		}

		public static function find_by_sql($sql=""){
		global $database;
		$result_set=$database->query($sql);
		$object_array=array();
		while($row=$database->fetch_array($result_set)){
		$object_array[]=self::instantiate($row);
		}
		return $object_array;
		}
		
		
		public static function count_all(){
		global $database;
		$sql="select count(*) from ".self::$table_name;
		$result_set=$database->query($sql);
		$row=$database->fetch_array($result_set);
		return array_shift($row);
		}
		
		
		private static function instantiate($record){
		$object=new self;
		foreach ($record as $attribute =>$vlaue){
		if($object->has_attrubute($attribute)){
		
		$object->$attribute=$vlaue;
		}
		}
		return $object;
		}
		
		private function has_attrubute($attribute){
		return array_key_exists($attribute, $this->attributes());
		}
			
		protected function attributes(){
			$attributes = array();
		  foreach(self::$db_fields as $field) {
			if(property_exists($this, $field)) {
			  $attributes[$field] = $this->$field;
			}
		  }
		  return $attributes;
		}
			
		public function sanitized_attributes(){
		global $database;
		$cleane_attributes=array();
		foreach($this->attributes() as $key => $values){
			$cleane_attributes[$key]=$database->escape_value($values);
			}
			return $cleane_attributes;
			
		}	
			
		public function save(){
		return isset($this->id) ? $this->update() : $this->create();
		}	
			
		public function create(){
		global $database;
		$attributes=$this->sanitized_attributes();
		$attributes_pairs=array();
		
		foreach($attributes as $key => $value){
		if(isset($this->$key)){$attributes_pairs[]="{$key}='{$value}'";}else{continue;}
		}
		
		$sql="INSERT INTO ".self::$table_name." SET ";
		$sql .=join(", ", $attributes_pairs);
		$database->query($sql);
		/*return ($database->affected_rows()==1) ? true : false; */
		return true;
		}
		
		public function update(){
		global $database;
		$attributes=$this->sanitized_attributes();
		$attributes_pairs=array();
		
		foreach($attributes as $key => $value){
		if(isset($this->$key)){$attributes_pairs[]="{$key}='{$value}'";}else{continue;}
		}
		
		$sql="UPDATE ".self::$table_name." SET ";
		$sql .=join(", ", $attributes_pairs);
		$sql .=" where id=".$database->escape_value($this->id) ;
		$database->query($sql);
		return ($database->affected_rows()==1) ? true : false; 
		}
			
		public function update_status(){
		global $database;
		$attributes=$this->sanitized_attributes();
		$attributes_pairs=array();
		
		foreach($attributes as $key => $value){
		if( $key=="status" || $key=="data_verify_by" ){$attributes_pairs[]="{$key}='{$value}'";}else{continue;}
		}
		
		$sql="UPDATE ".self::$table_name." SET ";
		$sql .=join(", ", $attributes_pairs);
		$sql .=" where id=".$database->escape_value($this->id) ;
		$database->query($sql);
		return ($database->affected_rows()==1) ? true : false; 
		}
				
		public function delete(){
		global $database;		
		$sql="DELETE FROM ".self::$table_name;
		$sql.=" WHERE id=".$database->escape_value($this->id);
		$sql.=" LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows()==1) ? true : false; 
		}
		
	
}


?>