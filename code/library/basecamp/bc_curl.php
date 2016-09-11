<?php
class BCCurl
{
	protected function get_data($url){
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
		return json_decode($response);
		curl_close($curl);
	}
}
?>