<?php

/*
FILE NAME : Admin.class.php
LOCAITON : admin/class/Admin.class.php
FILE DETAILS : Admin Class. Includes Admin Login,Logout, Forgot Password, Admin Profile Update and Site Settings.
Extends : Main.class.php => ../../class/Main.class.php
*/

@include("../class/Main.class.php");
class Admin extends Main
{
	public function __construct()
	{
		parent::__construct();

		/*BEGIN ADMIN FUNCTIONS CODE*/
			//ADMIN LOGOUT	
			if(isset($_POST['submit_login']))
			{
				$this->AdminLogin();
			}

			//CHECK ADMIN LOGIN 
			if(@basename($_SERVER['PHP_SELF'])!="login.php")
			{
				$this->CheckAdminLogin();
			}

			//ADMIN LOGOUT	
			if(isset($_GET['action']) && $_GET['action']=="logout")
			{
				$this->AdminLogOut();
			}

			//ADMIN FORGOT PASSWORD
			if(isset($_POST['submit_forgetpassword']))
			{
				$this->AdminForgotPassword();
			}

			//ADMIN PROFILE UPDATE
			if($this->pagefilename=="admin.php")
			{
				$info_array = array("where"=>"user_type='1' and user_id='1'");
				$this->data = $this->GetSingleRecord("user_master",$info_array);
			}
			if(isset($_POST['submit_profile']))
			{
				$this->AdminProfile();
			}
		/*END ADMIN FUNCTIONS CODE*/
		/*BEGIN SITE SETTING FUNCTION ASSIGN */
			if(isset($_POST['submit_settings']))
			{
				$this->UpdateSiteSettings();
			}	
		/*CODE SITE SETTING FUNCTION ASSIGN */
		
	}

	/*BEGIN ADMIN CONTROL FUNCTIONS CODE*/

		/*BEGIN ADMIN LOGIN FUNCTION */
		private function AdminLogin()
		{
			if(empty($_POST['email']))
			{
				$_SESSION['admin_response'][] = array("status"=>"warning","message"=>"Please Enter Username."); 	
			}
			
			if(empty($_POST['password']))
			{
				$_SESSION['admin_response'][] = array("status"=>"warning","message"=>"Please Enter Password."); 	
			}

			if(empty($_SESSION['admin_response']))
			{
				$admin_username = mysql_real_escape_string($_POST['email']);
				$admin_password = mysql_real_escape_string($_POST['password']);

				$info_array = array(
							"where"=>"email = '".$admin_username."' and active_status='1' and user_type='1' "
								);
				$record = $this->GetSingleRecord("user_master",$info_array);

				if(count($record)>0)
				{
					if($record['password']==$this->MakePassword($admin_password))
					{
						$_SESSION['admin_login']=1;
						$_SESSION['admin_id']=$record['user_id'];
						$_SESSION['admin_fullname']=$record['firstname']." ".$record['lastname'];	
						$_SESSION['admin_email']=$record['email'];
						$_SESSION['user_type']=$record['user_type'];

						$_SESSION['admin_response'] = array("status"=>"success","message"=>"Logged in Successfully."); 
						$this->RedirectPage(ADMIN_URL."/index.php");
					}
					else
					{
						$_SESSION['admin_response'] = array("status"=>"error","message"=>"Incorrect Password."); 		
					}
				}
				else
				{
					$_SESSION['admin_response'] = array("status"=>"error","message"=>"Incorrect Username."); 
				}
				$this->data = $_POST;
			}
		}
		/*END ADMIN LOGIN FUNCTION : AdminLogin()*/

		/*BEGIN CHECK ADMIN LOGIN FUNCTION */
		public function CheckAdminLogin()
		{
			if(!isset($_SESSION['admin_login']) || !isset($_SESSION['admin_id']))
			{
				$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Please login first to access the Admin Panel."); 
				$this->RedirectPage(ADMIN_URL."/login.php");
			}
		}
		/*END CHECK ADMIN LOGIN FUNCTION : CheckAdminLogin() */

		/*BEGIN ADMIN LOGOUT FUNCTION */
		public function AdminLogOut()
		{
			@session_destroy();
			$this->RedirectPage(ADMIN_URL."/login.php");
		}
		/*BEGIN ADMIN LOGOUT FUNCTION : AdminLogOut()*/

		/*BEGIN ADMIN FORGOT PASSWORD FUNCTION */
		public function AdminForgotPassword()
		{
			$email = mysql_real_escape_string($_POST['admin_email']);
			
			$info_array = array("where"=>"email='".$email."' and active_status='1' and user_type = '1'");
			$userdata = $this->GetRecord("user_master",$info_array);
			
			if(count($userdata)>0)
			{
				$newpassword = $this->MakePassword($this->GetRandomString(8));
				$info_array = array("password"=>$newpassword);

				$where = " user_id='".$userdata['user_id']."' and user_type='1' and active_status='1' ";
				$update = $this->UpdateRecord("user_master",$info_array,$where);

				/*BEGIN SEND MAIL CODE FOR : FORGOT PASSWORD MAIL*/	

					$info_array = array("where"=>" template_id='2'");
					$mail_template = $this->GetRecord("email_template",$info_array);

					if($mail_template['active_status']==1)
					{
						$tag_array = array("{UserId}","{Email}","{Password}","{FirstName}","{LastName}");
						$str_array = array($userdata['user_id'],$userdata['admin_email'],$newpassword,$userdata['first_name'],$userdata['last_name']);

						$mail_subject = str_replace($tag_array, $str_array, $mail_template['subject']);		
						$mail_message = str_replace($tag_array, $str_array, $mail_template['message']);	

						$this->SendMail($userdata['email'],$mail_subject,$mail_message);
					}
				/*END SEND MAIL CODE FOR : FORGOT PASSWORD MAIL*/		

				$_SESSION['admin_response']=array("status"=>"success","message"=>"Your Account Details has been sent to your Email Address (".$email.") successfully. Please check Your Mail.");		
				$this->RedirectPage(ADMIN_URL."/login.php");
			}
			else
			{
				$_SESSION['admin_response']=array("status"=>"error","message"=>"This Email Address is not registered. Please check your email address : ".$email);		
				$this->RedirectPage(ADMIN_URL."/login.php");
			}
		}
		/*END ADMIN FORGOT PASSWORD FUNCTION : AdminForgotPassword() */

		/*BEGIN ADMIN PROFILE UPDATE FUNCTION */
		public function AdminProfile()
		{
			$info_array = array(
						"firstname"=>addslashes($_POST['firstname']),
						"lastname"=>addslashes($_POST['lastname']),
						"email"=>addslashes($_POST['email'])
						);

			if($_POST['password']!="" && $_POST['password']!=$_POST['confirm_password'])
			{
				$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Password does not match. Please Enter same password.");
			}
			else
			{
				if($_POST['password']!="")
				{
					$info_array['password']=$this->MakePassword($_POST['password']);
				}

				$where = " user_type='1' and user_id='".$_SESSION['admin_id']."'";
				$record = $this->UpdateRecord("user_master",$info_array,$where);

				$_SESSION['admin_fullname']=$_POST['firstname']." ".$_POST['lastname'];	
				$_SESSION['admin_response'] = array("status"=>"success","message"=>"Admin Details has been updated successfully.");
				$this->RedirectPage(ADMIN_URL."/admin.php");
			}
			$this->data = $_POST;
		}
		/*END ADMIN PROFILE UPDATE FUNCTION : AdminProfile()*/

	/*END ADMIN CONTROL FUNCTIONS CODE*/

	/*BEGIN SITE SETTING FUNCTION CODE */
	private function UpdateSiteSettings()
	{
		array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
		
		@$_POST['smtp_password'] = base64_encode($_POST['smtp_password']);

		if(@$_FILES['logo_image']['name']!="")
		{
			$filesetting = array(
					"filetype"=>array("jpg","png","gif","jpeg","bmp"),
					"uploadpath"=>"../images/",
					"maxsize"=>1000
					);


			 $filename= $this->UploadFile($_FILES['logo_image'],$filesetting);
			 if($filename[0]!="")
			 {
			 	$_POST['logo_image'] = $filename[0];
			 	$filesetting = array(
										"uploadpath"=>"../images/",
										"files"=>$this->sitedata['logo_image']
									);
			 	$this->DeleteFile($filesetting);
			 }
		}

		$where = " id='1'";
		$update = $this->UpdateRecord("site_settings",$_POST,$where);
		if($update>0)	
		{
			$_SESSION['admin_response'] = array("status"=>"success","message"=>"Site Settings has been udpated successfully.");	
		}
		$this->RedirectPage($this->pagefilename);
	}
	/*END SITE SETTING FUNCTION CODE */

	public function DisplayAdminMessage()
	{
		$message_class_array = array(
								"info"=>"alert alert-info",
								"warning"=>"alert alert-warning",
								"error"=>"alert alert-danger",
								"success"=>"alert alert-success"
								);
		
		if(isset($_SESSION['admin_response']) && !empty($_SESSION['admin_response']))
		{
			if(count($_SESSION['admin_response']) == count($_SESSION['admin_response'], COUNT_RECURSIVE))//ARRAY IS SINGLE DIMENSION ARRAY
			{	
				echo '<div class="'.$message_class_array[$_SESSION['admin_response']['status']].'">'.stripslashes($_SESSION['admin_response']['message']).'</div>';
			}
			else //IF ARRAY IS MULTI DIMENSION ARRAY
			{
				foreach ($_SESSION['admin_response'] as $key => $value) {
					echo '<div class="'.$message_class_array[$value['status']].'">'.stripslashes($value['message']).'</div>';
				}
			}
		}
		unset($_SESSION['admin_response']);
	}

}

?>