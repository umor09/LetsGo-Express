<?php
	Class BookingDetails extends Booking {

		public $id;
		public $booking_id;
		public $product_category_id;
		public $product_name;
		public $product_description;
		public $packet_size;
		public $packet_weight;
		public $purchase_invoice;
		public $packet_qty;
		public $pick_up_time;
		public $receive_amount;
		public $receiver_name;
		public $receiver_phone;
		public $receiver_email;
		public $receiver_address;
		public $delivery_status;
		public $delivery_time;

		protected static $table_name="booking_details";
		
		protected static $db_fields=array('id' ,'booking_id' ,'product_category_id' ,'product_name' ,'product_description' ,'packet_size' ,'packet_weight' ,'purchase_invoice' ,'packet_qty', 'pick_up_time', 'receive_amount', 'receiver_name' ,'receiver_phone' ,'receiver_email' ,'receiver_address' ,'delivery_status' ,'delivery_time' );

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
		
		public static function find_by_sql($sql=""){
		global $database;
		$result_set=$database->query($sql);
		$object_array=array();
		while($row=$database->fetch_array($result_set)){
		$object_array[]=self::instantiate($row);
		}
		return $object_array;
		}

		public static function find($fieldname,$id=0){
		$data=self::find_by_id($id);
		return $data->$fieldname;
		}

		public static function count_all(){
		global $database;
		$sql="select count(*) from ".self::$table_name;
		$result_set=$database->query($sql);
		$row=$database->fetch_array($result_set);
		return array_shift($row);
		}
		
		public static function sum_invoid($invoid){
		global $database;
		$sql="select SUM(packet_qty) AS value_sum from ".self::$table_name." where booking_id={$invoid}"; 
		$result_set=$database->query($sql);
		$row=$database->fetch_array($result_set);
		$total_product = $row['value_sum'];
		return ($total_product) ? $total_product : 0;
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
		if( isset($this->$key)){$attributes_pairs[]="{$key}='{$value}'";}else{continue;}
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
		if( isset($this->$key)){$attributes_pairs[]="{$key}='{$value}'";}else{continue;}
		}
		
		$sql="UPDATE ".self::$table_name." SET ";
		$sql .=join(", ", $attributes_pairs);
		$sql .=" where id=".$database->escape_value($this->id) ;
		$database->query($sql);
		return ($database->affected_rows()==1) ? true : false; 
		}
			
		public static function transfre_data($invo_id, $user_id)
		{
			global $database;
			$sql=" SELECT * from temp_booking_details where entry_by='$user_id'";
			$result_set=$database->query($sql);
			$record_found=$result_set->num_rows;
			if($record_found > 0)
			{
				while($result=$database->fetch_object($result_set))
				{
					$invo_id = $invo_id;
					$temp_invo_id = $result->id;
					$service_point_id = $result->service_point_id;
					$customer_id = $result->customer_id;
					$product_category_id = $result->product_category_id;
					$product_name = $result->product_name;
					$product_description = $result->product_description;
					$packet_size = $result->packet_size;
					$packet_weight = $result->packet_weight;
					$purchase_invoice = $result->purchase_invoice;
					$packet_qty = $result->packet_qty;
					$receiver_name = $result->receiver_name;
					$receiver_phone = $result->receiver_phone;
					$receiver_email = $result->receiver_email;
					$receiver_address = $result->receiver_address;
						
					$sql_transfer="Insert into booking_details set booking_id='".$invo_id."', product_category_id='".$product_category_id."', product_name='".$product_name."', product_description='".$product_description."', packet_size='".$packet_size."', packet_weight='".$packet_weight."', purchase_invoice='".$purchase_invoice."', packet_qty='".$packet_qty."', receiver_name='".$receiver_name."', receiver_phone='".$receiver_phone."', receiver_email='".$receiver_email."', receiver_address='".$receiver_address."' ";
					$transfer = $database->query($sql_transfer);
				}
				$tempData = new TempBookingDetails;
				$tempData->entry_by=$_SESSION['in_user_id'];
				$tempData->delete2();
			}
			return ($result_set) ? true : false; 
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