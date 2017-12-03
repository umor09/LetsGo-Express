<?php
	Class DailyTransaction {

		public $id;
		public $branch_id;
		public $transaction_account;
		public $pay_to;
		public $transaction_purpose;
		public $transaction_amount;
		public $inform_with;
		public $transaction_date;
		public $voucher_no;
		public $account_type;
		public $bank_name;
		public $entry_by;
		public $entry_date;
		public $transaction_status;
		public $approved_by;
		public $approved_date;

		protected static $table_name="daily_transaction";
		
		protected static $db_fields=array('id', 'branch_id', 'transaction_account' , 'pay_to', 'transaction_purpose', 'transaction_amount', 'inform_with' ,'transaction_date' ,'voucher_no' ,'account_type' ,'bank_name' ,'entry_by','approved_by' ,'approved_date' );

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
		
		public static function count_credit(){
		global $database;
		$sql="select count(*) from ".self::$table_name." where account_type='Credit' ";
		$result_set=$database->query($sql);
		$row=$database->fetch_array($result_set);
		return array_shift($row);
		}
		
		public static function count_debit(){
		global $database;
		$sql="select count(*) from ".self::$table_name." where account_type='Debit' " ;
		$result_set=$database->query($sql);
		$row=$database->fetch_array($result_set);
		return array_shift($row);
		}
		
		public static function total_receive($quary_date){
		
		$TotalRecevied = round($TotalRecevied, 2);
		return $TotalRecevied;
		}
		
		public static function count_by_sql($sql){
		global $database;
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
		
		
		////////////////// Accounts Online Syncronization ////////////////////

		public static function account_sync(){
			global $database;
			$database_online=new MySQLIDatabase(DB_SERVER_ONLINE, DB_USER_ONLINE, DB_PASS_ONLINE, DB_NAME_ONLINE);
			$transaction_fields=self::$db_fields;
			$transaction_ids=array();
			$sql=array();
			$sql_per_am = "select * from `daily_transaction` WHERE data_sync = 'F' ";
			$result_set=$database->query($sql_per_am);
			$record_found = $result_set->num_rows;
			//getting record ids
			if($record_found !=0):
			while($row = $database->fetch_array($result_set))
			{
				foreach($transaction_fields as $key => $value)
				{
					$sql[]= $database->escape_value($row[$value]);
				} 
				$new_data[]= "('".implode("', '", $sql)."')";
				unset($sql);
				array_push($transaction_ids , $row['id']);
			}
			
			$transaction_ids =  implode(', ', $transaction_ids);
			$sql_transaction_values = implode(", ", $new_data);
					$sql_delete = "Delete from `daily_transaction` where `id` in($transaction_ids) ";
					$result_deleted=$database_online->query($sql_delete);

				if(count($transaction_ids)>0 && $result_deleted):
				$query_upload = 'INSERT INTO `daily_transaction` ( '.implode(", ",$transaction_fields).') VALUES '. $sql_transaction_values;
				$transaction_uploaded = $database_online->query($query_upload);
				$sql_update = "Update `daily_transaction` set `data_sync`='T' where `id` in($transaction_ids) ";
				$result_updated=$database->query($sql_update);
				if($result_updated):		
					$msg = "Data sent successfully !";
				endif;	
				endif;		
			else:
			$msg = "Sorry! data not sent, please contact your system admin.";
			endif;
			//$msg = "OK!";
			return $msg;
		}
		
}


?>