<?
//Vishak Nair - 25/08/2012
//for user management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class LeadManager extends commonObject
{
	public $db_fields;
	function LeadManager(){
		$this->db_fields = array();	
	}
	
	//Function to fetch records for report
	function getAllStatus($value=1){
		if($value == 1){
			$query="Select * from `lead_status` where 1";
			return getData($query);
		}else if($value == 2){
			$query="Select * from `lead_status` where is_active=0";
			return getData($query);
		}
		else if($value == 0){
			$query="Select * from `lead_status` where is_active=1";
			return getData($query);
		}
	}
	
	function get_allcounts_status()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(status_id) AS CNT From lead_status WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(status_id) AS CNT From lead_status WHERE is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(status_id) AS CNT From lead_status WHERE is_active = 0 ");
		$arr_counts['deleted'] = $trash;
		return $arr_counts;
	}
	
	function restoreStatus($status_id)
	{
		updateData("UPDATE lead_status SET is_active=1 WHERE status_id=".$status_id);		
	}
	
	function getAllSubStatus($value=0){
		
		if($value == 1){
			$query="Select substatus_id,substatus_name,status_name,`lead_substatus`.status_id ,lead_substatus.is_active from `lead_substatus`,`lead_status` where `lead_substatus`.status_id = `lead_status`.status_id";
			return getData($query);	
		}else if($value == 2){
			$query="Select substatus_id,substatus_name,status_name,`lead_substatus`.status_id ,lead_substatus.is_active from `lead_substatus`,`lead_status` where `lead_substatus`.status_id = `lead_status`.status_id and lead_substatus.is_active=0 ";
			return getData($query);		
		}else{
			$query="Select substatus_id,substatus_name,status_name,`lead_substatus`.status_id ,lead_substatus.is_active from `lead_substatus`,`lead_status` where `lead_substatus`.status_id = `lead_status`.status_id and lead_substatus.is_active=1 and lead_status.is_active=1 ";
			return getData($query);
		}
	}
	
	function get_allcounts_substatus()
	{
		$arr_counts = array();
		$all = getOne("Select COUNT(substatus_id) as CNT from `lead_substatus` WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("Select COUNT(substatus_id) as CNT from `lead_substatus` WHERE is_active=1");
		$arr_counts['active'] = $active;
		$trash = getOne("Select COUNT(substatus_id) as CNT from `lead_substatus` WHERE is_active=0  ");
		$arr_counts['deleted'] = $trash;
		return $arr_counts;
	}
	
	function restoreSubStatus($substatus_id)
	{
		updateData("UPDATE lead_substatus SET is_active=1 WHERE substatus_id=".$substatus_id);		
	}
	
	function getLeadDetailsUsingId($lead_id){
		$query="Select * from `lead` where lead_id=".$lead_id;
		return getData($query);
	}
	
	function getAllSource($value=0){
		if($value == 1){
			$query="Select * from `lead_source` where 1";
			return getData($query);
		}else if($value == 2){
			$query="Select * from `lead_source` where is_active=0";
			return getData($query);	
		}else{
			$query="Select * from `lead_source` where is_active=1";
			return getData($query);
		}
	}
	
	function get_allcounts_source()
	{
		$arr_counts = array();
		$all = getOne("Select COUNT(source_id) as CNT from `lead_source` WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("Select COUNT(source_id) as CNT from `lead_source` WHERE is_active=1");
		$arr_counts['active'] = $active;
		$trash = getOne("Select COUNT(source_id) as CNT from `lead_source` WHERE is_active=0  ");
		$arr_counts['deleted'] = $trash;
		return $arr_counts;	
	}
	
	function restoreSource($source_id)
	{
		updateData("UPDATE lead_source SET is_active=1 WHERE source_id=".$source_id);		
	}
	
	function getStatusById($statusId)
	{	$query="Select * from `lead_status` where is_active=1 and status_id='".$statusId."'";
		return getRow($query);
	}
	
	function getSubStatusById($substatusId)
	{	$query="Select * from `lead_substatus` where is_active=1 and substatus_id='".$substatusId."'";
		return getRow($query);
	}
	
	function getSubStatusByStatusId($status_id){
		$query="Select substatus_id,substatus_name from `lead_substatus` where is_active=1 and status_id='".$status_id."'";
		return getData($query);
	}
	
	function getSourceById($sourceId)
	{	$query="Select * from `lead_source` where is_active=1 and source_id='".$sourceId."'";
		return getRow($query);
	}
		
	function getStatusVariables()
	{
		$this->db_fields['status_name'] = $_REQUEST['status_name'];
					
	}
	
	function getSubStatusVariables()
	{
		$this->db_fields['substatus_name'] = $_REQUEST['substatus_name'];
		$this->db_fields['status_id'] = $_REQUEST['status_id'];
					
	}
	function getSourceVariables()
	{
		$this->db_fields['source_name'] = $_REQUEST['source_name'];
					
	}
	
	/*function getAllLeads($table_name,$value){
		if($value == 1)
			return $resultSet = getData("SELECT * FROM `".$table_name."` WHERE 1 order by is_active desc");
		else		
			return $resultSet = getData("SELECT * FROM `".$table_name."` WHERE is_active =0"); 
	}*/
	
	function getAllLeads($value){
		if($value == 0)
			return $resultSet = getData("SELECT * FROM `lead` order by priority_id,followup_date");
		else if($value == 1)		
			return $resultSet = getData("SELECT * FROM `lead` WHERE is_active =1 AND is_archive=0 order by priority_id,followup_date");
		else if($value == 2)	
			return $resultSet = getData("SELECT * FROM `lead` WHERE is_active =0 AND is_archive=0 order by priority_id,followup_date");
		else
			return $resultSet = getData("SELECT * FROM `lead` WHERE is_active =1 AND is_archive=1 order by priority_id,followup_date");
	}
	
	function restoreUsers($lead_id)
	{
		updateData("UPDATE lead SET is_active=1 WHERE lead_id=".$lead_id);
	}
	
	function archiveLead($lead_id){
		if(is_array($lead_id)){
			$implode_lead_id = implode(",",$lead_id);
			updateData("UPDATE lead SET is_archive=1 WHERE lead_id in (".$implode_lead_id.")" );
		}else{
			updateData("UPDATE lead SET is_archive=1 WHERE lead_id=".$lead_id);
		}
	}
	
	function unArchiveLead($lead_id){
		if(is_array($lead_id)){
			$implode_lead_id = implode(",",$lead_id);
			updateData("UPDATE lead SET is_archive=0 WHERE lead_id in (".$implode_lead_id.")" );
		}else{
			updateData("UPDATE lead SET is_archive=0 WHERE lead_id=".$lead_id);
		}
	}
	
	function get_allcounts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(lead_id) AS CNT From lead WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(lead_id) AS CNT From lead WHERE is_active = 1 AND is_archive=0");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(lead_id) AS CNT From lead WHERE is_active = 0 AND is_archive=0");
		$arr_counts['deleted'] = $trash;
		$archive = getOne("SELECT COUNT(lead_id) AS CNT From lead WHERE is_active = 1 AND is_archive=1");
		$arr_counts['archive'] = $archive;
		return $arr_counts;
		
	}
	
	function getAllLeadVariable()
	{
		$this->db_fields['lead_name'] = $_REQUEST['lead_name'];
		$this->db_fields['initial_contact_date'] = $_REQUEST['initial_contact_date_alt'];
		$this->db_fields['source_id'] = $_REQUEST['source'];
		$this->db_fields['product_id'] = $_REQUEST['product'];
		$this->db_fields['followup_date'] = $_REQUEST['followup_date_alt'];
		$this->db_fields['conversion_date'] = $_REQUEST['conversion_date_alt'];
		$this->db_fields['initial_meeting_date'] = $_REQUEST['initial_meeting_date_alt'];	
		$this->db_fields['status_id'] = $_REQUEST['status'];
		$this->db_fields['substatus_id'] = $_REQUEST['sub-status'];
		$this->db_fields['lead_email'] = $_REQUEST['lead_email'];
		$this->db_fields['lead_phone'] = $_REQUEST['lead_phone'];
		$this->db_fields['firm_name'] = $_REQUEST['firm_name'];
		$this->db_fields['firm_position'] = $_POST['firm_position'];
		$this->db_fields['type_business'] = $_REQUEST['type_business'];
		$this->db_fields['priority_id'] = $_REQUEST['priority_id'];
		$this->db_fields['number_of_meeting'] = $_REQUEST['number_of_meeting'];
		$this->db_fields['potential'] = $_REQUEST['potential'];
	}
	
	function insertLeadNote($varArray){
		$insertQry = $this->getInsertDataString($varArray, 'lead_notes');
		updateData($insertQry);
		return mysql_insert_id();	
	}
	
	function getNotesOfLead($lead_id){
		return getData("select * from lead_notes where lead_id='".$lead_id."' AND is_active='1' order by added_date");
	}
	
	function getUnits($product_id)
	{
		return getOne("select units from inventory where product_id = '".$product_id."'");
	}
	
	function getAllPriorities()
	{
		return getData("select * from priority where is_active = 1");
	}
	function getPriorityById($id)
	{
		return getRow("select * from priority where id = '".$id."'");
	}
} 
?>
