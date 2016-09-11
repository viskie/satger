<?php
/* 
	Vishak Nair - 12/05/2014
	Basecamp api
	url : https://github.com/basecamp/bcx-api/
*/
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//require 'basecamp/basecamp.php';
require 'basecamp/bc_curl.php';
class BasecampManager extends BCCurl
{
	
	var $accout_id = 2629386;
	/**
     *	will return all active projects.
     */
	public function getProjects()
	{
		return $this->get_data('https://basecamp.com/'.$this->accout_id.'/api/v1/projects.json');
	}
	
	/**
     *	shows active todolists for this project sorted by position.
     */
	public function getActiveToDoLists($project_id)
	{
		return $this->get_data('https://basecamp.com/'.$this->accout_id.'/api/v1/projects/'.$project_id.'/todolists.json');	
	}
	
	/**
     *	shows completed todolists for this project.
     */
	public function getCompletedToDoLists($project_id)
	{
		return $this->get_data('https://basecamp.com/'.$this->accout_id.'/api/v1/projects/'.$project_id.'/todolists/completed.json');	
	}
	
	/**
     *	will return the specified todo
     */
	public function getToDos($project_id,$todo_list_id)
	{
		return $this->get_data('https://basecamp.com/'.$this->accout_id.'/api/v1/projects/'.$project_id.'/todolists/'.$todo_list_id.'.json');	
	}
}
?>