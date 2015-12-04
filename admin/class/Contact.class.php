  <?php
/*
FILE NAME : Contact.class.php
LOCAITON : admin/class/User.class.php
FILE DETAILS : Contact Us Messages
Extends : Admin.class.php 
*/

@include("Admin.class.php");
class Contact extends Admin
{
	public function __construct()
	{
		parent::__construct();

		if(isset($_GET['action']) && $_GET['action']=="delete" && isset($_GET['id']))
		{
			$records = $this->DeleteRecord("contactus_messages","id='".$_GET['id']."'");
			if($records>0)
			{
				$_SESSION['admin_response'] = array("status"=>"success","message"=> " Record has been deleted successfully.");
			}
			$this->RedirectPage($this->pagefilename);
		}
		$this->DisplayData();
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
								"orderby"=>"id",
								"ordertype"=>"desc",
								"limit"=>$limit,
								"startfrom"=>$startfrom
							);
		$this->startfrom = $startfrom;
		$this->data = $this->GetRecord("contactus_messages",$info_array);		
	}
}

?>