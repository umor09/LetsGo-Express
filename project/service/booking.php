<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}

if(isset($_POST["payment_type"]) && $_POST["payment_type"]!= ""){
$search_status = $_POST['payment_type'];
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
<title><?php echo $title;?>Bill Report</title>
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
            </span> </div>
        </form>
        <!-- /.main-search --> </div>
      <!-- /.search-bar -->
      <div class="main-bar">
        <h3> <i class="fa fa-table"></i>&nbsp;
          Bill Report </h3>
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
                <h5>Booking Transport</h5>
                <div class="toolbar">
                  <div class="btn-group"><a href="#sortableTable" data-toggle="collapse" class="btn btn-default btn-sm collapse-box"> <i class="fa fa-minus"></i></a></div>
                </div>
              </header>
              <div id="collapse4" class="body">
                <div id="div-1" class="body">
                  <form class="form-horizontal" name="bill_reportfrm" method="post" action="">
                    <div class="form-group">
                      <label class="control-label col-lg-2">Payment Type</label>
                      <div class="checkbox">
                        <label>
                          <input class="uniform" type="radio" name="payment_type" checked="checked" value="Cash" onClick="bill_reportfrm.submit()" <?php if(isset($search_status) && $search_status=="Cash") { echo "checked='checked'";} ?> />
                          Cash </label>
                        <label>
                          <input class="uniform" type="radio" name="payment_type" value="Card" onClick="bill_reportfrm.submit()" <?php if(isset($search_status) && $search_status=="Card") { echo "checked='checked'";} ?> />
                          Card </label>
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
                        <th>Bill Number</th>
                        <th>Client Name</th>
                        <th>Client Phone</th>
                        <th>Packet Qty</th>
                        <th>Booking Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
							$find ="";
							
							$sql= "select * from `booking` where `id` != '' ".$find." ORDER BY `entry_date` ";
							//echo $sql_branch;
							$rr=Booking::find_by_sql($sql);
							foreach($rr as $booking){
							
							$booking_id = $booking->id;
							$booking_status = $booking->booking_status;

								if(!empty($booking_id)):
								$bookingObj = Booking::find_by_id($booking_id);
								$customer_id = $bookingObj->customer_id;
								endif;
								if(!empty($customer_id)):
								$userObj = User::find_by_id($customer_id);
								$client_name = $userObj->full_name;
								$client_phone = $userObj->phone;
								endif;
								
								$packet_qty = BookingDetails::sum_invoid($booking_id);
									
							?>
                      <tr>
                        <td align="center"><?php echo $booking_id; ?></td>
                        <td><a data-toggle="modal" class="detailsModal" data-id="<?php echo $booking_id; ?>" data-target="#detailsModal" ><?php echo $client_name; ?></a></td>
                        <td align="right"><?php echo $client_phone; ?></td>
                        <td align="center"><?php echo $packet_qty; ?></td>
                        <td align="center"><?php echo $booking_status; ?></td>
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
<div class="modal fade" id="detailsModal" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content" style="height:42em">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Vehicle Managment </h4>
      </div>
      <div class="modal-body"> </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>

<!-- /.modal --> 
<!-- /#detailsModal -->

<div id="vehicleModal" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#detailsModal">
  <div class="modal-dialog modal-lg"> 
    <!-- Modal content-->
    <div class="modal-content" style="height:42em">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Vehicle Allocation</h4>
      </div>
      <div class="modal-vehicle"> </div>
      
    </div>
  </div>
</div>

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
</script> 
<script>

	$('.detailsModal').click(function(){
        var ID=$(this).attr('data-id');
		//alert(ID);
        $.ajax({url:"vehicle_managment.php?ID="+ID,cache:false,success:function(result){
            $(".modal-body").html(result);
        }});
    });
	
	$('.modal-child').on('show.bs.modal', function () {
    var modalParent = $(this).attr('data-modal-parent');
    $(modalParent).css('opacity', 0);
	});
 
	$('.modal-child').on('hidden.bs.modal', function () {
    var modalParent = $(this).attr('data-modal-parent');
    $(modalParent).css('opacity', 1);
	});
	
</script> 
<script src="/ars_courier/project/assets/js/style-switcher.js"></script>
</body>
</html>
