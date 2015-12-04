<?php
@session_start();
if(isset($_POST) && !empty($_POST) &&  isset($_GET['step']) && $_GET['step']!="" && is_numeric($_GET['step']) && $_GET['step']>=1 && $_GET['step']<=3)
{
	/*BEGIN DATABASE SETUP */
	if($_GET['step']=="1")
	{
		if($_POST['hostname']!="" && $_POST['dbusername']!="" && $_POST['databasename']!="" && $_POST['secretkey']!="")
		{
			$check_db = @mysql_connect($_POST['hostname'],$_POST['dbusername'],$_POST['dbpassword']);
			if($check_db)
			{
				$config_content = file_get_contents("install.config.php");
				$key_array = array("{MYSQL_HOST_NAME}","{MYSQL_DB_USERNAME}","{MYSQL_DB_PASSWORD}","{MYSQL_DB_NAME}","{SECRET_KEY}","{TABLE_PREFIX}");
				$value_array = array($_POST['hostname'],$_POST['dbusername'],$_POST['dbpassword'],$_POST['databasename'],$_POST['secretkey'],$_POST['tableprefix']);
				$config_content = str_replace($key_array, $value_array, $config_content);
				$config_setup = file_put_contents("../config.php",$config_content);

				if($config_setup>0)
				{
					mysql_connect($_POST['hostname'],$_POST['dbusername'],$_POST['dbpassword']) or die(mysql_error());
					mysql_select_db($_POST['databasename']) or die(mysql_error());
					$query_separator = "-- --------------------------------------------------------";
					$query_content = explode($query_separator,file_get_contents("database.setup.sql"));

					foreach ($query_content as $query) {
						$query = str_replace('bh_', $_POST['tableprefix'], $query);
						mysql_query($query) or die(mysql_error());
					}
					echo "<div class='row'><div class='alert alert-success col-md-4 col-md-offset-4'>Database has been set up successfully.</div></div>";
					exit;
				}
				else
				{
					echo "<div class='row'><div class='alert alert-danger col-md-4 col-md-offset-4'>Error Occured. Please check the database details.</div></div>";
					echo "<script>window.location='index.php';</script>";
					exit;
				}
			}
			else
			{
				$_SESSION['message'] = "<div class='row'><div class='alert alert-danger col-md-4 col-md-offset-4'>Database Connection Failed. Please check your database details.</div></div>";
				exit;
			}
		}
	}
	/*END DATABASE SETUP */

	/*BEGIN SITE SETUP */
	if($_GET['step']=="2")
	{
		if(isset($_POST['site_title']) && $_POST['site_title']!="" && isset($_POST['site_email']) && $_POST['site_email']!="")
		{
			@include("../class/Main.class.php");	
			$Main = new Main();

			$info_array = array("site_title"=>$_POST['site_title'],"site_email"=>$_POST['site_email']); 
			$where = "";
			$updated=$Main->UpdateRecord("site_settings",$info_array,$where);
			if($updated>0)
			{
				echo "<div class='row'><div class='alert alert-success col-md-4 col-md-offset-4'>Site Settings has been updated successfully.</div></div>";
				exit;
			}
			else
			{
				echo "<div class='row'><div class='alert alert-danger col-md-4 col-md-offset-4'>Error Occured. Please check the database.</div></div>";
				exit;
			}
		}
	}
	/*END SITE SETUP */

	/*BEGIN ADMIN ACCOUNT SETUP */
	if($_GET['step']=="3")
	{
		if($_POST['firstname']!="" && $_POST['lastname']!="" && $_POST['email']!="" && $_POST['password']!="")
		{
			@include("../class/Main.class.php");	
			$Main = new Main();

			$string=SECRET_KEY.$_POST['password'];
			$_POST['password'] = sha1($string);
			$_POST['active_status']=1;
			$_POST['user_type']=1;
			$_POST['register_date']=date("Y-m-d H:i:s");
			$_POST['register_ipaddress']=$_SERVER['REMOTE_ADDR'];
			
			$last_id=$Main->InsertRecord("user_master",$_POST);
			if($last_id>0)
			{
				echo "<div class='row'><div class='alert alert-success col-md-4 col-md-offset-4'>Installation has been completed successfully.</div></div><br>";
				echo "<div class='row'><h4 class='col-md-offset-4'>Your Site Details :</h4></div>"; 
				echo "<div class='row'>
						<div class='col-md-2 col-md-offset-4'><b>Site Title :</b> </div>
						<div class='col-md-4'>".SITE_TITLE."</div>
					</div>";
				echo "<div class='row'>
						<div class='col-md-2 col-md-offset-4'><b>Site URL :</b> </div>
						<div class='col-md-4'><a href='".SITE_URL."' target='_blank'>".SITE_URL."</a></div>
					</div>";
				echo "<div class='row'>
						<div class='col-md-2 col-md-offset-4'><b>Admin Panel URL :</b> </div>
						<div class='col-md-4'><a href='".ADMIN_URL."' target='_blank'>".ADMIN_URL."</a></div>
					</div>";
				echo "<div class='row'>
						<div class='col-md-2 col-md-offset-4'><b>Admin Email :</b> </div>
						<div class='col-md-4'>".$_POST['email']."</div>
					</div>";
				echo "<div class='row'>
						<div class='col-md-2 col-md-offset-4'><b>Admin Password :</b> </div>
						<div class='col-md-4'><i>********</i></div>
					</div>";
				echo "<br>";
				echo "<div class='row'><div class='alert alert-info col-md-4 col-md-offset-4'>Please Remove the install directory.</div></div>";
				
			}
			else
			{
				echo "<div class='row'><div class='alert alert-danger col-md-4 col-md-offset-4'>Error Occured. Please check the database.</div></div>";
				exit;
			}
		}
	}
	/*END ADMIN ACCOUNT SETUP */
}
?>