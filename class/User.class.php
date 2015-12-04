<?php

/*
FILE NAME : User.class.php
LOCAITON : class/User.class.php
FILE DETAILS : User Class. Includes User Register, Login, Forget Password, Profile, Logout
Extends : Frontend.class.php => class/Frontend.class.php
*/

@include("Frontend.class.php");
class User extends Frontend
{
	public function __construct()
	{
		parent::__construct();

		/*BEGIN USER REGISTER FUNCTION ASSIGN*/
		if(isset($_POST['submit_register']))
		{
			$this->UserRegister();
		}
		/*END USER REGISTER FUNCTION ASSIGN*/

		/*BEGIN FORGOT PASSWORD FUNCTION ASSIGN*/
		if(isset($_POST['submit_forgot']))
		{
			$this->UserForgetPassword();
		}
		/*END FORGOT PASSWORD FUNCTION ASSIGN*/

		/*BEGIN USER LOGIN ASSIGN*/
		if(isset($_POST['submit_login']))
		{
			$this->UserLogin();
		}
		/*END USER LOGIN ASSIGN*/

		/*BEGIN USER LOGIN CHECK ASSIGN*/
		$this->CheckUserLogin();
		/*END USER LOGIN CHECK ASSIGN*/

		/*BEGIN USER PROFILE FUNCTION ASSIGN*/
		if(isset($_POST['submit_profile']))
		{
			$this->UserProfile();
		}
		/*END USER PROFILE FUNCTION ASSIGN*/

		/*BEGIN CHANGE PASSWORD FUNCTION ASSIGN*/
		if(isset($_POST['submit_changepassword']))
		{
			$this->ChangePassword();
		}
		/*END CHANGE PASSWORD FUNCTION ASSIGN*/

		/*BEGIN USER LOGOUT ASSIGN*/
		if(isset($_GET['logout']))
		{
			$this->Logout();
		}
		/*END USER LOGOUT ASSIGN*/

	}
	
	protected function UserRegister()
	{
		if(!$this->validate($_POST['firstname'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter First Name"); 	
		}
		else if(!$this->validate($_POST['firstname'],"alpha"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please First Name Should have only Alphabets"); 	
		}

		if(!$this->validate($_POST['lastname'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Last Name"); 	
		}
		else if(!$this->validate($_POST['lastname'],"alpha"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Last Name Should have only Alphabets"); 	
		}

		if(!$this->validate($_POST['email'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Email Address."); 	
		}
		else if(!$this->validate($_POST['email'],"email"))
		{
		  $_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Valid Email Address."); 	
		}
		
		if(!$this->validate($_POST['password'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Password"); 	
		}
		if(!$this->validate($_POST['confirm_password'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Confirm Password"); 	
		}
		if($_POST['confirm_password']!=$_POST['password'])
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Confirm Password does not match."); 	
		}
		
		if(empty($_SESSION['response']))
		{
			$info_array = array("fields"=>"user_id","where"=>"email like '".addslashes($_POST['email'])."'");
			$existuser = $this->GetSingleRecord("user_master",$info_array);

			if(!empty($existuser))
			{
				$_SESSION['response'] = array("status"=>"error","message"=>"Email is already used."); 				
			}	
			else
			{	
				array_splice($_POST, -2);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
				$info_array = $_POST;
				$info_array['user_type']=0;
				$info_array['active_status']=1;
				$info_array['register_date']=date("Y-m-d H:i:s");
				$info_array['register_ipaddress']=$_SERVER['REMOTE_ADDR'];

				$verification_code = $this->GetRandomString(6);
				$info_array['password']=$this->MakePassword($info_array['password']);
				$info_array['verify_code'] = $verification_code;

				$userid = $this->InsertRecord("user_master",$info_array);

				$_SESSION['user_id']=$userid;
				$_SESSION['user_type']=$info_array['user_type'];
				$_SESSION['user_fullname']=$info_array['firstname']." ".$info_array['lastname'];
				$_SESSION['user_email']=$info_array['email'];

				$tag_array = array("{UserId}","{FirstName}","{LastName}","{Email}","{Password}","{IpAddress}","{VerificationCode}");
				$str_array = array($userid,$info_array['firstname'],$info_array['lastname'],$info_array['email'],$_POST['password'],$_SERVER['REMOTE_ADDR'],$verification_code);

				$info_array = array("where"=>"template_id='1'");
				$mail_template = $this->GetSingleRecord("email_template",$info_array);

				if($mail_template['active_status']==1)
				{
					$mail_subject = str_replace($tag_array, $str_array, $mail_template['subject']);		
					$mail_message = str_replace($tag_array, $str_array, $mail_template['message']);	

					$this->SendMail($_SESSION['user_email'],$mail_subject,$mail_message);
				}

				$_SESSION['response'] = array("status"=>"success","message"=>"Your Account has been created successfully.");
				$this->RedirectPage(USER_URL."/profile.php");
			}
		}
		$this->data = $_POST;

	}

	protected function UserForgetPassword()
	{
		if(!$this->validate($_POST['email'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Email Address."); 	
		}
		if(!$this->validate($_POST['email'],"email"))
		{
		  	$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Valid Email Address."); 	
		}
		
		if(empty($_SESSION['response']))
		{
			$email = mysql_real_escape_string($_POST['email']);

			$info_array = array("where"=>"email='".$email."' and active_status='1' and user_type != '1'");
			$userdata = $this->GetSingleRecord("user_master");
			
			if(count($userdata)>0)
			{
				$newpassword = $this->MakePassword($this->GetRandomString(8));

				$info_array = array("password"=>$newpassword);
				$where = " user_id='".$userdata['user_id']."' and user_type!='1' and active_status='1'";
				$update = $this->UpdateRecord("user_master",$info_array,$where);

				/*BEGIN SEND MAIL CODE FOR : FORGOT PASSWORD MAIL*/	

					$info_array = array("where"=>" template_id='2'");
					$mail_template = $this->GetSingleRecord("email_template",$info_array);

					if($mail_template['active_status']==1)
					{
						$tag_array = array("{UserId}","{Email}","{Password}","{FirstName}","{LastName}");
						$str_array = array($userdata['admin_id'],$userdata['admin_email'],$newpassword,$userdata['first_name'],$userdata['last_name']);

						$mail_subject = str_replace($tag_array, $str_array, $mail_template['subject']);		
						$mail_message = str_replace($tag_array, $str_array, $mail_template['message']);	

						$this->SendMail($userdata['email'],$mail_subject,$mail_message);
					}
				/*END SEND MAIL CODE FOR : FORGOT PASSWORD MAIL*/		

				$_SESSION['response'][] = array("status"=>"success","message"=>"Your Account Details has been sent to your Email Address (".$email.") successfully. Please check Your Mail."); 	
				$this->RedirectPage(SITE_URL."/login.php");
			}
			else
			{
				$_SESSION['response'][]=array("status"=>"error","message"=>"This Email Address is not registered. Please check your email address : ".$email);		
			}
		}
		$this->data = $_POST;
	}

	protected function UserLogin()
	{
		
		if(!$this->validate($_POST['email'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Email Address."); 	
		}
		else if(!$this->validate($_POST['email'],"email"))
		{
		  	$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Valid Email Address."); 	
		}
		if(!$this->validate($_POST['password'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Password"); 
		}
		
		if(empty($_SESSION['response']))
		{
			$email = mysql_real_escape_string($_POST['email']);
			$password = mysql_real_escape_string($_POST['password']);

			$info_array = array(
					"fields"=>"user_id, email, user_type, password, firstname, lastname, active_status, verify_status",
					"where"=>" email='".$email."' and user_type != '1'"
					);
		
			$userdata = $this->GetSingleRecord("user_master",$info_array);	

			if(!empty($userdata))
			{
				if($userdata['active_status']=="1")
				{
					if($userdata['verify_status']=="0" && $this->sitedata['enable_account_verify']==1)
					{
						$_SESSION['response'] = array("status"=>"warning","message"=>"Your Account is not verified. Please Check Your Email for the Verification Code");
					}
					else
					{	
						if($userdata['password']==$this->MakePassword($password))
						{
							$_SESSION['user_id']=$userdata['user_id'];
							$_SESSION['user_type']=$userdata['user_type'];
							$_SESSION['user_fullname']=$userdata['firstname']." ".$userdata['lastname'];
							$_SESSION['user_email']=$userdata['email'];

							$_SESSION['response'] = array("status"=>"success","message"=>"Logged in successfully."); 			
							$this->RedirectPage(USER_URL."/profile.php");
						}
						else
						{
							$_SESSION['response'] = array("status"=>"warning","message"=>"Incorrect Password. Please enter your correct Password.");
						}
					}
				}
				else
				{
					$_SESSION['response'] = array("status"=>"warning","message"=>"Your Account is inactive. Please Contact Admin for the same.");
				}
			}
			else
			{
				$_SESSION['response'] = array("status"=>"error","message"=>"Incorrect Email. Please check your Email : ".$email); 		
			}
			
		} 

		$this->data = $_POST;
	}

	protected function CheckUserLogin()
	{
		$info_array = array(
                        "fields"=>"login_require",
                        "where"=>"active_status='1' and login_require='1' and webpage_url='".$this->pagefilename."'"
                    );
		$page =  $this->GetSingleRecord("cms_webpages",$info_array);
		if(!empty($page))
		{
			if(!isset($_SESSION['user_id']) || $_SESSION['user_id']=="" || !is_numeric($_SESSION['user_id']))	
			{
				$this->RedirectPage(SITE_URL."/login.php");
			}
			else
			{
				$info_array = array("where"=>"user_id='".$_SESSION['user_id']."'");
				$this->UserData = $this->GetSingleRecord("user_master",$info_array);
			}		
		}
	}

	protected function UserProfile()
	{
		if(!$this->validate($_POST['firstname'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter First Name"); 	
		}
		if(!$this->validate($_POST['lastname'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Last Name"); 	
		}
		if(!$this->validate($_POST['email'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Email Address."); 	
		}
		if(!$this->validate($_POST['email'],"email"))
		{
		  $_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Valid Email Address."); 	
		}
		else
		{
			$info_array = array();
			$info_array['firstname']=mysql_real_escape_string($_POST['firstname']);
			$info_array['lastname']=mysql_real_escape_string($_POST['lastname']);
			$info_array['email']=mysql_real_escape_string($_POST['email']);

			/*BEGIN PROFILE PICTURE UPLOAD CODE*/
			if(!empty($_FILES['profile_picture']['name']))
			{
				$filesetting = array(
					"filetype"=>array("jpg","png","gif","jpeg","bmp"),
					"uploadpath"=>"../upload/profile/",
					"maxsize"=>100000
					);

				 $filename= $this->UploadFile($_FILES['profile_picture']['name'],$filesetting);

				 $info_array = array(
				 			"fields"=>"profile_picture",
				 			"where"=>"user_id='".$_SESSION['user_id']."'",
				 	);
				 $userdata = $this->GetSingleRecord("user_master",$info_array);
				 if($filename[0]!="")
				 {
				 	$info_array['profile_picture'] = $filename[0];
				 	$filesetting = array(
											"uploadpath"=>"../upload/profile/",
											"files"=>$userdata['profile_picture']
										);
				 	$this->DeleteFile($filesetting);
				 }
			}
			 /*END PROFILE PICTURE UPLOAD CODE*/

			$where = " user_id = '".$_SESSION['user_id']."' and user_type='".$_SESSION['user_type']."'";
			$updated = $this->UpdateRecord("user_master",$info_array,$where);
			
			if($updated>0)
			{
				$_SESSION['user_fullname']=$info_array['firstname']." ".$info_array['lastname'];	
				$_SESSION['user_email']=$info_array['email'];
				$_SESSION['response'][] = array("status"=>"success","message"=>"Your Details has been updated successfully.");
			}
			$this->RedirectPage(USER_URL."/profile.php");
		}

		$this->data = $_POST;
	}

	protected function ChangePassword()
	{
		if(!$this->validate($_POST['current_password'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Password"); 	
		}
		if(!$this->validate($_POST['new_password'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter New Password"); 	
		}
		if(!$this->validate($_POST['confirm_password'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Confirm Password"); 	
		}
		if($_POST['confirm_password']!=$_POST['new_password'])
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Confirm Password does not match."); 	
		}

		if(empty($_SESSION['response']))
		{

			if($this->UserData['password']!=$this->MakePassword($_POST['current_password']))
			{
				$_SESSION['response'] = array("status"=>"warning","message"=>"Current Password does not match."); 	
			}
			else
			{	
				$info_array = array("password"=>$this->MakePassword($_POST['new_password']));
				$where = " user_id = '".$_SESSION['user_id']."' and user_type!='1'";
				$updated = $this->UpdateRecord("user_master",$info_array,$where);
				
				if($updated>0)
				{
					$_SESSION['response'] = array("status"=>"success","message"=>"Your Password has been changed successfully.");
				}
				$this->RedirectPage(USER_URL."/profile.php");
			}
		}
	}

	public function Logout()
	{
		//session_destroy();
		unset($_SESSION['user_id']);
		unset($_SESSION['user_type']);
		unset($_SESSION['user_fullname']);
		unset($_SESSION['user_email']);
		$this->RedirectPage(SITE_URL."/login.php");
	}

	
}

?>