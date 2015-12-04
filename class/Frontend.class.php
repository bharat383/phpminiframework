<?php

/*
FILE NAME : Frontend.class.php
LOCAITON : class/Frontend.class.php
FILE DETAILS : Frontend Class. Includes CMS Pages, Contact Us
Extends : Main.class.php => class/Main.class.php
*/
@include("Main.class.php");
class Frontend extends Main
{
	public function __construct()
	{
		parent::__construct();

		/*BEGIN FILE NAME FUNCTION */
		$this->pagefilename = basename($_SERVER['PHP_SELF']);
		/*END FILE NAME FUNCTION */

		/*GET WEB PAGE CONTENT, TITLE, META KEYWORDS*/
		$this->webpage_data = $this->GetWebPageContent($this->pagefilename);

		/*BEGIN CONTACT US FUNCTION ASSIGN*/
			if(isset($_POST['submit_contact']) && !empty($_POST))
			{
				$this->ContactUs();
			}
		/*END CONTACT US FUNCTION ASSIGN*/

		/*BEGIN SUBSCRIBE FUNCTION ASSIGN*/
			if(isset($_POST['submit_subscribe']))
			{
				$this->Subscribe();
			}
		/*END SUBSCRIBE FUNCTION ASSIGN*/

	}

	public function GetWebPageContent($webpage="")
	{
		if(is_numeric($webpage))
		{
			$info_array = array(
					"where"=>" webpage_id = '".$webpage."'"
				);
		}
		else
		{
			$info_array = array(
					"where"=>" webpage_url = '".$webpage."'"
				);	
		}
		return $this->GetSingleRecord("cms_webpages",$info_array);
	}

	public function ContactUs()
	{
		if(!$this->validate($_POST['fullname'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Full Name."); 	
		}
		if(!$this->validate($_POST['fullname'],"alpha"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>" Full Name should have only Alphabets."); 	
		}
		if(!$this->validate($_POST['email'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Full Name."); 	
		}
		if(!$this->validate($_POST['email'],"email"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Valid Email Address."); 	
		}
		else if(!$this->validate($_POST['message'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Message."); 	
		}
		
		if(empty($_SESSION['response']))
		{
			array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
			$_POST['message_date']=date("Y-m-d H:i:s");
			$_POST['ip_address']=$_SERVER['REMOTE_ADDR'];
			$insert_id = $this->InsertRecord("contactus_messages",$_POST);
				
			$info_array = array("where"=>"template_id='4'");
			$mail_template = $this->GetSingleRecord("email_template",$info_array);
			
			if($mail_template['active_status']==1)
			{
				$tag_array = array("{Email}","{FullName}","{Message}");
				$str_array = array($_POST['email'],$_POST['fullname'],$_POST['message']);

				$mail_subject = str_replace($tag_array, $str_array, $mail_template['subject']);		
				$mail_message = str_replace($tag_array, $str_array, $mail_template['message']);	

				$this->SendMail($_POST['email'],$mail_subject,$mail_message);
			}
			
			$_SESSION['response'] = array("status"=>"success","message"=>"Thank You For Contact Us. Your message has been sent to the Admin.");

			$this->RedirectPage($this->pagefilename);
		}			
		$this->data = $_POST;
	}

	/*public function Subscribe()
	{
		
		if(!$this->validate($_POST['subscribe_email'],"require"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Mobile Number."); 	
		}
		if(!$this->validate($_POST['subscribe_email'],"email"))
		{
			$_SESSION['response'][] = array("status"=>"warning","message"=>"Please Enter Valid Email Address."); 	
		}

		if(empty($_SESSION['response']))
		{
			$subscribe_email = mysql_real_escape_string($_POST['subscribe_email']);

			array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
			$_POST['created_date']=date("Y-m-d H:i:s");
			$_POST['active_status']='1';
			$insert_id = $this->InsertRecord("subscriber",$_POST);

			$tag_array = array("{Email}");
			$str_array = array($_POST['subscribe_email']);
			
			$info_array = array("where"=>"template_id='3'");
			$mail_template = $this->GetSingleRecord("email_template",$info_array);

			if($mail_template['active_status']==1)
			{
				$mail_subject = str_replace($tag_array, $str_array, $mail_template['subject']);		
				$mail_message = str_replace($tag_array, $str_array, $mail_template['message']);	

				$this->SendMail($subscribe_email,$mail_subject,$mail_message);
			}

			$_SESSION['response'] = array("status"=>"success","message"=>"Thank You For Subscribing.");
			$this->RedirectPage($this->pagefilename);
		}		
	}*/

	public function DisplayMessage()
	{
		$message_class_array = array(
								"info"=>"alert alert-info",
								"warning"=>"alert alert-warning",
								"error"=>"alert alert-danger",
								"success"=>"alert alert-success"
								);
		if(isset($_SESSION['response']) && !empty($_SESSION['response']))
		{
			if(count($_SESSION['response']) == count($_SESSION['response'], COUNT_RECURSIVE))//ARRAY IS SINGLE DIMENSION ARRAY
			{	
				echo '<div class="'.$message_class_array[$_SESSION['response']['status']].'">'.stripslashes($_SESSION['response']['message']).'</div>';
			}
			else //ARRAY IS MULTI DIMENSION ARRAY
			{
				foreach ($_SESSION['response'] as $key => $value) {
					echo '<div class="'.$message_class_array[$value['status']].'">'.stripslashes($value['message']).'</div>';
				}
			}
		}
		unset($_SESSION['response']);
	}

	public function DisplayMenu()
	{
		$info_array = array(
                        "fields"=>"login_require,webpage_url,webpage_title",
                        "where"=>"active_status='1'",
                        "orderby"=>"webpage_id",
                        "ordertype"=>"asc"
                    );
		
		$page_array =  $this->GetRecord("cms_webpages",$info_array);

		foreach ($page_array as $key => $menudata) {
			$active_class= "";
			if($this->pagefilename==$menudata['webpage_url']) {$active_class="active";} 
		        
		    if($menudata['login_require']==1 && !isset($_SESSION['user_id'])) {continue;}

		    $pageafterlogin = array("login.php","register.php");
		    if($menudata['login_require']==0 && isset($_SESSION['user_id']) && (in_array($menudata['webpage_url'], $pageafterlogin))) 
		    	{continue;}

	        echo '<li class="'.$active_class.'"><a href="'.SITE_URL.'/'.stripslashes($menudata['webpage_url']).'">'.stripslashes($menudata['webpage_title']).'</a></li>';
	    }

	    if(isset($_SESSION['user_id']))
	    {
	    	echo '<li><a href="?logout">Logout</a></li>';	
	    }
	}
}

?>