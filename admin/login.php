<?php 
@session_start();
@include("../config.php");
@include("class/Admin.class.php");
$Admin = new Admin();
?>
<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title><?php echo SITE_TITLE;?> : Admin Login</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

    <script src="lib/jquery-1.11.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/premium.css">
</head>
<body class=" theme-blue">

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
            <a class="" href="<?php echo ADMIN_URL."/index.php"; ?>">
                <?php if(file_exists(SITE_URL.'/images/'.$Admin->sitedata['logo_image'])) { ?>
                    <img src="<?php echo SITE_URL.'/images/'.$Admin->sitedata['logo_image'];?>">
                <?php } ?>
            <span class="navbar-brand"><?php echo SITE_TITLE;?></span>
            </a>
        </div>
        <div class="navbar-collapse collapse" style="height: 1px;"></div>
    </div>

    <div class="dialog">
        <div class="panel panel-default">
            <p class="panel-heading no-collapse">Admin Login</p>
            <?php $Admin->DisplayAdminmessage(); ?>
            <div class="panel-body">
                <form method="POST">
                    <?php if (!isset($_GET['action']) || @$_GET['action']!="forgotpassword") { ?>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" id="email" class="form-control email" value="<?php echo @$Admin->data['email'];?>" title="Please Enter Username">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control" value="<?php echo @$Admin->data['password']; ?>" title="Please Enter Password">
                            <input type="checkbox" class="show_password"> Show Password
                        </div>
                        <input type="submit" name="submit_login" id="submit_login" class="btn btn-primary pull-right" value="Login">
                        <div class="clearfix"></div>
                    <?php } ?>

                    <?php if (isset($_GET['action']) && $_GET['action']=="forgotpassword") { ?>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" id="email" class="form-control email" value="<?php echo @($Admin->data['']);?>" title="Please Enter Email">
                        </div>
                        <input type="submit" name="submit_forgetpassword" id="submit_forgetpassword" class="btn btn-primary pull-right" value="Submit">
                        <div class="clearfix"></div>
                    <?php } ?>                
                </form>
            </div>
        </div>
        <p class="pull-right" style="">
            <a href="<?php echo SITE_URL; ?>" target="blank" style="font-size: .75em; margin-top: .25em;"><?php echo SITE_TITLE;?></a>
        </p>
        <p><a href="login.php?action=forgotpassword">Forgot your password?</a></p>
    </div>

    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="lib/jquery.alphanum.js" type="text/javascript" ></script>
    <script src="lib/admin.customjquery.js" type="text/javascript" ></script>
</body>
</html>
