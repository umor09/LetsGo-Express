<?php
require_once("../../includes/initialize.php");
if(empty($_SESSION['in_user_id'])) {redirect_to("logout.php");}

if(isset($_GET["user_type"]) && $_GET["user_type"]!= ""){
$search_type = $_GET['user_type'];
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
          Report </h3>
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
                <h5>User list</h5>
                <div class="toolbar">
                  <div class="btn-group"> <a href="#sortableTable" data-toggle="collapse" class="btn btn-default btn-sm collapse-box"> <i class="fa fa-minus"></i> </a></div>
                </div>
              </header>
              <div id="collapse4" class="body">
               <div id="div-1" class="body">
                <form class="form-horizontal" name="usertypefrm">
                     <div class="form-group">
                    <label class="control-label col-lg-2">User type</label>
                    <div class="col-lg-2">
                        <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
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
                        <th>User Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>User type</th>
                        <th>Status</th>
                        <th>Mailing Address</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                     <?php
							$find ="";
							if(!empty($search_type)):
								$find = "AND `user_type`='$search_type'";
							endif;
							
							$sql= "select * from `user` where `id` != '' ".$find." ORDER BY `user_name`";
							//echo $sql_branch;
							$rr=User::find_by_sql($sql);
							foreach($rr as $users){	  
							$user_name = $users->user_name;
							$phone = $users->phone ;
							$email = $users->email;
							$status =$users->status;
							$user_type = $users->user_type;
								if($user_type != 0 && $user_type != '' ):
								$user_type = UserType::find('type', $user_type);
								endif;
							$mailing_address =$users->mailing_address;
									
							?>
                    <tr>
                    <td><?php echo $user_name; ?></td>
                    <td><?php echo $phone; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $user_type; ?></td>
                    <td><?php echo $status; ?></td>
                    <td><?php echo $mailing_address; ?></td>
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
        
        <div class="row"> 
          <!-- .col-lg-6 -->
          <div class="col-lg-12">
            <div class="box">
              <header>
                <h5>Sortable Table</h5>
                <div class="toolbar">
                  <div class="btn-group"> <a href="#sortableTable" data-toggle="collapse" class="btn btn-default btn-sm collapse-box"> <i class="fa fa-minus"></i> </a> <a class="btn btn-danger btn-sm close-box"><i class="fa fa-times"></i></a> </div>
                </div>
              </header>
              <div id="sortableTable" class="body collapse in">
                <table class="table table-bordered sortableTable responsive-table">
                  <thead>
                    <tr>
                      <th>#<i class="fa sort"></i></th>
                      <th>First Name<i class="fa sort"></i></th>
                      <th>Last Name<i class="fa sort"></i></th>
                      <th>Score<i class="fa sort"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Jill</td>
                      <td>Smith</td>
                      <td>50</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Eve</td>
                      <td>Jackson</td>
                      <td>94</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>John</td>
                      <td>Doe</td>
                      <td>80</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Adam</td>
                      <td>Johnson</td>
                      <td>67</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.col-lg-6 --> 
        </div>
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
<!-- #helpModal --> 

<!-- /.modal --> 
<!-- /#helpModal --> 
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
<script src="/ars_courier/project/assets/js/style-switcher.js"></script>
</body>
</html>
