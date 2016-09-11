<?

class commonObject

{	

	protected $table_name;

	

	public function getInsertDataString($dataArray, $tableName)

	{

		$subQryArr = array();

		foreach($dataArray as $key => $value)

		{

			$subQryArr[] = $key." = '".addslashes($value)."'";

		}

		$subQry = implode(", ",$subQryArr);

		$insertQry = "insert into ".$tableName." set ".$subQry;

		return $insertQry;	

	}

	

	//Vishak Nair - 09-08-2012

	//To generate string for update query form array.

	//Note: $dataArray must contain the id. $idFieldName is the name of the field which contains the id.

	function getUpdateDataString($dataArray,$tableName,$idFieldName){

		$subQryArr = array();

		foreach($dataArray as $key => $value)

		{

			if(!($key==$idFieldName))

				$subQryArr[] = $key." = '".addslashes($value)."'";

		}

		$subQry = implode(", ",$subQryArr);

		$updateQry = "Update ".$tableName." set ".$subQry." where ".$idFieldName."='".$dataArray[$idFieldName]."'";

		return $updateQry;

	}

	/*
		row with same primary/unique key already exists it will just update row.
	*/
	function getInsertUpdateDataString($dataArray, $tableName)
	{
		//INSERT INTO table (primarykeycol,col1,col2) VALUES (1,2,3) ON DUPLICATE KEY UPDATE col1=0, col2=col2+1
		$dataArray = get_object_vars($dataArray);
		$fieldArr = array();
		$dataArr = array();
		foreach($dataArray as $key=>$value)
		{
			$fieldArr[] = $key;
			$dataArr[] = "'".addslashes($value)."'";
		}
		$field = implode(", ",$fieldArr);
		$data = implode(", ",$dataArr);
		
		$updateDataArr = array();
		foreach($dataArray as $key=>$value)
		{
			$updateDataArr[] = $key." = '".addslashes($value)."'";
		}
		$updateData = implode(", ",$updateDataArr);
		
		$query = "INSERT INTO ".$tableName." (".$field.") VALUES (".$data.") ON DUPLICATE KEY UPDATE ".$updateData.";";
		return $query;
	}

	function insert($varArray, $table_name)

	{

		$insertQry = getInsertDataString($varArray, $table_name);

		updateData($insertQry);

		return mysql_insert_id();

	}

	

	function update($varArray, $table_name,$field_name)

	{

		$updateQry=getUpdateDataString($varArray,$table_name,$field_name);

		

		updateData($updateQry);

	}

	

	function delete($id,$table_name,$field_name)

	{

		updateData("UPDATE `".$table_name."` SET `is_active`=false WHERE `".$field_name."`='".$id."'");	

	}

	

	function getAll($table_name)

	{

		

		return $resultSet = getData("SELECT * FROM `".$table_name."` WHERE is_active =1");

		

	}

	function getRecordById($field_name,$field_value)

	{

		return getRow("SELECT * FROM `".$this->table_name."` WHERE `".$field_name."`= '".$field_value."'");	

	}

	

	function restoreEntry($field_name,$field_value)

	{

		updateData("UPDATE `".$this->table_name."` SET is_active=1 WHERE `".$field_name."`= '".$field_value."'");		

	}

}

?>

