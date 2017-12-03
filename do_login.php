<?php
require_once("/includes/initialize.php");

//echo var_dump($_POST);

$username = "";
$password = "";
	
if(isset($_POST["login"])):
  if(isset($_POST['username'])):
  	$username = $_POST['username'];
  endif;
  if(isset($_POST['password'])):
  	$password = $_POST['password'];
	$password = md5($password);
  endif;
endif;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $title; ?>Login</title>
<link rel="stylesheet" type="text/css" href="index.css" media="all">
</head>
<body>
<?php
		
   // make the query
	$sql = "";
	$rr ="";
	if(!empty($username) && !empty($password) !=""):
	$sql = "SELECT * FROM `user` WHERE (user_name ='$username' || email = '$username') and BINARY password ='$password' ";
	$rr=User::find_by_sql($sql);
			if($rr):	
				foreach($rr as $users)
				{
					// login successful
					$user_id = $users->id;
					$_SESSION['in_user_id'] = $user_id;
					$_SESSION['in_username'] = $users->user_name;
					$in_password = $users->password;
					$_SESSION['in_service_point_id'] = $users->service_point_id;
					
					//$user_type = UserType::find('type', $users->user_type);
					
					//$_SESSION['in_user_type'] = $user_type;
					
					$_SESSION['user_full_name'] = $user_full_name;
					$_SESSION['sid'] = session_id();
					$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
					$_SESSION['color'] = "main_menu";
					$_SESSION['present_date'] = date("Y-m-d", $c_date);
				
					$session_id = session_id();
					$ip_address = $_SERVER['REMOTE_ADDR'];
					$_SESSION['session_id'] = session_id();
					$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
					$c_datetime = date('Y-m-d H:i:s',$c_date);

					$loginHistory = new LoginHistory;
					$loginHistory->user_id = $user_id;
					$loginHistory->session = $session_id;
					$loginHistory->ip_address = $ip_address;
					$loginHistory->logon_datetime = $c_datetime;
					$result_login=$loginHistory->save();
				}
																 
				echo '<meta http-equiv="Refresh" content="0; url=project/index.php" >';
				
		 else:					 	
				$_SESSION['user_exist'] = "Bad user or missing password!";
				echo '<meta http-equiv="Refresh" content="0; url=main.php" >';
		 endif;
		 
		 else:
			$_SESSION['user_exist'] = "Please login with a valide account!";
			echo '<meta http-equiv="Refresh" content="0; url=main.php" >';
		 endif;
        ?>
</body>
</html>
