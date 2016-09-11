<?php
	require_once('cron_config.php');
	
	require_once('../basecampManager.php');
	$basecampObject = new BasecampManager();
	require_once('../commonObject.php');
	$commonObject = new CommonObject();
	
	$projects = $basecampObject->getProjects();
	//echo "<pre>"; print_r($projects);
	
	foreach($projects as $project)
	{
		$insert_project = $commonObject->getInsertUpdateDataString($project,'basecamp_projects');
		updateData($insert_project);
		
		$to_do_lists = $basecampObject->getActiveToDoLists($project->id);
		echo "<pre>"; print_r($to_do_lists);
		foreach($to_do_lists as $to_do_list)
		{
			$to_dos = $basecampObject->getToDos($project->id,$to_do_list->id);
			//echo "<pre>"; print_r($to_dos);
			foreach($to_dos as $to_do)
			{
				
			}
		}
	}
?>