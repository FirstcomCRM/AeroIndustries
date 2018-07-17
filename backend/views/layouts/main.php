<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);


        $isDashboard = false;
        $isPartnCat = false;
        $isPartCat = false;
        $isPart= false;
        $isPartImport= false;
        $isStockImport= false;
        $isToolImport= false;
        $isStock= false;
        $isStockHistory= false;
        $isInventoryReport= false;
        $isStockReceive = false;
        $isStorage= false;
        $isSupplier = false;
        $isGpoSupplier = false;
        $isTpoSupplier = false;
        $isUser = false;
        $isUsernGroup = false;
        $isRfq= false;
        $isPO = false;
        $isGeneralPO = false;
        $isToolPO = false;
        $isUserGroup = false;
        $isStaffnGroup = false;
        $isStaff = false;
        $isStaffGroup = false;
        $isSetting = false;
        $isCurrency = false;
        $isQuotation = false;
        $isPermission = false;
        $isCustomer = false;
        $isWO = false;
        $isFinal = false;
        $isUnit = false;
        $isTemplate = false;
        $isCalibration = false;
        $isCapability = false;
        $isTraveler = false;
        $isTravelerLog = false;
        $isARC = false;
        $isUP = false;

        $isTool = false;
        $isQuarantine = false;
        $isScrap = false;
        $isDO = false;

        if ( isset ( $_GET['r'] ) ) {
            $getClass = $_GET['r'];
            $getAction = '';
            $url = explode('/', $_GET['r']);
            if ( $url ) {
              $getClass = $url[0];
              if ( isset($url[1]) ){
                $getAction = $url[1];
              }
            }

            if ( $getClass == 'part-category' ) {
              $isPartCat = true;
              $isPartnCat = true;
            }
            if ( $getClass == 'part' ) {
              $isPart = true;
              $isPartnCat = true;
            }
            if ( $getClass == 'part' && $getAction == 'import-excel' ) {
              $isPartImport = true;
              $isPart = false;
            }
            if ( $getClass == 'stock' && $getAction == 'import-excel' ) {
              $isStockImport = true;
              $isStock = false;
            }


            if ( $getClass == 'stock' ) {
              $isStock = true;
              $isStockReceive = true;
            }
            if ( $getClass == 'stock-history' ) {
              $isStockHistory = true;
            }
            if ( $getClass == 'stock' && $getAction == 'inventory-report' ) {
              $isInventoryReport = true;
              $isStock = false;
            }

            if ( $getClass == 'stock' && ( $getAction == 'stock' || $getAction == 'preview-stock') ) {
              $isStock = true;
              $isStockReceive = false;
            }


            if ( $getClass == 'tool' ) {
              $isTool = true;
            }
            if ( $getClass == 'tool' && $getAction == 'tool' || $getAction == 'preview-tool' ) {
              $isTool = true;
            }

            if ( $getClass == 'storage-location' ) {
              $isStorage = true;
              $isPartnCat = true;
            }
            if ( $getClass == 'unit' ) {
              $isUnit = true;
              $isPartnCat = true;
            }
            if ( $getClass == 'user-group' ) {
              $isUserGroup = true;
              $isUsernGroup = true;
            }
            if ( $getClass == 'user' ) {
              $isUser = true;
              $isUsernGroup = true;
            }
            if ( $getClass == 'staff' ) {
              $isStaff = true;
              $isStaffnGroup = true;
            }
            if ( $getClass == 'staff-group' ) {
              $isStaffGroup = true;
              $isStaffnGroup = true;
            }

            if ( $getClass == 'supplier') {
              $isSupplier = true;
            }

            if ( $getClass == 'gpo-supplier') {
              $isGpoSupplier = true;
            }

            if ( $getClass == 'tpo-supplier') {
              $isTpoSupplier = true;
            }

            if ( $getClass == 'purchase-order') {
              $isPO = true;
            }
            if ( $getClass == 'general-po') {
              $isGeneralPO = true;
            }
            if ( $getClass == 'tool-po') {
              $isToolPO = true;
            }

            if ( $getClass == 'tool' && $getAction == 'import-excel' ) {
              $isToolImport = true;
              $isTool = false;
            }
            if ( $getClass == 'rfq') {
              $isRfq= true;
            }

            if ( $getClass == 'staff') {
              $isStaff = true;
            }

            if ( $getClass == 'setting') {
              $isSetting = true;
            }

            if ( $getClass == 'currency') {
              $isCurrency = true;
            }

            if ( $getClass == 'customer') {
              $isCustomer = true;
            }

            if ( $getClass == 'quotation') {
              $isQuotation = true;
            }

            if ( $getClass == 'permission') {
              $isPermission = true;
            }

            if ( $getClass == 'work-order') {
              $isWO = true;
            }
            if ( $getClass == 'uphostery') {
              $isUP = true;
            }

            if ( $getClass == 'final-inspection') {
              $isFinal = true;
            }

            if ( $getClass == 'template') {
              $isTemplate = true;
            }

            if ( $getClass == 'calibration') {
              $isCalibration = true;
            }

            if ( $getClass == 'capability') {
              $isCapability = true;
            }

            if ( $getClass == 'quarantine') {
              $isQuarantine = true;
            }

            if ( $getClass == 'scrap') {
              $isScrap = true;
            }

            if ( $getClass == 'delivery-order') {
              $isDO = true;
            }

            if ( $getClass == 'traveler') {
              $isTraveler = true;
            }

            if ( $getClass == 'work-order-arc') {
              $isARC = true;
            }

            if ( $getClass == 'uphostery-arc') {
              $isupARC = true;
            }

        }


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <title>Aero Industries | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <!-- <link rel="stylesheet" href="plugins/morris/morris.css"> -->
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Time Picker -->
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="css/site.css">

</head>
<body class="hold-transition skin-red sidebar-mini <?= isset($_SESSION['sidebar-collapse'])?'sidebar-collapse':'' ?>">
<?php $this->beginBody() ?>


<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="?" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>AI</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Aero Industries</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->

          <li class="dropdown messages-menu po-dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-file-text"></i> Purchase Order
            </a>
            <ul class="dropdown-menu po-menu">
              <li class="header"><strong>Purchase Order</strong></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="?r=purchase-order/new">
                      <i class="fa fa-file-text text-aqua"></i> For Aviation parts
                    </a>
                  </li>
                  <li>
                    <a href="?r=tool-po/new">
                      <i class="fa fa-file-text-o text-yellow"></i> For Aviation tools
                    </a>
                  </li>
                  <li>
                    <a href="?r=general-po/new">
                      <i class="fa fa-file-text-o text-yellow"></i> For Non-aviation parts
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <?php /* <li class="dropdown notifications-menu requisition-dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-exchange"></i> Transaction
            </a>
            <ul class="dropdown-menu requisition-menu">
              <li class="header"><strong>Stock Transaction</strong></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="?r=work-order/requisition">
                      <i class="fa fa-check text-aqua"></i> Set Parts Required
                    </a>
                  </li>
                  <li>
                    <a href="?r=work-order/issue">
                      <i class="fa fa-external-link text-yellow"></i> Issue Parts
                    </a>
                  </li>
                  <li>
                    <a href="?r=work-order/return">
                      <i class="fa fa-mail-reply text-red"></i> Return Parts
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li> */ ?>
          <li class="dropdown messages-menu">
            <a href="?r=stock/new" class="" >
              <i class="fa fa-download"></i>&nbsp;
              Stock Receive
            </a>
          </li>
          <li class="dropdown messages-menu">
            <a href="?r=work-order/new" class="" >
              <i class="fa fa-plus"></i>&nbsp;
              Work Order
            </a>
          </li>
<?php /*
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>

          */ ?>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo Yii::$app->user->identity->username ; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo Yii::$app->user->identity->username ; ?> - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
          <?php /*
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              */ ?>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
          <?php /*
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  */ ?>
                </div>
                <div class="pull-right">
                  <?php
                    echo Html::beginForm(['/site/logout'], 'post',['id' => 'logout-form']) . '<a href="#" onclick="document.getElementById(\'logout-form\').submit(); return false;" class="btn btn-default btn-flat">Sign out</a>'. Html::endForm();
                  ?>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <?php /*
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          */ ?>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="text-transform: uppercase;"><?php echo Yii::$app->user->identity->username ; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <?php /*<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>*/ ?>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>

        <li class="<?php if ( $isDashboard ) { echo 'active'; }?>"><a href="?"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="<?php if ( $isWO ) { echo 'active'; }?>"><a href="?r=work-order"><i class="fa fa-wrench"></i> <span>Work Order</span></a></li>
        <li class="<?php if ( $isUP ) { echo 'active'; }?>"><a href="?r=uphostery"><i class="fa fa-wrench"></i> <span>Upholstery</span></a></li>
        <li class="<?php if ( $isQuotation ) { echo 'active'; }?>"><a href="?r=quotation"><i class="fa fa-quote-right"></i> <span>Quotation</span></a></li>
        <li class="<?php if ( $isDO ) { echo 'active'; }?>"><a href="?r=delivery-order"><i class="fa fa-truck"></i> <span>Delivery Order</span></a></li>

        <li class="treeview <?php if ( $isRfq || $isPO || $isGeneralPO || $isToolPO) { echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-plane"></i> <span>Documents</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if ( $isRfq ) { echo 'active'; }?>"><a href="?r=rfq"><i class="fa fa-circle-o"></i> Request for Quotation</a></li>
            <li class="<?php if ( $isPO ) { echo 'active'; }?>"><a href="?r=purchase-order"><i class="fa fa-circle-o"></i> Aviation Parts PO</a></li>
            <li class="<?php if ( $isToolPO ) { echo 'active'; }?>"><a href="?r=tool-po"><i class="fa fa-circle-o"></i> Tools PO</a></li>
            <li class="<?php if ( $isGeneralPO ) { echo 'active'; }?>"><a href="?r=general-po"><i class="fa fa-circle-o"></i> General PO</a></li>
          </ul>
        </li>

        <li class="treeview <?php if ( $isStock || $isInventoryReport || $isStockHistory || $isTool || $isPartCat || $isPart || $isPartImport || $isToolImport) { echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-plane"></i> <span>Stock Room</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">    
            <li class="<?php if ( $isTool ) { echo 'active'; }?>"><a href="?r=tool/tool"><i class="fa fa-circle-o"></i> Aviation Tools</a></li>
            <li class="<?php if ( $isStock ) { echo 'active'; }?>"><a href="?r=stock/stock"><i class="fa fa-circle-o"></i> Part</a></li>
            <li class="<?php if ( $isStockHistory ) { echo 'active'; }?>"><a href="?r=stock-history"><i class="fa fa-circle-o"></i> Stock history</a></li>
            <li class="<?php if ( $isInventoryReport ) { echo 'active'; }?>"><a href="?r=stock/inventory-report"><i class="fa fa-circle-o"></i> Inventory Report</a></li>
            <li class="<?php if ( $isPartCat ) { echo 'active'; }?>"><a href="?r=part-category"><i class="fa fa-circle-o"></i> Category</a></li>
            <li class="<?php if ( $isPart ) { echo 'active'; }?>"><a href="?r=part"><i class="fa fa-circle-o"></i> Aviation Parts</a></li>
            <li class="<?php if ( $isPartImport ) { echo 'active'; }?>"><a href="?r=part/import-excel"><i class="fa fa-circle-o"></i> Import Part Settings</a></li>
            <li class="<?php if ( $isStockImport ) { echo 'active'; }?>"><a href="?r=stock/import-excel"><i class="fa fa-circle-o"></i> Import Aviation Parts</a></li>
            <li class="<?php if ( $isToolImport ) { echo 'active'; }?>"><a href="?r=tool/import-excel"><i class="fa fa-circle-o"></i> Import Aviation Tools</a></li>
          </ul>
        </li>


        <li class="treeview <?php if ( $isCalibration || $isQuarantine || $isScrap || $isStaffnGroup || $isCapability ) { echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-check-square-o"></i> <span>Quality</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if ( $isARC ) { echo 'active'; }?>"><a href="?r=work-order-arc"><i class="fa fa-circle-o"></i> ARC Log</a></li>
            <li class="<?php if ( $isCalibration ) { echo 'active'; }?>"><a href="?r=calibration"><i class="fa fa-circle-o"></i> Calibration</a></li>
            <li class="<?php if ( $isQuarantine ) { echo 'active'; }?>"><a href="?r=quarantine"><i class="fa fa-circle-o"></i> Quarantine</a></li>
            <li class="<?php if ( $isScrap ) { echo 'active'; }?>"><a href="?r=scrap"><i class="fa fa-circle-o"></i> Scrap</a></li>
            <li class="<?php if ( $isCapability ) { echo 'active'; }?>"><a href="?r=capability"><i class="fa fa-circle-o"></i> Capability</a></li>
            <li class="<?php if ( $isStaffGroup ) { echo 'active'; }?>"><a href="?r=staff-group"><i class="fa fa-circle-o"></i> Staff Group</a></li>
            <li class="<?php if ( $isStaff ) { echo 'active'; }?>"><a href="?r=staff"><i class="fa fa-circle-o"></i> Staff</a></li>
            <li class="<?php if ( $isFinal ) { echo 'active'; }?>"><a href="?r=final-inspection"><i class="fa fa-circle-o"></i> Final Inspection Form</a></li>
          </ul>
        </li>

        <li class="<?php if ( $isSupplier ) { echo 'active'; }?>"><a href="?r=supplier"><i class="fa fa-cart-arrow-down"></i> <span>Supplier</span></a></li>

        <li class="<?php if ( $isGpoSupplier ) { echo 'active'; }?>"><a href="?r=gpo-supplier"><i class="fa fa-cart-arrow-down"></i> <span>GPO Supplier</span></a></li>
        <?php /* <li class="<?php if ( $isTpoSupplier ) { echo 'active'; }?>"><a href="?r=tpo-supplier"><i class="fa fa-cart-arrow-down"></i> <span>Tools Supplier</span></a></li> */ ?>

        <li class="<?php if ( $isTraveler ) { echo 'active'; }?>"><a href="?r=traveler"><i class="fa fa-file"></i> <span>Worksheet</span></a></li>

        <li class="<?php if ( $isTemplate ) { echo 'active'; }?>"><a href="?r=template"><i class="fa fa-clone"></i> <span>Template</span></a></li>

        <li class="<?php if ( $isCustomer ) { echo 'active'; }?>"><a href="?r=customer"><i class="fa fa-users"></i> <span>Customer</span></a></li>

        <li class="treeview <?php if ( $isUsernGroup ) { echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-user"></i> <span>User</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if ( $isUser ) { echo 'active'; }?>"><a href="?r=user"><i class="fa fa-circle-o"></i> User</a></li>
            <?php /*<li class="<?php if ( $isUserGroup ) { echo 'active'; }?>"><a href="?r=user-group"><i class="fa fa-circle-o"></i> User Group</a></li>*/ ?>
            <li class="<?php if ( $isPermission ) { echo 'active'; }?>"><a href="?r=user-permission/permission-setting"><i class="fa fa-circle-o"></i> User Permission</a></li>
          </ul>
        </li>

        <li class="treeview <?php if ( $isCurrency || $isSetting || $isStorage || $isUnit ) { echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-cog"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if ( $isCurrency ) { echo 'active'; }?>"><a href="?r=currency"><i class="fa fa-circle-o"></i> Currency</a></li>
            <li class="<?php if ( $isSetting ) { echo 'active'; }?>"><a href="?r=setting"><i class="fa fa-circle-o"></i> Setting</a></li>
            <li class="<?php if ( $isStorage ) { echo 'active'; }?>"><a href="?r=storage-location"><i class="fa fa-circle-o"></i> Store</a></li>
            <li class="<?php if ( $isUnit ) { echo 'active'; }?>"><a href="?r=unit"><i class="fa fa-circle-o"></i> Unit Measurement</a></li>
          </ul>
        </li>
        <?php /*
          <li><a href="?r=gii" target="_blank"><i class="fa fa-book"></i> <span>Gii</span></a></li>
          <li class="header">LABELS</li>
          <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
          <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
          <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
          */ ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <script type="text/javascript">
    var formHasChanged = false;
    var submitted = false;
    function confi() {
      window.onbeforeunload = function () {
        if (formHasChanged && !submitted) {
          return 'Are you sure you want to leave?';
        }
      };
    }
  </script>
    <div class="content-wrapper">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
            <?= Alert::widget() ?>
        <?= $content ?>
    </div>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Powered by <b>Firstcom Solutions</b>
    </div>
    <strong>Copyright &copy; <?= date('Y') ?> <a href="http://aeroindustries.com.sg">Aero Industries</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript:void(0)">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <i class="menu-icon fa fa-user bg-yellow"></i>

                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>

                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript:void(0)">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>

                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>

                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>

                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>

                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul>
            <!-- /.control-sidebar-menu -->

          </div>
          <!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
          <!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>

                <p>
                  Some information about this general settings option
                </p>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>

                <p>
                  Other sets of options are available
                </p>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>

                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div>
              <!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div>
              <!-- /.form-group -->
            </form>
          </div>
          <!-- /.tab-pane -->
        </div>
      </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>


<!-- jQuery 2.2.0 -->
<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->



<?php $this->endBody() ?>
  <script>
    //$.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.6 -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <!-- Morris.js charts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <!-- <script src="plugins/morris/morris.min.js"></script> -->
  <!-- Sparkline -->
  <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/knob/jquery.knob.js"></script>
  <!-- daterangepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- timepicker -->
  <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <!-- datepicker -->
  <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="dist/js/pages/dashboard.js"></script> -->
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Select2 -->
  <script src="plugins/select2/select2.full.min.js"></script>
  <!-- Notify JS -->
  <script src="js/notify.min.js"></script>

  <script src="js/custom.js"></script>
  <script src="js/custom-uphostery.js"></script>

<script>
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });

    $('.sidebar-toggle').click(function(){
      //set cookie
      var n = 0;
            $.post("?r=site/toggle-sidebar",{
                n:n
            },
            function(data, status){
                console.log(data);
            });
    });
    // confirmation upon leaving page
    // $(document).on('change', 'form', function (e) {
    //     formHasChanged = true;
    // });
    // $("form").submit(function() {
    //   submitted = true;
    // });
</script>
</body>
</html>
<?php $this->endPage() ?>
