<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}

$in_user_id= $_SESSION['in_user_id'];

$present_date = date('Y-m-d',$c_date);
$target_page =basename($_SERVER['PHP_SELF']);

////////////////// Save User ///////////////////
if(isset($_POST["save"]))
{ 
//var_dump($_POST);
  $userObj = new User;
  if($_POST["secretId"]!=""){$userObj->id = $_POST["secretId"];}
  
  $userObj->user_name = $_POST["user_name"];
  $userObj->email = $_POST["email"];
  $userObj->full_name = $_POST["full_name"];
  $userObj->phone = $_POST["phone"];
  $userObj->mailing_address = $_POST["mailing_address"];
  $userObj->user_type = $_POST["user_type"];
  $userObj->status = $_POST["status"];
  $userObj->entry_by =  $in_user_id;
  $userObj->save();   
  redirect_to($target_page);
}

////////////////// Edit User ///////////////////

if(isset($_GET['id']) && $_GET['id']!="" && isset($_GET["u"]) && $_GET["u"]==1){
	$user_edit_id = $_GET['id'];
	$userObj_edit=User::find_by_id($user_edit_id);
	if(!empty($userObj_edit)):
	$user_id = $userObj_edit->id;
	$user_name = $userObj_edit->user_name;
	$password = $userObj_edit->password;
	$email = $userObj_edit->email;
	$phone = $userObj_edit->phone;
	$user_type = $userObj_edit->user_type;
	$status  = $userObj_edit->status;
	$full_name = $userObj_edit->full_name;
	$mailing_address = $userObj_edit->mailing_address;
	endif;
}

////////////////// Delete User ///////////////////
if(isset($_GET["id"]) and isset($_GET["d"]))
{
  $userObj_del=User::find_by_id($_GET["id"]); 
  $userObj_del->status = 'Inactive';
  $userObj_del->update();
  redirect_to($target_page);											
}	

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<!--IE Compatibility modes-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--Mobile first-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php echo $title;?>Creat User</title>
<meta name="description" content="Free Admin Template Based On Twitter Bootstrap 3.x">
<meta name="author" content="">
<meta name="msapplication-TileColor" content="#5bc0de" />
<meta name="msapplication-TileImage" content="/ars_courier/project/assets/img/metis-tile.png" />

<!-- Bootstrap -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/bootstrap/css/bootstrap.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/font-awesome/css/font-awesome.css">

<!-- Metis core stylesheet -->
<link rel="stylesheet" href="/ars_courier/project/assets/css/main.css">

<!-- metisMenu stylesheet -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/metismenu/metisMenu.css">

<!-- onoffcanvas stylesheet -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/onoffcanvas/onoffcanvas.css">

<!-- animate.css stylesheet -->
<link rel="stylesheet" href="/ars_courier/project/assets/lib/animate.css/animate.css">
<link rel="stylesheet" href="/ars_courier/project/assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="/ars_courier/project/assets/lib/inputlimiter/jquery.inputlimiter.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/uniform/uniform.default.min.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/chosen/chosen.min.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/jquery-tagsinput/jquery.tagsinput.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/jasny-bootstrap/jasny-bootstrap.min.css">
<link rel="stylesheet" href="/ars_courier/project/assets/ajax/libs/bootstrap-switch/bootstrap-switch.min.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->


<link rel="stylesheet" href="/ars_courier/project/assets/css/style-switcher.css">
<link rel="stylesheet/less" type="text/css" href="/ars_courier/project/assets/less/theme.less">
<script src="/ars_courier/project/assets/less/less.js"></script>
<script type="text/javascript" src="/ars_courier/project/gen_validatorv4.js"></script>
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
if(data=='yes'){$("#results2").html("<span style='color:red;'>email are exist! try with new one.</span>");}
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

<body class="  ">
<div class="bg-dark dk" id="wrap">
  <div id="top"> 
    <!-- .navbar -->
    <?php require("../top_navigation.php"); ?>
    <!-- /.navbar -->
    <header class="head">
      <div class="search-bar">
        <form class="main-search" action="">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Live Search ...">
            <span class="input-group-btn">
            <button class="btn btn-primary btn-sm text-muted" type="button"> <i class="fa fa-search"></i> </button>
            </span> </div>
        </form>
        <!-- /.main-search --> </div>
      <!-- /.search-bar -->
      <div class="main-bar">
        <h3> <i class="fa fa-pencil"></i>&nbsp;
          Form Page </h3>
      </div>
      <!-- /.main-bar --> 
    </header>
    <!-- /.head --> 
  </div>
  <!-- /#top -->
  <?php require("../left_menu.php"); ?>
  <!-- /#left -->
  <div id="content">
    <div class="outer">
      <div class="inner bg-light lter"> 
        <!--BEGIN INPUT TEXT FIELDS-->
        <div class="row">
          <div class="col-lg-12">
            <div class="box dark">
              <header>
                <div class="icons"><i class="fa fa-edit"></i></div>
                <h5>Creat new user</h5>
                <!-- .toolbar -->
                <div class="toolbar">
                  <nav style="padding: 8px;"> <a href="javascript:;" class="btn btn-default btn-xs collapse-box"> <i class="fa fa-minus"></i> </a> <a href="javascript:;" class="btn btn-default btn-xs full-box"> <i class="fa fa-expand"></i> </a> </nav>
                </div>
                <!-- /.toolbar --> 
              </header>
              <div id="div-1" class="body">
                <form class="form-horizontal" name="user_frm" method="post" enctype="multipart/form-data" action="<?php echo basename($_SERVER['PHP_SELF']); ?>">
                  <div class="form-group">
                    <label for="text1" class="control-label col-lg-2">User Name</label>
                    <div class="col-lg-4">
                      <input type="text" name="user_name" placeholder="username" class="form-control" onkeyup="checkUser(this.value);" value="<?php if(isset($user_edit_id) && !empty($user_name)){ echo $user_name; } ?>">
                    </div>
                    &nbsp;<span style="float:left;" id="results1"></span> </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label for="pass1" class="control-label col-lg-2">Email</label>
                    <div class="col-lg-4">
                      <input type="email" name="email" placeholder="mail@domain.com" class="form-control" onMouseOut="checkEmail(this.value)" value="<?php if(isset($user_edit_id) && !empty($email)){ echo $email; } ?>">
                    </div>
                    &nbsp;<span style="float:left;" id="results2"></span> </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label class="control-label col-lg-2">Phone</label>
                    <div class="col-lg-4">
                      <div class="input-group">
                        <input class="form-control" type="text" name="phone" placeholder="Phone" data-mask="+88 999 999 99999" value="<?php if(isset($user_edit_id) && !empty($phone)){ echo $phone; } ?>">
                        <span class="input-group-addon" style="width:2em">+88 999 999 99999</span> </div>
                    </div>
                  </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label for="pass1" class="control-label col-lg-2">Password</label>
                    <div class="col-lg-4">
                      <input type="password" name="password" placeholder="password" class="form-control middle" data-original-title="Please use your secure password" data-placement="top">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label for="pass1" class="control-label col-lg-2">Confirm password</label>
                    <div class="col-lg-4">
                      <input type="password" name="re-password" placeholder="re-password" class="form-control middle" data-original-title="Please use your secure password" data-placement="top">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label for="text2" class="control-label col-lg-2">Full Name</label>
                    <div class="col-lg-4">
                      <input type="text" id="text2" placeholder="Full Name" class="form-control" name="full_name" value="<?php if(isset($user_edit_id) && !empty($full_name)){ echo $full_name; } ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="limiter" class="control-label col-lg-2">Mailing Address</label>
                    <div class="col-lg-4">
                      <textarea id="limiter" name="mailing_address" class="form-control"><?php if(isset($user_edit_id) && !empty($mailing_address)){ echo $mailing_address; } ?></textarea>
                    </div>
                  </div>
                  
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label class="control-label col-lg-2">User Type</label>
                    <div class="col-lg-4">
                       <select class="form-control" name="user_type" >
                       <option value="" >Select Type</option>
                        <?php 	
                        $rr=UserType::find_all();
                        foreach($rr as $usertype)
						{
                        ?>
                        <option value="<?php echo $usertype->id; ?>"<?php if(isset($user_edit_id) && $usertype->id==$user_type)
						{ 
                            echo "selected class='selected'";}?>> <?php echo $usertype->type; ?></option>
                        <?php 
                        }
                        ?>
                        </select>
                    </div>
                  </div>
                  
                  <!-- /.form-group -->
                  
                  <div class="form-group">
                    <label class="control-label col-lg-2">Status</label>
                    <div class="col-lg-4">
                      <div class="checkbox">

                          <label>
                          <input class="uniform" type="radio" name="status" checked="checked" value="Active" <?php if(isset($user_edit_id) && $status=="Active") { echo "checked='checked'";} ?> />Active
                          </label>
                          <label>
                          <input class="uniform" type="radio" name="status" value="Inactive" <?php if(isset($user_edit_id) && $status=="Inactive") { echo "checked='checked'";} ?> />Inactive
                          </label>
                      </div>
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <div class="col-lg-2">&nbsp; </div>
                    <div class="col-lg-4">
                    <input type="hidden" name="secretId" value="<?php if(isset($user_edit_id)){ echo $user_id; } ?>" >
                      <input type="submit" class="btn btn-primary btn-grad" name="save" value="Save User">
                      <input type="reset" class="btn btn-primary btn-grad" name="new" value="New User" >
                    </div>
                  </div>
                </form>
              </div>
               <script language="JavaScript" type="text/javascript">
            //<![CDATA[
  			//You should create the validator only after the definition of the HTML form
  			var frmvalidator  = new Validator("user_frm");
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
               <hr>
              <!--BEGIN Table-->
              <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header>
                    <h5>Pending User List</h5>
                    <div class="toolbar">
                      <div class="btn-group"> <a href="#sortableTable" data-toggle="collapse" class="btn btn-default btn-sm collapse-box"> <i class="fa fa-minus"></i> </a> </div>
                    </div>
                  </header>

                    <div style="height:405px; padding-left:.5em; padding-top:.5em; overflow:auto">
                      <table id="dataTable" width="100%" class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                          <tr>
                            <th>User Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>User type</th>
                            <th>Status</th>
                            <th>Mailing Address</th>
                            <th>Edit</th>
                    		<th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
							$find ="";
							if(!empty($search_type)):
								$find = "AND `user_type`='$search_type'";
							endif;
							
							$sql= "select * from `user` where `status` = 'Inactive' ".$find." ORDER BY `user_name`";
							//echo $sql_branch;
							$rr=User::find_by_sql($sql);
							foreach($rr as $users){	
							
							$user_id = $users->id;  
							$user_name = $users->user_name;
							$phone = $users->phone ;
							$email = $users->email;
							$status =$users->status;
							$user_type = $users->user_type;
							if(!empty($user_type) && $user_type != 0)
							$user_type = UserType::find('type', $users->user_type);
							$mailing_address =$users->mailing_address;
									
							?>
                          <tr>
                            <td><?php echo $user_name; ?></td>
                            <td><?php echo $phone; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $user_type; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $mailing_address; ?></td>
                            <td><a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?id=<?php if(isset($user_id) && !empty($user_id)) echo $user_id."&u=1"; ?>"><div class="glyphicon glyphicon-edit" title="Edit">Edit</div></a></td>
                    <td><a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?id=<?php if(isset($user_id) && !empty($user_id)) echo $user_id."&d=1"; ?>"><div class="glyphicon glyphicon-remove" title="Delete">Delete</div></a></td>
                          </tr>
                          <?php
                }
                ?>
                        </tbody>
                      </table>
                    </div>
              
                </div>
              </div>
              
              <!--END Table--> 
              </div>
              <!--END Row--> 
            </div>
          </div>
        </div>
      </div>
      <!-- /.row --> 
      
    </div>
  </div>
  <!-- /.inner --> 
</div>
<!-- /.outer -->
</div>
<!-- /#content -->

</div>
<!-- /#wrap -->
<?php require("../footer.php"); ?>
<!-- /#footer --> 
<!-- #helpModal --> 

<!-- /.modal --> 
<!-- /#helpModal --> 
<!--jQuery --> 

<script src="/ars_courier/project/assets/lib/jquery/jquery.js"></script> 
<script src="/ars_courier/project/assets/lib/jquery/jquery-ui.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/datatables/jquery.dataTables.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/datatables/dataTables.bootstrap.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/datatables/jquery.tablesorter.min.js"></script> 
<script src="/ars_courier/project/assets/lib/jquery/jquery.ui.touch-punch.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/autosize/jquery.autosize.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/jasny-bootstrap/jasny-bootstrap.min.js"></script> 
<script src="/ars_courier/project/assets/lib/inputlimiter/jquery.inputlimiter.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/bootstrap-switch/bootstrap-switch.min.js"></script> 

<!--Bootstrap --> 
<script src="/ars_courier/project/assets/lib/bootstrap/js/bootstrap.js"></script> 
<!-- MetisMenu --> 
<script src="/ars_courier/project/assets/lib/metismenu/metisMenu.js"></script> 
<!-- onoffcanvas --> 
<script src="/ars_courier/project/assets/lib/onoffcanvas/onoffcanvas.js"></script> 
<!-- Screenfull --> 
<script src="/ars_courier/project/assets/lib/screenfull/screenfull.js"></script> 

<!-- Metis core scripts --> 
<script src="/ars_courier/project/assets/js/core.js"></script> 
<!-- Metis demo scripts --> 
<script src="/ars_courier/project/assets/js/app.js"></script> 
<script>
                  /*  $(function() {
                      Metis.formGeneral();
                    });*/
						
					$(function() {
                      Metis.MetisTable();
                      Metis.metisSortable();
					  Metis.formGeneral();
                    });
                </script> 
<script src="/ars_courier/project/assets/js/style-switcher.js"></script>
</body>
</html>
