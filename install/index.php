<?php @session_start(); 

/*CHECK FOR THE INSTALLAION EXISTS*/
if(file_exists("../config.php"))
{
    header("location:../index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Installation</title>
        <meta charset="utf-8">
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <h2 style="color:#fff;">Installation</h2> 
            </div>
        </div>
    </nav>
    <?php if(isset($_SESSION['message'])) echo $_SESSION['message'];unset($_SESSION['message']); ?>
    <!-- BEGIN DATABASE SET UP -->
    <div class="container" id="step-1">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Database Setup</div>
                <div class="panel-body">
                    <form method="post" role="form" id="database-setup-form">
                        <div class="form-group">
                            <label>Host Name :</label>
                            <input type="text" class="form-control" name="hostname" value="" title="Please Enter Hostname" placeholder="localhost">
                        </div>
                        <div class="form-group">
                            <label>Database Name :</label>
                            <input type="text" class="form-control" name="databasename" value="" title="Please Enter Database Name" placeholder="bharatcode">
                        </div>
                        <div class="form-group">
                            <label>Database Username :</label>
                            <input type="text" class="form-control" name="dbusername" value="" title="Please Enter Database User Name" placeholder="root">
                        </div>
                        <div class="form-group">
                            <label>Database Password :</label>
                            <input type="password" class="form-control" name="dbpassword" value="" placeholder="12345">
                            <input type="checkbox" class="show_password"> Show Password
                        </div>
                        <div class="form-group">
                            <label>Table Prefix :</label>
                            <input type="text" class="form-control" name="tableprefix" value="" placeholder="bh_">
                            <small class="label label-info">Leave Blank if you do not want to set Table Prefix.</small>
                        </div>
                        <div class="form-group">
                            <label>Secret Key :</label>
                            <input type="password" class="form-control" name="secretkey" value="" title="Please Enter Secret Key" placeholder="AbC12d3E45f">
                            <input type="checkbox" class="show_password"> Show Secret Key
                            <small class="label label-info">This will be used for the Password Encryption.</small>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" id="database-setup" class="btn btn-primary" name="submit_step1" value="Next">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END DATABASE SET UP -->

    <!-- BEGIN SITE DATA SET UP -->
    <div class="container hide" id="step-2">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Site Settings</div>
                <div class="panel-body">
                    <form method="post" role="form" enctype="multipart/form-data" id="site-setup-form">
                        <div class="form-group">
                            <label>Site Title :</label>
                            <input type="text" class="form-control alpha" name="site_title" value="" title="Please Enter Site Title" placeholder="My First Site">
                        </div>
                        <div class="form-group">
                            <label>Site Email :</label>
                            <input type="text" class="form-control email" name="site_email" value="" title="Please Enter Site Email" placeholder="info@domain.com">
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" id="site-setup" class="btn btn-primary" name="submit_step2" value="Next">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END SITE DATA SET UP -->

    <!-- BEGIN ADMIN ACCOUNT SET UP -->
    <div class="container hide" id="step-3">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Admin Account Setup</div>
                <div class="panel-body">
                    <form method="post" role="form" id="admin-setup-form">
                        <div class="form-group">
                            <label>Admin First Name :</label>
                            <input type="text" class="form-control alpha" name="firstname" value="" title="Please Enter Admin First Name" placeholder="Admin">
                        </div>
                        <div class="form-group">
                            <label>Admin Last Name :</label>
                            <input type="text" class="form-control alpha" name="lastname" value="" title="Please Enter Admin Last Name" placeholder="Master">
                        </div>
                        <div class="form-group">
                            <label>Admin Email (Username) :</label>
                            <input type="text" class="form-control email" name="email" value="" title="Please Enter Admin Email" placeholder="admin@domain.com">
                        </div>
                        <div class="form-group">
                            <label>Admin Password :</label>
                            <input type="password" class="form-control" name="password" value="" title="Please Enter Admin Password" placeholder="12345">
                            <input type="checkbox" class="show_password"> Show Password
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" id="admin-setup" class="btn btn-primary" name="submit_step3" value="Next">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END ADMIN ACCOUNT SET UP -->

    <!-- BEGIN SUCCESS INSTALLATION -->
    <div class="container hide" id="step-4">
    </div>
    <!-- END SUCCESS INSTALLATION -->

    <footer class="container-fluid">
        <hr>
        <p class="text-center">
            &copy; <?php echo date("Y");?> 
            Developed By : <b><a target="_blank" href="http://www.facebook.com/bharat383">Bharat Parmar </a></b>
        </p>
    </footer>

        <!-- BEGIN JAVASCRIPT ATTACH -->
            <script src="../js/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="js/install.jquery.js"></script>
        <!-- END JAVASCRIPT ATTACH -->

    </body>
</html>