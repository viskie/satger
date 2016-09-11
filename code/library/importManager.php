<?

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

//require_once('Config.php');

class ImportManager extends commonObject
{
	
	
	function getAllTables(){	
		return getData("show tables");
	}
	
	function getNumOfFieldsOfTable($table_name,$db_name){
		return getOne("SELECT COUNT(*) total_fields FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$table_name."' AND TABLE_SCHEMA='".$db_name."'");
	}
	
	function importRecords($query){
		updateData($query);
	}
	
} 
?>
