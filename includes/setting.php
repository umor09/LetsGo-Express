<?php
	Class Setting {

		public $id;
		public $company_name;
		public $company_address;
		public $company_phone;
		public $compnay_mail;

		protected static $table_name="setting";
		
		protected static $db_fields=array('id' ,'company_name' ,'company_address' ,'company_phone' ,'compnay_mail'  );

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
		
		private static function instantiate($record)
		{
			$object=new self;
			foreach ($record as $attribute =>$vlaue)
			{
				if($object->has_attrubute($attribute))
				{
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
			foreach(self::$db_fields as $field)
			{
				if(property_exists($this, $field))
				{
					$attributes[$field] = $this->$field;
				}
			}
			return $attributes;
		}
			
		public function sanitized_attributes(){
			global $database;
			$cleane_attributes=array();
			foreach($this->attributes() as $key => $values)
			{
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
			
		public function delete(){
		global $database;		
		$sql="DELETE FROM ".self::$table_name;
		$sql.=" WHERE id=".$database->escape_value($this->id);
		$sql.=" LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows()==1) ? true : false; 
		}
		
		////////////////// Online Syncronization ////////////////////

		public static function get_company_info(){
			global $database;
			$database_online=new MySQLIDatabase(DB_SERVER_ONLINE, DB_USER_ONLINE, DB_PASS_ONLINE, DB_NAME_ONLINE);
			$company_fields=self::$db_fields;
			$sql=array();
			
			$sql_per_am = "select * from `setting` ";
			$result_set=$database_online->query($sql_per_am);
			
			//getting record from Online
			while($row = $database_online->fetch_array($result_set))
			{
				foreach($company_fields as $key => $value)
				{
					$sql[]= $database->escape_value($row[$value]);
				} 
				$new_data[]= "('".implode("', '", $sql)."')";
				unset($sql);
				$company_id = $row['id'];
			}
			if(!empty($new_data)):
			$sql_company_values = implode(", ", $new_data);
				if($sql_company_values != null):
					
					$sql_delete = "Delete from `setting` ";
					$result_deleted=$database->query($sql_delete);
				// Insert branch information from Online
					$query_load = 'INSERT INTO `setting` ( '.implode(", ",$company_fields).') VALUES '. $sql_company_values;
					$branch_loaded = $database->query($query_load);
								
				endif;
			endif;
			
		}
}
?>