  <?php
/*
FILE NAME : User.class.php
LOCAITON : admin/class/User.class.php
FILE DETAILS : User Managment Function
Extends : Admin.class.php 
*/

@include("Admin.class.php");
class User extends Admin
{
	public function __construct()
	{
		parent::__construct();

		if(isset($_POST['submit_add']))
		{
			$this->AddNewUser();
		}
		else if(isset($_GET['action']) && $_GET['action']=="edit" && isset($_GET['id']) && is_numeric($_GET['id']))
		{
			if(isset($_POST['submit_edit']))
			{
				$this->UpdateUser();
			}
			else
			{
				$info_array = array("where"=>"user_id='".$_GET['id']."'");
				$this->data = $this->GetSingleRecord("user_master",$info_array);		
			}
		}
		else if(isset($_GET['action']) && $_GET['action']=="status" &&  isset($_GET['status']) && is_numeric($_GET['status']) && isset($_GET['id']) && $_GET['id']>1)
		{
			$info_array = array("active_status"=>$_GET['status']);
			$records = $this->UpdateRecord("user_master",$info_array,"user_id='".$_GET['id']."'");
			if($records>0)
			{
				$_SESSION['admin_response'] = array("status"=>"success","message"=> " Active status has been changed successfully.");
			}
			$this->RedirectPage($this->pagefilename);
		}
		else if(isset($_GET['action']) && $_GET['action']=="delete" && isset($_GET['id']) && $_GET['id']>1)
		{
			$records = $this->DeleteRecord("user_master","user_id='".$_GET['id']."'");
			if($records>0)
			{
				$_SESSION['admin_response'] = array("status"=>"success","message"=> " Record has been deleted successfully.");
			}
			$this->RedirectPage($this->pagefilename);
		}
		else 
		{
			$this->DisplayData();
		}
	}

	public function AddNewUser()
	{
		if(!$this->validate($_POST['firstname'],"require"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Please Enter First Name.");	
		}
		else if(!$this->validate($_POST['firstname'],"alpha"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"First Name Should Be Alphabets only.");	
		}
		else if(!$this->validate($_POST['lastname'],"require"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Please Enter Last Name.");	
		}
		else if(!$this->validate($_POST['lastname'],"alpha"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Last Name Should Be Alphabets only.");	
		}
		else if(!$this->validate($_POST['email'],"require"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Please Enter Email.");	
		}
		else if(!$this->validate($_POST['email'],"email"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Invalid Email Address.");	
		}
		else
		{
			$info_array = array("where"=>"email like '".$_POST['email']."'");
			$dupdata = $this->GetSingleRecord("user_master",$info_array);
			
			if(!empty($dupdata))
			{
				$_SESSION['admin_response'] = array("status"=>"error","message"=>"Email Address is already used.");	
			}
			else
			{
				array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
				if($_POST['password']=="")
					{unset($_POST['password']);}
				else
					{$_POST['password']=$this->MakePassword($_POST['password']);}

				$info_array = $_POST;
				$info_array['register_date'] = date("Y-m-d H:i:s");
				$info_array['register_ipaddress'] = $_SERVER['REMOTE_ADDR'];
				$insert_id = $this->InsertRecord("user_master",$info_array);

				if($insert_id>0)
				{
					$_SESSION['admin_response'] = array("status"=>"success","message"=>"Record has been added successfully.");
				}
			}
		}

		if($_SESSION['admin_response']['status']=="success")
		{
			$this->RedirectPage($this->pagefilename);
		}
		else
		{
			$this->data=$_POST;
		}
	}

	public function UpdateUser()
	{

		if(!$this->validate($_POST['firstname'],"require"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Please Enter First Name.");	
		}
		else if(!$this->validate($_POST['firstname'],"alpha"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"First Name Should Be Alphabets only.");	
		}
		else if(!$this->validate($_POST['lastname'],"require"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Please Enter Last Name.");	
		}
		else if(!$this->validate($_POST['lastname'],"alpha"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Last Name Should Be Alphabets only.");	
		}
		else if(!$this->validate($_POST['email'],"require"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Please Enter Email.");	
		}
		else if(!$this->validate($_POST['email'],"email"))
		{
			$_SESSION['admin_response'] = array("status"=>"warning","message"=>"Invalid Email Address.");	
		}
		else
		{
			$info_array = array("where"=>"email like '".$_POST['email']."' and user_id!='".$_GET['id']."'");
			$dupdata = $this->GetSingleRecord("user_master",$info_array);
			
			if(!empty($dupdata))
			{
				$_SESSION['admin_response'] = array("status"=>"error","message"=>"Email Address is already used.");	
			}
			else
			{
				array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
				if($_POST['password']=="")
					{unset($_POST['password']);}
				else
					{$_POST['password']=$this->MakePassword($_POST['password']);}
				$records = $this->UpdateRecord("user_master",$_POST,"user_id='".$_GET['id']."'");
				if($records>0)
				{
					$_SESSION['admin_response'] = array("status"=>"success","message"=> " Record has been updated successfully.");
				}
			}
		}


		if($_SESSION['admin_response']['status']=="success")
		{
			$this->RedirectPage($this->pagefilename);
		}
		else
		{
			$this->data=$_POST;
		}
	}

	public function DisplayData()
	{
		$startfrom = 0;
		$limit=$_SESSION['pagerecords_limit'];

		if(isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$startfrom= ($_GET['page']*$_SESSION['pagerecords_limit']-$_SESSION['pagerecords_limit']);	
		} 

		$info_array = array(
								"fields"=>"*",
								"orderby"=>"user_id",
								"ordertype"=>"desc",
								"where"=>"user_id>1",
								"limit"=>$limit,
								"startfrom"=>$startfrom
							);
		$this->startfrom = $startfrom;
		$this->data = $this->GetRecord("user_master",$info_array);		
	}
}

?>