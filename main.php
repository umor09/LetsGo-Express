<?php
require_once("includes/initialize.php");
if(isset($_SESSION['in_user_id'])):
$in_user_id = $_SESSION['in_user_id'];
endif;
$error_msg ="";
$target_page =basename($_SERVER['PHP_SELF']);
  
if(isset($_POST["signup"])):
	$user = new User;
	if($_POST["secretId"]!=""){$user->id = $_POST["secretId"];}
	$user->user_name = $_POST["user_name"];
	$user->phone = $_POST["phone"];
	$user->email = $_POST["email"];
	$password =  md5($_POST["password"]);
	$user->password = $password;
	$user->user_type = 0;
	$result=$user->save();
	if($result):
	$_SESSION["success_msg"] = "User created successfully! Please check your email to confirm account.";
	redirect_to($target_page);
	endif;
endif;

if(isset($_POST["forgot"])):
endif;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<!--IE Compatibility modes-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--Mobile first-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>ARS Login Page</title>
<link rel="icon" href="project/images/logo_ico.png" type="image/x-icon">
<meta name="description" content="Free Admin Template Based On Twitter Bootstrap 3.x">
<meta name="author" content="">
<meta name="msapplication-TileColor" content="#5bc0de" />
<meta name="msapplication-TileImage" content="project/assets/img/metis-tile.png" />

<!-- Bootstrap -->
<link rel="stylesheet" href="project/assets/lib/bootstrap/css/bootstrap.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="project/assets/lib/font-awesome/css/font-awesome.css">

<!-- Metis core stylesheet -->
<link rel="stylesheet" href="project/assets/css/main.css">

<!-- metisMenu stylesheet -->
<link rel="stylesheet" href="project/assets/lib/metismenu/metisMenu.css">

<!-- onoffcanvas stylesheet -->
<link rel="stylesheet" href="project/assets/lib/onoffcanvas/onoffcanvas.css">

<!-- animate.css stylesheet -->
<link rel="stylesheet" href="project/assets/lib/animate.css/animate.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript" src="project/gen_validatorv4.js"></script>

<script language="javascript" >
function checkUser(value){
//alert(value);
$.post("getState.php",{user:value},function(data){
//$("#results").html(data);
//document.getElementById("results").value=data;
if(data=='yes'){$("#results1").html("<span style='color:red;'>User Not Available</span>");}
if(data=='no'){$("#results1").html("<span style='color:green;'>User Available</span>");}
});
}

function checkEmail(value){
//alert(value);s
if(valid_email(value)==true){
$.post("getState.php",{email:value},function(data){
//$("#results").html(data);
//document.getElementById("results").value=data;
if(data=='yes'){$("#results2").html("<span style='color:red;'>email are exist!</span>");}
if(data=='no'){$("#results2").html("<span style='color:green;'>email ok!</span>");}
});
}
else
{$("#results2").html("<span style='color:red;'>Please enter a valid email address!</span>");}
}

function valid_email(val){
    if(!val.match(/\S+@\S+\.\S+/)){ // Jaymon's / Squirtle's solution
        // Do something
        return false;
    }
    if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
        // Do something
        return false;
    }
    return true;
}			
</script>
</head>

<body class="login">
<div class="form-signin">
  <div class="text-center"> <img src="project/assets/img/logo.png" alt="Metis Logo"> </div>
  <hr>
  <div class="tab-content">
    <div id="login" class="tab-pane active">
      <form action="do_login.php" method="post">
        <p class="text-muted text-center"> Enter your username/email and password </p>
        <?php 
		if(isset($_SESSION['user_exist']) && !empty($_SESSION['user_exist'])):
		$error_msg = $_SESSION['user_exist'];
		  if(!empty($error_msg)):
		  echo '<p class="text-center alert-danger alert">'.$error_msg.' </p>';
		  endif;
		endif;
		?>
        <input type="text" name="username" placeholder="Username/email" class="form-control top">
        <input type="password" name="password" placeholder="Password" class="form-control bottom">
        <div class="checkbox">
          <label>
            <input type="checkbox" name="">
            Remember Me </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
      </form>
    </div>
    <div id="forgot" class="tab-pane">
      <form action="index.php">
        <p class="text-muted text-center">Enter your valid e-mail</p>
        <input type="email" placeholder="mail@domain.com" class="form-control">
        <br>
        <button class="btn btn-lg btn-danger btn-block" type="submit" name="forgot">Recover Password</button>
      </form>
    </div>
    <div id="signup" class="tab-pane">
    <div class="input-group">
      <form name="signup_frm" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="text" name="user_name" placeholder="username" class="form-control top" onkeyup="checkUser(this.value);">&nbsp;<span style="float:left;" id="results1"></span>
        <input type="email" name="email" placeholder="mail@domain.com" class="form-control middle" onMouseOut="checkEmail(this.value)">&nbsp;<span style="float:left;" id="results2"></span>
        <input type="text" name="phone" placeholder="Phone" class="form-control " data-mask="+88 999 999 999 999">
        <input type="password" name="password" placeholder="password" class="form-control middle">
        <input type="password" name="re-password" placeholder="re-password" class="form-control bottom">
        <button class="btn btn-lg btn-success btn-block" type="submit" name="signup">Register</button>
      </form>
      </div>
      <script language="JavaScript" type="text/javascript">
            //<![CDATA[
  			//You should create the validator only after the definition of the HTML form
  			var frmvalidator  = new Validator("signup_frm");
  			frmvalidator.addValidation("user_name","req","Please enter user Name");
  			frmvalidator.addValidation("user_name","maxlen=20","User Name is not more than 20 character");
			frmvalidator.addValidation("user_name","alnum","User name only alpha-numeric characters allowed");
			frmvalidator.addValidation("email","req","Please enter a valid E-mail");
  			frmvalidator.addValidation("password","req","Please user Password");
  			frmvalidator.addValidation("password","neelmnt=user_name","The password should not be same as user_name");
			frmvalidator.addValidation("password","minlen=6","Password minimum 6 charector");
  			frmvalidator.addValidation("re-password","eqelmnt=password","The confirmed password is not same as password");
  			//var security_code=.$_SESSION['security_code'];
  			//frmvalidator.addValidation("txtCaptcha","eqelmnt=security_code","Security code is not Correct");
  			
			//]]></script>
    </div>
  </div>
  <hr>
  <div class="text-center">
    <ul class="list-inline">
      <li><a class="text-muted" href="#login" data-toggle="tab">Login</a></li>
      <li><a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a></li>
      <li><a class="text-muted" href="#signup" data-toggle="tab">Signup</a></li>
    </ul>
  </div>
</div>

<!--jQuery --> 
<script src="project/assets/lib/jquery/jquery.js"></script> 

<!--Bootstrap --> 
<script src="project/assets/lib/bootstrap/js/bootstrap.js"></script> 
<script type="text/javascript">
        (function($) {
            $(document).ready(function() {
                $('.list-inline li > a').click(function() {
                    var activeForm = $(this).attr('href') + ' > form';
                    //console.log(activeForm);
                    $(activeForm).addClass('animated fadeIn');
                    //set timer to 1 seconds, after that, unload the animate animation
                    setTimeout(function() {
                        $(activeForm).removeClass('animated fadeIn');
                    }, 1000);
                });
            });
        })(jQuery);
    </script>
</body>
</html>
<?php 
if($_SESSION["success_msg"] != ""):
  echo "<script language=javascript>alert('".$_SESSION["success_msg"]."')</script>";
endif;

unset($_SESSION["user_exist"]);
unset($_SESSION["success_msg"]);
?>