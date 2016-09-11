<?
//******************************Twilio SMS Sender Class *******************************
require("twilio/Twilio.php");
require_once("cUrl/class.curl.php");
require_once('Config.php');
require_once('commonFunctions.php');
//require_once('cUrl/class.curl.php');


class TwilioExt
{
	var $accountSid;
	var $authToken;
	var $appSid;
	var $twilioClient;
	
	function TwilioExt()
	{
		$twilioCreds = getTwlioCreds();
		$this->accountSid = $twilioCreds['sid'];
		$this->authToken =  $twilioCreds['auth_token'];
		$this->appSid = $twilioCreds['app_sid'];
	}
	
	function searchForPhoneNumber($match)
	{
		
		$SearchParams = array();
		$availableNumbers = array();
		$buyNumber = "000";
 		$phone = $match;
		$first3 = "";
		$SearchParams['InPostalCode'] = '';
        $SearchParams['NearNumber'] = '';
        $SearchParams['Contains'] = '';
		
		$twiCli = new Services_Twilio($this->accountSid, $this->authToken);
		
		if(trim($phone) != "") 	
		{	
			$first3 = substr($phone,0,3);
			$first2 = substr($phone,0,2);
			$first1 = substr($phone,0,1);	
			$SearchParams['Contains'] = $first3.'*******' ; 
		}
		
        //$postalCode = getOne("select zip from users where id = '".$user_id."'");
		/* Search parameters for US Local PhoneNumbers */
        
 
        try 
		{
 			// For first 3 match
            /* Initiate US Local PhoneNumber search with $SearchParams list */
            $numbers = $twiCli->account->available_phone_numbers->getList('GB', 'Local', $SearchParams);
 
            /* If we did not find any phone numbers let the user know */
            $chk = 0;
			foreach($numbers->available_phone_numbers as $numberT)
			{
				$chk++;
			}
			
			// For first 2 match
			if($chk==0) 
			{
                $SearchParams['Contains'] = $first2.'*******' ;
				$numbers = $twiCli->account->available_phone_numbers->getList('GB', 'Local', $SearchParams);
				
				 /* If we did not find any phone numbers let the user know */
				$chk = 0;
				foreach($numbers->available_phone_numbers as $numberT)
				{
					$chk++;
				}
				// For first 1 match
				if($chk==0) 
				{
					$SearchParams['Contains'] = $first1.'*******' ;
					$numbers = $twiCli->account->available_phone_numbers->getList('GB', 'Local', $SearchParams);
					
					$chk = 0;
					foreach($numbers->available_phone_numbers as $numberT)
					{
						$chk++;
					}
					// For first 0 match
					if($chk==0) 
					{
						$SearchParams['Contains'] = '' ;
						$numbers = $twiCli->account->available_phone_numbers->getList('GB', 'Local', $SearchParams);
					}
				}			
            }	
			
						
			foreach($numbers->available_phone_numbers as $number)
			{
				$availableNumbers[] = $number;
			}
			
			return $availableNumbers;
					
 
        } 
		catch (Exception $e) 
		{          
 				echo $e->getMessage();
		}
	
	}
	
	function buyNumber($twilioNumber)
	{
		$twiCli = new Services_Twilio($this->accountSid, $this->authToken);
		try {
 
            // POST the AreaCode to buy in to the IncomingPhoneNumbers resource
            $number = $twiCli->account->incoming_phone_numbers->create(array(
                "PhoneNumber" => $twilioNumber,
				"VoiceApplicationSid" => $this->appSid,
				"SmsApplicationSid" => $this->appSid,
            ));
 
            return "Success";
 
        } catch (Exception $e) {
 
            // If we weren't able to process the request successfully, return
            // the error back to the user
            return $err = "Error processing request for $twilioNumber: {$e->getMessage()}";
 
        }
	}
	
	function buyNewNumber($twilioNumber)
	{
		//$subscriptionReference = getOne("select subscription_reference from account_subscriptions where userid = '".$userId."' and active = '1'");
		
		echo $refUrl = "https://api.twilio.com/2010-04-01/Accounts/".$this->accountSid."/IncomingPhoneNumbers?PhoneNumber=".$twilioNumber;
		
		
		$data = "<IncomingPhoneNumber><PhoneNumber>".$twilioNumber."</PhoneNumber></IncomingPhoneNumber>";
		
		$c = new curl($refUrl);
		$c->setopt(CURLOPT_HEADER, true);
			$c->setopt(CURLOPT_RETURNTRANSFER, true);
			$c->setopt(CURLOPT_FOLLOWLOCATION, true);
		$c->setopt(CURLOPT_HEADER, true);
		$c->setopt(CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
		$c->setopt(CURLOPT_USERPWD, $this->accountSid.":".$this->authToken);
		$c->setopt(CURLOPT_POST, true);
		$c->setopt(CURLOPT_POSTFIELDS, $data);
			
		$resultVal = $c->exec();
		$resultVal = trim($resultVal);
		
		$error = "";		
		if ($theError = $c->hasError())
		{
		 echo $error = "ERROR :".$theError ;
		}
				
		$statusArr =  $c->getStatus();
		$http_code = $statusArr['http_code'];
		
		$retArray = $this->xml2array($resultVal);
		
		return $retArray;
				
	}
	
	

	function xml2array($contents, $get_attributes=1, $priority = 'tag') 
	{ 
		if(!$contents) return array(); 
	
		if(!function_exists('xml_parser_create')) { 
			//print "'xml_parser_create()' function not found!"; 
			return array(); 
		} 

		//Get the XML parser of PHP - PHP must have this module for the parser to work 
		$parser = xml_parser_create(''); 
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");  
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
		xml_parse_into_struct($parser, trim($contents), $xml_values); 
		xml_parser_free($parser); 

		if(!$xml_values) return;//Hmm... 
	
		//Initializations 
		$xml_array = array(); 
		$parents = array(); 
		$opened_tags = array(); 
		$arr = array(); 

		$current = &$xml_array; //Refference 
	
		//Go through the tags. 
		$repeated_tag_index = array();//Multiple tags with sam