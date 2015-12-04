<?php
/*
FILE NAME : CMS.class.php
LOCAITON : admin/class/CMS.class.php
FILE DETAILS : CMS HOMEPAGE, CMS WEBPAGES AND EMAIL TEMPLATES 
Extends : Admin.class.php 
*/

include("Admin.class.php");
class CMS extends Admin
{
	public function __construct()
	{
		parent::__construct();
		
		/*BEGIN CMS HOMEPAGE FUNCITONS ASSIGN */
		if($this->pagefilename=="cmshomepage.php")
		{
			if(isset($_POST['submit_edit']))
			{
				$this->UpdateHomepage();
			}
			else
			{
				$info_array = array("id"=>1);
				$this->data = $this->GetSingleRecord("cms_homepage",$info_array);
			}
		}
		/*END CMS HOMEPAGE FUNCITONS ASSIGN */	

		/*BEGIN CMS WEBPAGES FUNCITONS ASSIGN */
			if($this->pagefilename=="cmswebpages.php")
			{
				if(isset($_POST['submit_add']))
				{
					array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
					$insert_id = $this->InsertRecord("cms_webpages",$_POST);

					if($insert_id>0)
					{
						$_SESSION['admin_response'] = array("status"=>"success","message"=>"Record has been added successfully.");
					}
					$this->RedirectPage($this->pagefilename);
				}
				else if(isset($_GET['action']) && $_GET['action']=="edit" && isset($_GET['id']) && is_numeric($_GET['id']))
				{
					if(isset($_POST['submit_edit']))
					{
						array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
						$records = $this->UpdateRecord("cms_webpages",$_POST,"webpage_id='".$_GET['id']."'");
						if($records>0)
						{
							$_SESSION['admin_response'] = array("status"=>"success","message"=> " Record has been updated successfully.");
						}
						$this->RedirectPage($this->pagefilename);
					}
					else
					{
						$info_array = array("where"=>"webpage_id='".$_GET['id']."'");
						$this->data = $this->GetSingleRecord("cms_webpages",$info_array);	
					}
				}
				else if(isset($_GET['action']) && $_GET['action']=="status" &&  isset($_GET['status']) && is_numeric($_GET['status']) && isset($_GET['id']))
				{
					$info_array = array("active_status"=>$_GET['status']);
					$records = $this->UpdateRecord("cms_webpages",$info_array,"webpage_id='".$_GET['id']."'");
					if($records>0)
					{
						$_SESSION['admin_response'] = array("status"=>"success","message"=> " Active status has been changed successfully.");
					}
					$this->RedirectPage($this->pagefilename);
				}
				else if(isset($_GET['action']) && $_GET['action']=="delete" && isset($_GET['id']))
				{
					$records = $this->DeleteRecord("cms_webpages","webpage_id='".$_GET['id']."'");
					if($records>0)
					{
						$_SESSION['admin_response'] = array("status"=>"success","message"=> " Record has been deleted successfully.");
					}
					$this->RedirectPage($this->pagefilename);
				}
				else
				{
					$this->DisplayCMSPages();	
				}

				
			}
		/*END CMS WEBPAGES FUNCITONS ASSIGN */


		/*BEGIN EMAIL TEMPLATE FUNCITONS ASSIGN */
			if($this->pagefilename=="emailtemplate.php")
			{
				if(isset($_POST['submit_add']))
				{
					array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
					$info_array = $_POST;
					$insert_id = $this->InsertRecord("email_template",$info_array);

					if($insert_id>0)
					{
						$_SESSION['admin_response'] = array("status"=>"success","message"=>"Record has been added successfully.");
					}
					$this->RedirectPage($this->pagefilename);
				}
				else if(isset($_GET['action']) && $_GET['action']=="edit" && isset($_GET['id']) && is_numeric($_GET['id']))
				{
					if(isset($_POST['submit_edit']))
					{
						array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
						$records = $this->UpdateRecord("email_template",$_POST,"template_id='".$_GET['id']."'");
						if($records>0)
						{
							$_SESSION['admin_response'] = array("status"=>"success","message"=> " Record has been updated successfully.");
						}
						$this->RedirectPage($this->pagefilename);
					}
					else
					{
						$info_array = array("where"=>"template_id='".$_GET['id']."'");
						$this->data= $this->GetSingleRecord("email_template",$info_array);
					}
				}
				else if(isset($_GET['action']) && $_GET['action']=="delete" && isset($_GET['id']))
				{
					$records = $this->DeleteRecord("email_template","template_id='".$_GET['id']."'");
					if($records>0)
					{
						$_SESSION['admin_response'] = array("status"=>"success","message"=> " Record has been deleted successfully.");
					}
					$this->RedirectPage($this->pagefilename);
				}
				else if(isset($_GET['action']) && $_GET['action']=="status" &&  isset($_GET['status']) && is_numeric($_GET['status']) && isset($_GET['id']))
				{
					$info_array = array("active_status"=>$_GET['status']);
					$records = $this->UpdateRecord("email_template",$info_array,"template_id='".$_GET['id']."'");
					if($records>0)
					{
						$_SESSION['admin_response'] = array("status"=>"success","message"=> " Active status has been changed successfully.");
					}
					$this->RedirectPage($this->pagefilename);
				}
				else
				{
					$this->DisplayEmailTemplates();
				}
			}
		/*END EMAIL TEMPLATE FUNCITONS ASSIGN */

	}

	public function UpdateHomepage()
	{
		array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
		$info_array = $_POST;
		$records = $this->UpdateRecord("cms_homepage",$info_array,"id='1'");
		if($records>0)
		{
			$_SESSION['admin_response'] = array("status"=>"success","message"=>"Record has been added successfully.");
		}
		$this->RedirectPage($this->pagefilename);
	}

	public function DisplayCMSPages()
	{
		$startfrom = 0;
		$limit=$_SESSION['pagerecords_limit'];

		if(isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$startfrom= ($_GET['page']*$_SESSION['pagerecords_limit']-$_SESSION['pagerecords_limit']);	
		} 

		$info_array = array(
								"orderby"=>"webpage_id",
								"ordertype"=>"asc",
								"limit"=>$limit,
								"startfrom"=>$startfrom
							);
		$this->startfrom = $startfrom;
		$this->data  = $this->GetRecord("cms_webpages",$info_array);
	}

	public function DisplayEmailTemplates()
	{
		$startfrom = 0;
		$limit=$_SESSION['pagerecords_limit'];

		if(isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$startfrom= ($_GET['page']*$_SESSION['pagerecords_limit']-$_SESSION['pagerecords_limit']);	
		} 

		$info_array = array(
								"orderby"=>"template_id",
								"ordertype"=>"asc",
								"limit"=>$limit,
								"startfrom"=>$startfrom
							);
		$this->startfrom = $startfrom;
		$this->data  = $this->GetRecord("email_template",$info_array);
	}

}

?>