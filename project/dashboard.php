<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<!--IE Compatibility modes-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--Mobile first-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Dashboard</title>
<meta name="description" content="Free Admin Template Based On Twitter Bootstrap 3.x">
<meta name="author" content="">
<meta name="msapplication-TileColor" content="#5bc0de" />
<meta name="msapplication-TileImage" content="assets/img/metis-tile.png" />

<!-- Bootstrap -->
<link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="assets/lib/font-awesome/css/font-awesome.css">

<!-- Metis core stylesheet -->
<link rel="stylesheet" href="assets/css/main.css">

<!-- metisMenu stylesheet -->
<link rel="stylesheet" href="assets/lib/metismenu/metisMenu.css">

<!-- onoffcanvas stylesheet -->
<link rel="stylesheet" href="assets/lib/onoffcanvas/onoffcanvas.css">

<!-- animate.css stylesheet -->
<link rel="stylesheet" href="assets/lib/animate.css/animate.css">
<link rel="stylesheet" href="assets/lib/fullcalendar/fullcalendar.min.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!--For Development Only. Not required -->
<script>
less = {
env: "development",
relativeUrls: false,
rootpath: "/assets/"
};
</script>
<link rel="stylesheet" href="assets/css/style-switcher.css">
<link rel="stylesheet/less" type="text/css" href="assets/less/theme.less">
<script src="assets/less/less.js"></script>
</head>

<body class="  ">
<div class="bg-dark dk" id="wrap">
  <div id="top"> 
    <!-- .navbar -->
    <?php require("top_navigation.php"); ?>
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
        <h3> <i class="fa fa-dashboard"></i>&nbsp;
          Dashboard </h3>
      </div>
      <!-- /.main-bar --> 
    </header>
    <!-- /.head --> 
    
  </div>
  <!-- /#top -->
  <?php require("left_menu.php"); ?>
  <!-- /#left -->
  <div id="content">
    <div class="outer">
      <div class="inner bg-light lter">
        <div class="text-center">
          <ul class="stats_box">
            <li>
              <div class="sparkline bar_week"></div>
              <div class="stat_text"> <strong>2.345</strong>Weekly Visit <span class="percent down"> <i class="fa fa-caret-down"></i> -16%</span> </div>
            </li>
            <li>
              <div class="sparkline line_day"></div>
              <div class="stat_text"> <strong>165</strong>Daily Visit <span class="percent up"> <i class="fa fa-caret-up"></i> +23%</span> </div>
            </li>
            <li>
              <div class="sparkline pie_week"></div>
              <div class="stat_text"> <strong>$2 345.00</strong>Weekly Sale <span class="percent"> 0%</span> </div>
            </li>
            <li>
              <div class="sparkline stacked_month"></div>
              <div class="stat_text"> <strong>$678.00</strong>Monthly Sale <span class="percent down"> <i class="fa fa-caret-down"></i> -10%</span> </div>
            </li>
          </ul>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="box">
              <header>
                <h5>Line Chart</h5>
              </header>
              <div class="body" id="trigo" style="height: 250px;"></div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="box">
              <div class="body">
                <table class="table table-condensed table-hovered sortableTable">
                  <thead>
                    <tr>
                      <th>Country <i class="fa sort"></i></th>
                      <th>Visit <i class="fa sort"></i></th>
                      <th>Time <i class="fa sort"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="active">
                      <td>Andorra</td>
                      <td>1126</td>
                      <td>00:00:15</td>
                    </tr>
                    <tr>
                      <td>Belarus</td>
                      <td>350</td>
                      <td>00:01:20</td>
                    </tr>
                    <tr class="danger">
                      <td>Paraguay</td>
                      <td>43</td>
                      <td>00:00:30</td>
                    </tr>
                    <tr class="warning">
                      <td>Malta</td>
                      <td>547</td>
                      <td>00:10:20</td>
                    </tr>
                    <tr>
                      <td>Australia</td>
                      <td>560</td>
                      <td>00:00:10</td>
                    </tr>
                    <tr>
                      <td>Kenya</td>
                      <td>97</td>
                      <td>00:20:00</td>
                    </tr>
                    <tr class="success">
                      <td>Italy</td>
                      <td>2450</td>
                      <td>00:10:00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-12">
            <div class="box">
              <header>
                <h5>Sortable Table</h5>
                <div class="toolbar">
                  <div class="btn-group"> <a href="#sortableTable" data-toggle="collapse" class="btn btn-default btn-sm minimize-box"> <i class="fa fa-angle-up"></i> </a> </div>
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
        </div>
        <hr>
      </div>
      <!-- /.inner --> 
    </div>
    <!-- /.outer --> 
  </div>
  <!-- /#content --> 
</div>
<!-- /#wrap -->
<?php require("footer.php"); ?>
<!-- /#footer --> 
<!-- #helpModal --> 

<!-- /.modal --> 
<!-- /#helpModal --> 
<!--jQuery --> 
<script src="assets/lib/jquery/jquery.js"></script> 
<script src="assets/lib/jquery/jquery-ui.min.js"></script> 
<script src="assets/lib/moment/moment.min.js"></script> 
<script src="assets/lib/fullcalendar/fullcalendar.min.js"></script> 
<script src="assets/ajax/libs/datatables/jquery.tablesorter.min.js"></script> 
<script src="assets/ajax/libs/jquery.sparkline.min.js"></script> 
<script src="assets/ajax/libs/flot/jquery.flot.min.js"></script> 
<!--script not found--> 
<script src="//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.selection.min.js"></script> 
<script src="//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.resize.min.js"></script> 

<!--Bootstrap --> 
<script src="assets/lib/bootstrap/js/bootstrap.js"></script> 
<!-- MetisMenu --> 
<script src="assets/lib/metismenu/metisMenu.js"></script> 
<!-- onoffcanvas --> 
<script src="assets/lib/onoffcanvas/onoffcanvas.js"></script> 
<!-- Screenfull --> 
<script src="assets/lib/screenfull/screenfull.js"></script> 

<!-- Metis core scripts --> 
<script src="assets/js/core.js"></script> 
<!-- Metis demo scripts --> 
<script src="assets/js/app.js"></script> 
<script>
$(function() {
Metis.dashboard();
});
</script> 
<script src="assets/js/style-switcher.js"></script>
</body>
</html>