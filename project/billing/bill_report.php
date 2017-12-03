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
<title><?php echo $title;?> Bill Report</title>
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
                <h5>Bill Report</h5>
                <div class="toolbar">
                  <div class="btn-group"> <a href="#sortableTable" data-toggle="collapse" class="btn btn-default btn-sm collapse-box"> <i class="fa fa-minus"></i> </a></div>
                </div>
              </header>
              <div id="collapse4" class="body">
                <div id="div-1" class="body">
                  <form class="form-horizontal" name="bill_reportfrm" method="post" action="">
                    <div class="form-group">
                      <label class="control-label col-lg-2">Payment Type</label>
                      <div class="checkbox">
                        <label>
                          <input class="uniform" type="radio" name="payment_type" checked="checked" value="Cash" onClick="bill_reportfrm.submit()" <?php if(isset($search_status) && $search_status=="Cash") { echo "checked='checked'";} ?> />Cash </label>
                        <label>
                          <input class="uniform" type="radio" name="payment_type" value="Card" onClick="bill_reportfrm.submit()" <?php if(isset($search_status) && $search_status=="Card") { echo "checked='checked'";} ?> />Card </label>
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
                        <th>Bill Amount</th>
                        <th>Discount</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Print</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
							$find ="";
							if(!empty($search_status)):
								$find = "AND `payment_type`='$search_status'";
								else:
								$find = "AND `payment_type`='Cash' || `payment_type`=''";
							endif;
							
							$sql= "select * from `Bill` where `id` != '' ".$find." ORDER BY `entry_date` ";
							//echo $sql_branch;
							$rr=Bill::find_by_sql($sql);
							foreach($rr as $billing){
							
							$bill_id = $billing->id; 
							$booking_id = $billing->booking_id ;
							$bill_amount = $billing->bill_amount ;
							$discount = $billing->discount;
							$total_amount = $billing->total_amount;
							$paid_amount = $billing->paid_amount;
							$payment_type =$billing->payment_type;
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
                        <td align="right"><?php echo $bill_amount; ?></td>
                        <td align="center"><?php echo $discount; ?>%</td>
                        <td align="right"><?php echo $total_amount; ?></td>
                        <td align="right"><?php echo $paid_amount; ?></td>
                        <td>
                       <a data-toggle="modal" class="printModal" data-id="<?php echo $bill_id; ?>" data-original-title="Print" data-placement="bottom" data-target="#printModal"> <em class="fa fa-print"></em>&nbsp;Print</a></td>
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
        <h4 class="modal-title">Booking </h4>
      </div>
      <div class="modal-body"> </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>

<!-- /.modal --> 
<!-- /#detailsModal -->

<!-- #printModal -->
<div class="modal fade" id="printModal" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content" style="height:42em">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Print Bill </h4>
      </div>

      <div class="col-lg-8 printmodal">
        <iframe name="print" style="width:61em; height:35em;">
        </iframe>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- /#printModal -->

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
        $.ajax({url:"booking_details.php?ID="+ID,cache:false,success:function(result){
            $(".modal-body").html(result);
        }});
    });
	
		 $('.printModal').click(function(){
        var ID=$(this).attr('data-id');
		var page = "print_bill.php?ID="+ID;
   		document.getElementsByName('print')[0].src = page;
		
    });
	
</script>
<script src="/ars_courier/project/assets/js/style-switcher.js"></script>
</body>
</html>
