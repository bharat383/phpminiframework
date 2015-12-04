 <?php
/*
FILE NAME : Dashboard.class.php
LOCAITON : admin/class/Dashboard.class.php
FILE DETAILS : Dashboard Data
Extends : Admin.class.php 
*/

@include("Admin.class.php");
class Dashboard extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->StatisticData();
		$this->LatestUsers();
		$this->LatestMessages();
	}

	public function StatisticData()
	{
		$this->statisticdata = array();

		//GET TOTAL NUMBER OF USERS
		$info_array = array(
					"fields"=>"count(user_id) as total",
					"where"=>"user_id>1"
				);
		$totalusers = $this->GetSingleRecord("user_master",$info_array);
		$this->statisticdata['total_users']=$totalusers['total'];

		//GET TOTAL NUMBER OF CONTACT MESSAGES0
		$info_array = array(
					"fields"=>"count(id) as total"
					);
		$totalusers = $this->GetSingleRecord("contactus_messages",$info_array);
		$this->statisticdata['total_messages']=$totalusers['total'];

	}

	public function LatestUsers()
	{
		$info_array = array(
					"fields"=>"firstname,lastname,email,register_date,register_ipaddress",
					"where"=>"user_id>1",
					"limit"=>10
				);
		$this->LatestUsers = $this->GetRecord("user_master",$info_array);
	}

	public function LatestMessages()
	{
		$info_array = array("limit"=>"10");
		$this->LatestMessages = $this->GetRecord("contactus_messages",$info_array);
	}
}

?>