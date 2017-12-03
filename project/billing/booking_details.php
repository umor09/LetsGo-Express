<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}

//dataId comes from ajax (POST)
$booking_id = filter_input(INPUT_GET, 'ID');

$bookingObj = Booking::find_by_id($booking_id);
if(!empty($bookingObj)):
 $service_point_id = $bookingObj->service_point_id;
 $customer_id = $bookingObj->customer_id;
 $booking_status = $bookingObj->booking_status;
 $request_time = $bookingObj->request_time;
	 if(!empty($customer_id)):
	 $clientObj = User::find_by_id($customer_id);
		if(!empty($clientObj)):
		$client_name = $clientObj->full_name;
		endif;
	 endif;
endif;
//you should use json_encode, and you can parse when get back data in ajax
//echo json_encode($rows['product_name']);

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
<div class="col-lg-12">
<div class="box">
  <table class="table table-bordered responsive-table">
                  <tbody>
                    <tr>
                      <td width="15%">Client Name</td>
                      <td><?php echo $client_name;?></td>
                      <td width="15%">Booking ID</td>
                      <td><?php echo $booking_id;?></td>
                    </tr>
                    <tr>
                      <td width="15%">Booking Status</td>
                      <td><?php echo $booking_status;?></td>
                      <td width="15%">Request Time</td>
                      <td><?php echo $request_time;?></td>
                    </tr>
                  </tbody>
                </table>
</div>
              <div id="sortableTable" class="body collapse in">
                <table class="table table-bordered sortableTable table-hover responsive-table">
                  <thead>
                    <tr>
                      <th>Sl</th>
                      <th>category</th>
                      <th>Product Name</th>
                      <th>Packet Size</th>
                      <th>P. Weight</th>
                      <th>P. Qty</th>
                      <th>Receiver</th>
                      <th>Receiving Address</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
				   $sl = 1;
						if(!empty($booking_id)):
							$sql_find = "SELECT * FROM booking_details bd LEFT JOIN booking b ON(bd.booking_id = b.id) where b.id=".$booking_id." ";
							$rr = BookingDetails::find_by_sql($sql_find);
							foreach($rr as $details):
								
							$product_category_id = $details->product_category_id;  
							$product_name = $details->product_name;
							$packet_size = $details->packet_size ;
							$packet_weight  = $details->packet_weight ;
							$packet_qty =$details->packet_qty;
							$receiver_name = $details->receiver_name ;
							$receiver_phone = $details->receiver_phone ;
							$receiver_address = $details->receiver_address ;
								if($product_category_id != 0 && $product_category_id != '' ):
								$categoryObj = ProductCategory::find_by_id($product_category_id);
								$product_category = $categoryObj->name;
								endif;
									
							?>
                        <tr>
                    <td><?php echo $sl; ?></td>
                    <td><?php echo $product_category; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $packet_size; ?></td>
                    <td><?php echo $packet_weight; ?></td>
                    <td><?php echo $packet_qty; ?></td>
                    <td><?php echo $receiver_name; ?></td>
                    <td><?php echo $receiver_address; ?></td>
                  </tr>
                  <?php
				  $sl++;
                endforeach;
				endif;
                ?>
                    
                  </tbody>
                </table>
              </div>
          </div>

</body>
</html>
