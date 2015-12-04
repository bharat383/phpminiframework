<?php
@session_start();
@include("../config.php");
?>
<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title><?php echo SITE_TITLE;?> : <?php echo $Admin->pagetitle;?></title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'> -->
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">
    <!--<link href="lib/datepicker/css/bootstrap-datetimepicker.min.css?123" rel="stylesheet" media="screen">-->

    <script src="lib/jquery-1.11.1.min.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/premium.css">

    <!-- BEGIN CKEDITOR PLUGIN FILES  -->
    <script src="../ckeditor/ckeditor.js"></script>
    <script src="../ckeditor/js/sample.js"></script>
    <!--<link rel="stylesheet" href="../ckeditor/css/samples.css">-->
    <link rel="stylesheet" href="../ckeditor/toolbarconfigurator/lib/codemirror/neo.css">
    <!-- END CKEDITOR PLUGIN FILES  -->

</head>
<body class="theme-blue">

    <script type="text/javascript">
        $(function() {
            var uls = $('.sidebar-nav > ul > *').clone();
            uls.addClass('visible-xs');
            $('#main-menu').append(uls.clone());
        });
    </script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo SITE_URL; ?>/favicon.ico">

  

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
   
  <!--<![endif]-->

    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="" href="<?php echo ADMIN_URL."/index.php"; ?>"><span class="navbar-brand"><?php echo SITE_TITLE;?></span></a></div>

        <div class="navbar-collapse collapse" style="height: 1px;">
            <ul id="main-menu" class="nav navbar-nav navbar-right">
                <li class="dropdown hidden-xs">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user padding-right-small" style="position:relative;top: 3px;"></span> <?php echo $_SESSION['admin_fullname'];?>
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="admin.php">My Account</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo $_SERVER['PHP_SELF']."?action=logout";?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-nav">
        <ul>
            <li <?php if($Admin->pagefilename=="index.php") {echo "class='active'";} ?>><a href="index.php" class="nav-header" ><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
            <li <?php if($Admin->pagefilename=="settings.php") {echo "class='active'";} ?>><a href="settings.php" class="nav-header" ><i class="fa fa-fw fa-wrench"></i> Site Settings</a></li>
            <li><a href="javascript:void()" data-target=".cms-menu" class="nav-header collapsed" data-toggle="collapse"><i class="fa fa-fw fa-file-text"></i> CMS<i class="fa fa-collapse"></i></a></li>
            <li>
                <?php $cmspage_array = array("cmshomepage.php","cmssearchpage.php","cmsdetailviewpage.php","cmswebpages.php","emailtemplate.php"); ?>
                <ul class="cms-menu nav nav-list collapse <?php if(in_array($Admin->pagefilename, $cmspage_array)) {echo " in";} ?>">
                    <?php /* ?><li <?php if($Admin->pagefilename=="cmshomepage.php") {echo "class='active'";} ?>><a href="cmshomepage.php"><span class="fa fa-fw fa-home"></span> Home Page</a></li><?php */ ?>
                    <li <?php if($Admin->pagefilename=="cmswebpages.php") {echo "class='active'";} ?>><a href="cmswebpages.php"><span class="fa fa-fw fa-file-code-o"></span> Web Pages</a></li>
                    <li <?php if($Admin->pagefilename=="emailtemplate.php") {echo "class='active'";} ?>><a href="emailtemplate.php"><span class="fa fa-envelope-o"></span> Email Templates</a></li>
                </ul>
            </li>
            <li <?php if($Admin->pagefilename=="manageuser.php") {echo "class='active'";} ?>><a href="manageuser.php" class="nav-header" ><i class="fa fa-fw fa-users"></i> User Management</a></li>
            <li <?php if($Admin->pagefilename=="contactmessages.php") {echo "class='active'";} ?>><a href="contactmessages.php" class="nav-header" ><i class="fa fa-fw fa-envelope"></i> Contact Messages</a></li>
            <li <?php if($Admin->pagefilename=="database.php") {echo "class='active'";} ?>><a href="database.php" class="nav-header" ><i class="fa fa-fw fa-database"></i> Manage Database</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h1 class="page-title">
                <?php echo $Admin->pagetitle;?>
            </h1>
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a> </li>
                <li class="active"><?php echo $Admin->pagetitle;?></li>
            </ul>
        </div>
        <div class="main-content">
        <?php $Admin->DisplayAdminMessage(); ?>