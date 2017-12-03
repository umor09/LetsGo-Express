<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}

if(isset($_POST["status"]) && $_POST["status"]!= ""){
$search_status = $_POST['status'];
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
<title><?php echo $title;?>Gate Pass</title>
<link rel="icon" href="../images/logo_ico.png" type="image/x-icon">
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

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<link rel="stylesheet" href="/ars_courier/project/assets/css/style-switcher.css">
<link rel="stylesheet/less" type="text/css" href="/ars_courier/project/assets/less/theme.less">
<script src="/ars_courier/project/assets/less/less.js"></script>
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
            </span></div>
        </form>
        <!-- /.main-search --> </div>
      <!-- /.search-bar -->
      <div class="main-bar">
        <h3> <i class="fa fa-table"></i>&nbsp;Gate Pass </h3>
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
        <!--Begin Datatables-->
        <div class="row">
          <div class="col-lg-12">
            <div class="box">
              <header>
                <div class="icons"><i class="fa fa-table"></i></div>
                <h5>Gate Pass</h5>
                <div class="toolbar">
                  <div class="btn-group"> <a href="#sortableTable" data-toggle="collapse" class="btn btn-default btn-sm collapse-box"> <i class="fa fa-minus"></i> </a></div>
                </div>
              </header>
              <div id="collapse4" class="body">
                <div class="gate_pass_table" id="vehicle" style="height:405px; overflow:auto">
                  <table id="dataTable" width="100%" class="table table-bordered table-condensed table-hover table-striped vehicle">
                    <thead>
                      <tr>
                        <th>Vehicle Type</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Reg. No</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
			$find ="";
			if(!empty($search_status)):
				$find = "AND `status`='$search_status'";
				else:
				$find = "AND `status`='T'";
			endif;
			
			$sql= "select * from `vehicle` where `id` != '' ".$find." ORDER BY `entry_date` ";
			//echo $sql;
			$rr=Vehicle::find_by_sql($sql);
			foreach($rr as $vehicleObj){
			
			$vehicle_id = $vehicleObj->id;  
			$vehicle_type = $vehicleObj->vehicle_type;
			$brand = $vehicleObj->brand;
			$model = $vehicleObj->model;
			$reg_no = $vehicleObj->reg_no;
			$vehicle_status =$vehicleObj->status; 
					
			?>
                      <tr>
                        <td><?php echo $vehicle_type; ?></td>
                        <td><?php echo $brand; ?></td>
                        <td><?php echo $model; ?></td>
                        <td><?php echo $reg_no; ?></td>
                        <td align="center"><?php echo $vehicle_status; ?></td>
                        <td><input type="checkbox"  class="vehicle" data-id="<?php echo $vehicle_id; ?>" name="status<?php if(!empty($vehicle_id)) echo $vehicle_id; ?>" value="F" <?php if($vehicle_status == "F") echo 'checked="checked"'; ?> />
                          Pass </td>
                      </tr>
                      <?php
       }
    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row --> 
        <!--End Datatables--> 
        
      </div>
      <!-- /.inner --> 
    </div>
    <!-- /.outer --> 
  </div>
  <!-- /#content --> 
  
  <!-- /#right --> 
</div>
<!-- /#wrap -->
<?php require("../footer.php"); ?>
<!-- /#footer --> 

<!--jQuery --> 
<script src="/ars_courier/project/assets/lib/jquery/jquery.js"></script> 
<script src="/ars_courier/project/assets/lib/jquery/jquery-ui.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/datatables/jquery.dataTables.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/datatables/dataTables.bootstrap.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/datatables/jquery.tablesorter.min.js"></script> 
<script src="/ars_courier/project/assets/ajax/libs/jasny-bootstrap/jasny-bootstrap.min.js"></script> 

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
 $(function() {
	  Metis.MetisTable();
	  Metis.metisSortable();
	});
	
$(document).ready(function(){
$(".vehicle").change(function (e){  
  e.preventDefault(); 
  
 	var vehicle_id=$(this).attr('data-id');
	//alert(vehicle_id);	
	var dataString = 'id='+vehicle_id+ '&status=F';
	
  if(confirm("Do you want to pass vehicle?"))  
  {    
   //build a post data structure  
   $.ajax({
	  type: "POST", // HTTP method POST or GET
	  url: "gatepass_approval.sql.php", //PHP Page where all your query will write
	  dataType:"text", // Data type, HTML, json etc.
	  data:dataString, //Form Field values 
	  success:function(data){ 
		//$('#vehicle')[0].load('#vehicle'); 
		$('.vehicle').load();    
    		},
	  	});
	  } 
	  });
	  });
	  
</script> 
<script src="/ars_courier/project/assets/js/style-switcher.js"></script>
</body>
</html>
