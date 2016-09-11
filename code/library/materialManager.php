<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class MaterialManager extends commonObject
{
	public $db_fields;
	function MaterialManager()
	{
		$this->db_fields = array();	
	}	
	
	function getMaterialDetailsById($materialId)
	{
		return $resultSet = getRow("SELECT * FROM `materials` where material_id=".$materialId);	
	}
	
	function getAllMaterial($table_name,$value){
		if($value == 1)
			return $resultSet = getData("SELECT * FROM `".$table_name."` WHERE 1 order by is_active desc");
		else		
			return $resultSet = getData("SELECT * FROM `".$table_name."` WHERE is_active =0");
	}
	
	function get_allcounts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(material_id) AS CNT From materials WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(material_id) AS CNT From materials WHERE is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(material_id) AS CNT From materials WHERE is_active = 0 ");
		$arr_counts['deleted'] = $trash;
		return $arr_counts;
		
	}
	
	function restoreMatrial($marerial_id)
	{
		updateData("UPDATE materials SET is_active=1 WHERE material_id=".$marerial_id);	
	}
	
	function getMaterialVariables()
	{
		$this->db_fields['material_name'] = $_REQUEST['material_name'];
		$this->db_fields['material_code'] = $_REQUEST['material_code'];
		$this->db_fields['material_cost'] = $_REQUEST['material_cost'];
	}
}
?>