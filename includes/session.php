<?php
class Session{

	public $logged_in=false;
	public $user_id;
	public $message;
	public $sucess_message;
	public $fail_message;
	public $designation;
	
	function __construct()
	{
		@session_start();
		$this->check_login();
		if($this->logged_in)
		{
		// actions to take right away if user is logged in
		} 
		else
		{
		// actions to take right away if user is not logged in
		}
	}
	
	public function is_logged_in(){
	return $this->logged_in;
	}
	
	
	public function login($user)
	{
		if($user)
		{
			$this->user_id=$_SESSION['in_user_id']=$user->id;
			$this->designation=$_SESSION['designation']=$user->designation;
			$this->logged_in=true;
		}
	}
			
	private function check_login(){
	if(isset($_SESSION['in_user_id']))
		{
			$this->user_id=$_SESSION['in_user_id'];
			$this->logged_in=true;
		}
		else
		{
			unset($this->user_id);
			$this->logged_in=false;
		}
	}
	
	public function message($msg="")
	{
		if(!empty($msg))
		{
			// then this is "set message"
			// make sure you understand why $this->message=$msg wouldn't work
			$_SESSION['message'] = $msg;
		}
		else
		{
			// then this is "get message"
			return $this->message;
		}
	}
	
	public function logged_out()
	{
		unset($_SESSION['in_user_id']);
		unset($this->user_id);
	}
}

$session=new Session;
$message = $session->message();
?>