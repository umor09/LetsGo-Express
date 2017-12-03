<!doctype html>
<html>
    <head>
    <meta charset="UTF-8">
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>::ARS::</title>
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
        <h3> <i class="fa fa-home"></i>&nbsp;
              Home Page </h3>
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
        <div class="col-lg-12">
              <h1>bootstrap-admin-template</h1>
              <p>Metis is a simple yet powerful free Bootstrap admin dashboard template that you can feel free to use for any app, service, software or anything else. Feel free to share and fork it.</p>
              <p>This template currently is slighly outdated but withing few weeks we are going to make a major overhaul making ot the best free admin template you have seen on Github or elsehwere on the web.</p>
              <ul>
            <li><a href="#"><img src="#" alt="Build Status"></a></li>
            <li><a href="#"><img src="#" alt="Dependency Status"></a></li>
            <li><a href="#"><img src="#" alt="devDependency Status"></a></li>
          </ul>
              <h2>TOC</h2>
              <ul>
            <li><a href="#download">Download</a>
                  <ul>
                <li><a href="#building">Building</a></li>
                <li><a href="#demo">Demo</a></li>
                <li><a href="#release-history">Release History</a></li>
                <li><a href="#credits">Credits</a></li>
                <li><a href="#author">Author</a></li>
                <li><a href="#license">License</a></li>
              </ul>
                </li>
          </ul>
              <h2>Download</h2>
              <ul>
            <li>Bootstrap 2.3.2 <a href="https://github.com/puikinsh/Bootstrap-Admin-Template/archive/v1.2.zip">v1.2</a> ready for use</li>
            <li>Bootstrap 3.3.7 <a href="https://puikinsh.com/puikinsh/Bootstrap-Admin-Template/archive/master.zip">v2.3.2</a> ready <code>public</code> folder your use</li>
          </ul>
              <h4>2.3.2 Version</h4>
              <p>required <a href="http://nodejs.org/">node.js</a> & <a href="http://bower.io/">bower</a> & <a href="http://gulpjs.com/">gulp</a></p>
              <pre><code class="lang-shell">    $ git clone https://github.com/puikinsh/Bootstrap-Admin-Template.git yourfoldername
    $ cd yourfoldername
    $ npm install
    $ bower install
    $ npm run build
    $ gulp serve
</code></pre>
              <h4>2.3.2 RTL Version</h4>
              <p>required <a href="http://nodejs.org/">node.js</a> & <a href="http://bower.io/">bower</a> & <a href="http://gulpjs.com/">gulp</a></p>
              <pre><code class="lang-shell">    $ git clone https://github.com/puikinsh/Bootstrap-Admin-Template.git yourfoldername
    $ cd yourfoldername
    $ npm install
    $ bower install
    $ npm run buildrtl
    $ gulp serve
</code></pre>
              <h4>1.2 Version</h4>
              <pre><code class="lang-shell">    $ git clone -b v1.2 https://github.com/puikinsh/Bootstrap-Admin-Template.git yourfoldername
    $ cd yourfoldername
    $ git submodule init
    $ git submodule update
    $ open index.html
</code></pre>
              <h2>Demo</h2>
              <ul>
            <li><a href="https://colorlib.com/polygon/metis/">Demo v2.3.2</a></li>
            <li><a href="https://colorlib.com/polygon/metis/rtl/">RTL v2.3.2</a></li>
          </ul>
              <h2>Credits</h2>
              <ul>
            <li><a href="http://nodejs.org/">node.js</a></li>
            <li><a href="http://bower.io/">bower</a></li>
            <li><a href="http://gulpjs.com/">gulp</a></li>
            <li><a href="http://assemble.io/">Assemble</a></li>
            <li><a href="http://jquery.com/">jQuery</a></li>
            <li><a href="http://getbootstrap.com/">Bootstrap</a></li>
            <li><a href="http://lesscss.org/">LESS</a></li>
            <li><a href="http://momentjs.com/">Moment.js</a></li>
            <li><a href="https://github.com/subtlepatterns/SubtlePatterns">SubtlePatterns</a></li>
            <li><a href="http://arshaw.com/fullcalendar/">FullCalendar</a></li>
            <li><a href="https://github.com/harvesthq/chosen">Chosen</a></li>
            <li><a href="http://ckeditor.com/">CKEditor</a></li>
            <li><a href="http://www.eyecon.ro/bootstrap-colorpicker/">Colorpicker for Bootstrap</a></li>
            <li><a href="http://www.datatables.net">Data Tables</a></li>
            <li><a href="http://www.eyecon.ro/bootstrap-datepicker">Datepicker for Bootstrap</a></li>
            <li><a href="http://elfinder.org">elFinder</a></li>
            <li><a href="http://rustyjeans.com/jquery-plugins/input-limiter">Input Limiter</a></li>
            <li><a href="http://jasny.github.com/bootstrap">Jasny Bootstrap</a></li>
            <li><a href="http://jqueryvalidation.org/">jQuery Validation</a></li>
            <li><a href="http://omnipotent.net/jquery.sparkline">jQuery Sparklines</a></li>
            <li><a href="http://daneden.github.io/animate.css/">Animate</a></li>
            <li><a href="http://www.jacklmoore.com/autosize">Autosize</a></li>
            <li><a href="http://keith-wood.name/countdown.html">Countdown</a></li>
            <li><a href="https://github.com/dangrossman/bootstrap-daterangepicker">Date range picker</a></li>
            <li><a href="http://www.flotcharts.org">Flot</a></li>
            <li><a href="http://jquery.malsup.com/form/">jQuery Form</a></li>
            <li><a href="http://thecodemine.org">Form Wizard</a></li>
            <li><a href="http://boedesign.com/blog/2009/07/11/growl-for-jquery-gritter/">Gritter</a></li>
            <li><a href="https://github.com/brandonaaron/jquery-mousewheel">Mouse Wheel</a></li>
            <li><a href="https://github.com/kevinoconnor7/pagedown-bootstrap">PageDown-Bootstrap</a></li>
            <li><a href="https://github.com/moxiecode/plupload">Plupload</a></li>
            <li><a href="http://www.larentis.eu/switch/">Bootstrap Switch</a></li>
            <li><a href="http://tablesorter.com/">tablesorter</a></li>
            <li><a href="http://xoxco.com/projects/code/tagsinput/">tagsinput</a></li>
            <li><a href="http://jdewit.github.io/bootstrap-timepicker/">Bootstrap Timepicker</a></li>
            <li><a href="http://touchpunch.furf.com/">Touch Punch</a></li>
            <li><a href="http://uniformjs.com/">Uniform</a></li>
            <li><a href="http://www.position-relative.net/">Validation Engine</a></li>
            <li><a href="http://validval.frebsite.nl/">jquery.validVal</a></li>
            <li><a href="https://github.com/Waxolunist/bootstrap3-wysihtml5-bower">bootstrap3-wysihtml5-bower</a></li>
            <li><a href="https://github.com/sindresorhus/screenfull.js">screenfull.js</a></li>
            <li><a href="https://github.com/onokumus/metisMenu">metisMenu</a></li>
          </ul>
              <h2>About Authors</h2>
              <ul>
            <li><a href="https://colorlib.com/">Colorlib</a> - Colorlib is the most popular source for free WordPress themes and HTML templates.</li>
            <li><a href="https://twitter.com/AigarsSilkalns">Aigars Silkalns</a> - Aigars maintains this project and is also the idea author behind Colorlib and everythiwn you will find on that website.</li>
          </ul>
              <h2>License</h2>
              <p>Copyright (c) 2016 Aigars Silkalns & Colorlib</p>
              <p>Released under the MIT license. This free Bootstrap admin template is distributed as as it with no support. You can feeel free to use it, share it, tweakit it, workin it, sell it or do whatver you want as long as you keep the original license in plce.</p>
              <hr>
              <p><em>This file was generated by <a href="https://github.com/verbose/verb">verb</a>, v0.9.0, on July 31, 2016.</em></p>
            </div>
      </div>
          <!-- /.inner --> 
        </div>
    <!-- /.outer --> 
  </div>
      <!-- /#content -->
      <div id="right" class="onoffcanvas is-right is-fixed bg-light" aria-expanded="false"> <a class="onoffcanvas-toggler" href="#right" data-toggle="onoffcanvas" aria-expanded="false"></a> <br>
    <br>
    <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Warning!</strong> Best check yo self, you're not looking too good. </div>
    <!-- .well well-small -->
    <div class="well well-small dark">
          <ul class="list-unstyled">
        <li>Visitor <span class="inlinesparkline pull-right">1,4,4,7,5,9,10</span></li>
        <li>Online Visitor <span class="dynamicsparkline pull-right">Loading..</span></li>
        <li>Popularity <span class="dynamicbar pull-right">Loading..</span></li>
        <li>New Users <span class="inlinebar pull-right">1,3,4,5,3,5</span></li>
      </ul>
        </div>
    <!-- /.well well-small --> 
    <!-- .well well-small -->
    <div class="well well-small dark">
          <button class="btn btn-block">Default</button>
          <button class="btn btn-primary btn-block">Primary</button>
          <button class="btn btn-info btn-block">Info</button>
          <button class="btn btn-success btn-block">Success</button>
          <button class="btn btn-danger btn-block">Danger</button>
          <button class="btn btn-warning btn-block">Warning</button>
          <button class="btn btn-inverse btn-block">Inverse</button>
          <button class="btn btn-metis-1 btn-block">btn-metis-1</button>
          <button class="btn btn-metis-2 btn-block">btn-metis-2</button>
          <button class="btn btn-metis-3 btn-block">btn-metis-3</button>
          <button class="btn btn-metis-4 btn-block">btn-metis-4</button>
          <button class="btn btn-metis-5 btn-block">btn-metis-5</button>
          <button class="btn btn-metis-6 btn-block">btn-metis-6</button>
        </div>
    <!-- /.well well-small --> 
    <!-- .well well-small -->
    <div class="well well-small dark"> <span>Default</span><span class="pull-right"><small>20%</small></span>
          <div class="progress xs">
        <div class="progress-bar progress-bar-info" style="width: 20%"></div>
      </div>
          <span>Success</span><span class="pull-right"><small>40%</small></span>
          <div class="progress xs">
        <div class="progress-bar progress-bar-success" style="width: 40%"></div>
      </div>
          <span>warning</span><span class="pull-right"><small>60%</small></span>
          <div class="progress xs">
        <div class="progress-bar progress-bar-warning" style="width: 60%"></div>
      </div>
          <span>Danger</span><span class="pull-right"><small>80%</small></span>
          <div class="progress xs">
        <div class="progress-bar progress-bar-danger" style="width: 80%"></div>
      </div>
        </div>
  </div>
      <!-- /#right --> 
    </div>
<!-- /#wrap -->
<?php require("footer.php"); ?>
<!-- /#footer --> 
<!-- #helpModal -->

<!-- /.modal --> 
<!-- /#helpModal --> 
<!--jQuery --> 
<script src="assets/lib/jquery/jquery.js"></script> 
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
<script src="assets/js/style-switcher.js"></script>
</body>
</html>