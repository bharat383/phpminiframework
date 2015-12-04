 <?php
/*
FILE NAME : Database.class.php
LOCAITON : admin/class/Database.class.php
FILE DETAILS : Database Backup, Restore and Download.
Extends : Admin.class.php 
*/

@include("Admin.class.php");
class Database extends Admin
{
	public function __construct()
	{
		parent::__construct();

		if(isset($_GET['action']) && $_GET['action']=="backup")
		{
			$this->BackupDatabase(0); // data and structure of the database
		}
		else if(isset($_GET['action']) && $_GET['action']=="restore" && isset($_GET['filename']) && $_GET['filename']!="")
		{
			$this->RestoreDatabase($_GET['filename']);
		}
		else if(isset($_GET['action']) && $_GET['action']=="delete" && isset($_GET['filename']) && $_GET['filename']!="")
		{
			unlink("database/".$_GET['filename']);
			$_SESSION['admin_response'] = array("status"=>"success","message"=>"Database file has been deleted successfully.");
			$this->RedirectPage($this->pagefilename);	
		}

		$this->DisplayData();
	}

	private function DisplayData()
	{
		$dir_path    = 'database/';
		$allfiles = scandir($dir_path, 1);

		$this->data = array();
		$skip_files = array(".","..","index.htm","download.php");
		foreach ($allfiles as $key => $value) {
			if(!in_array($value, $skip_files)) {
				$this->data[] = $value;	
			}
		}
	}

	private function BackupDatabase($structureonly=1)
	{
		$this->table_array = array();
		$data = $this->GetCustom("SHOW TABLES");
		if(!empty($data))
		{
			foreach ($data as $key => $value) {
				$this->table_array[] = $this->GetCustom("SHOW CREATE TABLE ".key(array_flip($value)));
			}

			$file_content = "";
			foreach ($this->table_array as $key => $value) 
			{
				$file_content.=$value[0]['Create Table'].";\n\n";
				if($structureonly!=1){
					$tabledata = array();
					$info_array = array();
					$tablename = str_replace(TABLE_PREFIX, "", $value[0]['Table']);
					$tabledata[] = $this->GetRecord($tablename,$info_array);
					if(!empty($tabledata)) {
						$file_content.=$this->InsertRecordQuery($value[0]['Table'],$tabledata);
					}
				}
			}

			if($file_content!="")
			{
				$filename = "database/DB-".date("d-m-Y-H-i-s").".sql";
				$myfile = fopen($filename, "w+");
				fwrite($myfile, $file_content);
				fclose($myfile);
				chmod($filename, "0755");
				$_SESSION['admin_response'] = array("status"=>"success","message"=>"Database Backup has been completed successfully.");
			}
		}
		$this->RedirectPage($this->pagefilename);
	}

	private function InsertRecordQuery($tablename,$array)
	{
		$query_string = "insert into ".$tablename." (";
		foreach ($array[0] as $key => $value) 
		{
			foreach ($value as $k => $v) 
			{
				$query_string.="`".$k."` ,";	
			}
			break;
		}
				
		$query_string = trim($query_string," ,");

		$query_string.=" ) values ";
		foreach ($array[0] as $key => $value) 
		{

			$query_string.=" ( ";
			foreach ($value as $k => $v) 
			{
				$query_string.="'".$v."' ,";	
			}

			$query_string=trim($query_string," ,")." ) ,";
			
		}
		return trim($query_string," ,").";\n\n";
	}

	private function RestoreDatabase($restorefile)
	{
		$table_array = $this->GetCustom("SHOW TABLES");
		$query_string = "DROP TABLE ";
		foreach ($table_array as $key => $value) {
			$query_string.="`".key(array_flip($value))."`,";
		}
		$query_string = trim($query_string,",");
		$database_clean = mysql_query($query_string) or die(mysql_error());
		if(!empty($database_clean))
		{
			$query_separator = "-- --------------------------------------------------------";
			$query_content = explode($query_separator,file_get_contents("database/".$restorefile));
			foreach ($query_content as $query) {
				mysql_query($query) or die(mysql_error());
			}
			$_SESSION['admin_response'] = array("status"=>"success","message"=>"Database has been restored successfully.");
		}
		else
		{
			$_SESSION['admin_response'] = array("status"=>"error","message"=>"Database has not been restored. Please Try Again.");
		}
		$this->RedirectPage($this->pagefilename);
	}
}

?>