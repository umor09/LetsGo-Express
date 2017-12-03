<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}

if(isset($_POST["booking_status"]) && $_POST["booking_status"]!= ""){
$search_status = $_POST['booking_status'];
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
<title><?php echo $title;?></title>
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

<script language="javascript" >

function approval(id, status){
$.post("booking_approval.sql.php",{inv_id:id, approval_status:status}, function(data){
//alert("Hello! I am an alert box!!");
//$("#results").html(data);
//alert(status);
window.location.href='booking_receive.php';

});
//
}	

function disp_confirm(id, status)
{
var r=confirm("Are you sure ! You want to do it?");
if(r==true)
{
//alert(var1);
approval(id, status);
return true;
}
else
{
return false;
}

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
        <h3> <i class="fa fa-table"></i>&nbsp;
          Booking Receive </h3>
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
                <h5>Booking Receive</h5>
                <div class="toolbar">
                  <div class="btn-group"> <a href="#sortableTable" data-toggle="collapse" class="btn btn-default btn-sm collapse-box"> <i class="fa fa-minus"></i> </a></div>
                </div>
              </header>
              <div id="collapse4" class="body">
                <div id="div-1" class="body">
                  <form class="form-horizontal" name="bookingreceivefrm" method="post" action="">
                    <div class="form-group">
                      <label class="control-label col-lg-2">Booking Status</label>
                      <div class="checkbox">
                        <label>
                          <input class="uniform" type="radio" name="booking_status" checked="checked" value="Request" onClick="bookingreceivefrm.submit()" <?php if(isset($search_status) && $search_status=="Request") { echo "checked='checked'";} ?> />Request </label>
                        <label>
                          <input class="uniform" type="radio" name="booking_status" value="Rejected" onClick="bookingreceivefrm.submit()" <?php if(isset($search_status) && $search_status=="Rejected") { echo "checked='checked'";} ?> />Rejected </label>
                          <label>
                          <input class="uniform" type="radio" name="booking_status" value="Booked" onClick="bookingreceivefrm.submit()" <?php if(isset($search_status) && $search_status=="Booked") { echo "checked='checked'";} ?> />Booked </label>
                      </div>
                    </div>
                    <!-- /.form-group -->
                  </form>
                </div>
                <hr>
                <div style="height:405px; overflow:auto">
                  <table id="dataTable" width="100%" class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                      <tr>
                        <th>Service Point</th>
                        <th>Client Name</th>
                        <th>Client Phone</th>
                        <th>Packet qty</th>
                        <th>Booking Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
							$find ="";
							if(!empty($search_status)):
								$find = "AND `booking_status`='$search_status'";
								else:
								$find = "AND `booking_status`='Request'";
							endif;
							
							$sql= "select * from `Booking` where `id` != '' ".$find." ORDER BY `entry_date` ";
							//echo $sql_branch;
							$rr=Booking::find_by_sql($sql);
							foreach($rr as $booking){
							
							$booking_id = $booking->id;  
							$service_point_id = $booking->service_point_id;
							$customer_id = $booking->customer_id ;
							$request_time = $booking->request_time;
							$booking_status =$booking->booking_status;
								if(!empty($service_point_id)):
								$servicepointObj = ServicePoint::find_by_id($service_point_id);
								$service_point_name = $servicepointObj->name;
								endif;
								if(!empty($customer_id)):
								$userObj = User::find_by_id($customer_id);
								$client_name = $userObj->full_name;
								$client_phone = $userObj->phone;
								endif;
								
								$packet_qty = BookingDetails::sum_invoid($booking_id);
									
							?>
                      <tr>
                        <td><?php echo $service_point_name; ?></td>
                        <td><a data-toggle="modal" class="detailsModal" data-id="<?php echo $booking_id; ?>" data-target="#detailsModal" ><?php echo $client_name; ?></a></td>
                        <td><?php echo $client_phone; ?></td>
                        <td align="center"><?php echo $packet_qty; ?></td>
                        <td><?php echo $booking_status; ?></td>
                        <td>
                        <input onclick="return disp_confirm('<?php if(!empty($booking_id))echo $booking_id; ?>','Booked');" type="radio" name="status<?php if(!empty($booking_id)) echo $booking_id; ?>" <?php if($booking_status == "Booked") echo 'checked="checked"'; ?> />Booked &nbsp;
                        <input onclick="return disp_confirm('<?php if(!empty($booking_id)) echo $booking_id; ?>','Rejected');" type="radio" name="status<?php if(!empty($booking_id)) echo $booking_id; ?>" <?php if($booking_status=="Rejected") echo 'checked="checked"'; ?> />
                          Reject</td>
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
<!-- #detailsModal -->
<div class="modal fade" id="detailsModal" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content" style="height:42em">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Booking Details!</h4>
      </div>
      <div class="modal-body">
               
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>

<!-- /.modal --> 
<!-- /#detailsModal --> 
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
    $('.detailsModal').click(function(){
        var ID=$(this).attr('data-id');
		//alert(ID);
        $.ajax({url:"booking_details.php?ID="+ID,cache:false,success:function(result){
            $(".modal-body").html(result);
        }});
    });
</script> 
<script>
	$(function() {
	  Metis.MetisTable();
	  Metis.metisSortable();
	});
</script>

<script src="/ars_courier/project/assets/js/style-switcher.js"></script>
</body>
</html>
