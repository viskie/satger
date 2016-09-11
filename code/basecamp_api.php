<?php
/*
	GET /projects.json will return all active projects.
	GET /projects/archived.json will return all archived projects.
	GET /projects/1.json will return the specified project. replace 1 with project ID
	
	GET /projects/1/todolists.json shows active todolists for this project sorted by position. replace 1 with project ID
	GET /projects/1/todos/1.json will return the specified todo.
*/
require 'library/basecamp/basecamp.php';
$appName = 'MyApp';
$appContact = 'Vishak Nairrc.pune@gmail.com';

$basecampAccountId = '2629386';
$basecampUsername = 'Vishak Nairrc.pune@gmail.com';
$basecampPassword = 'Vishak Nair!@#';

$basecamp = basecamp_api_client($appName, $appContact,$basecampAccountId, $basecampUsername, $basecampPassword);

try {
    /**
     * Get a list of all projects:
     */
    $projects = $basecamp('GET', '/projects.json');
	//var_dump($projects);	exit;
    foreach ($projects as $project) {
    	$to_do_lists = $basecamp('GET','projects/'.$project->id.'/todolists.json');
	   	foreach ($to_do_lists as $to_do_list) {
			   $to_do = $basecamp('GET','projects/'.$project->id.'/todolists/'.$to_do_list->id.'.json'); //will return the specified todolist including the todos.
			   echo"<pre>";print_r($to_do);
		}
	}

} catch (Exception $e) {
    die($e->getMessage());
}
//curl -u Vishak Nairrc.pune@gmail.com:Vishak Nair!@# -H 'Content-Type: application/json' -H 'User-Agent: MyApp (Vishak Nairrc.pune@gmail.com)' https://basecamp.com/2629386/api/v1/projects.json

/*$url = "https://basecamp.com/2629386/api/v1/projects/1/todolists.json";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_USERPWD,'Vishak Nairrc.pune@gmail.com:Vishak Nair!@#');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json')                                                                       
); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl,  CURLOPT_USERAGENT , "MyApp (Vishak Nairrc.pune@gmail.com)");
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
$response = curl_exec($curl);
var_dump( $response );
curl_close($curl);*/
?>

