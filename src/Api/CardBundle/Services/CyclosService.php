<?php

namespace Api\CardBundle\Services;

class CyclosService
{

	private $endpoint;

	public function __construct($endpoint) {
		$this->endpoint = $endpoint;
	}

	public function cerateAccount($user)
	{
		$cyclosEndpoint = $this->endpoint;

		$json = '{
		    "name": "'. $user["name"] .'",
		    "username": "' . $user["mobilePhones"] . '",
		    "passwords":[
		    	{
		    	    "type": "login",
		            "value": "' . $user["password"] . '",
		            "checkConfirmation": true,
		            "confirmationValue": "' . $user["password"] . '",
		            "forceChange": true
		    	}
		    ],
		    "group":"members",
		    "customValues": {
		    	"orchid_account": "'. $user["iban"] .'"
		    },
		    "mobilePhones": [
		    	{
			      "name": "mobile",
			      "number": "' . $user["mobilePhones"] . '",
			      "extension": "string",
			      "enabledForSms": true,
			      "verified": true,
			      "kind": "landLine"
				 }
			]
		}';

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $cyclosEndpoint,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $json,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		  ),
		));

		$response = curl_exec($curl);

		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$err = curl_error($curl);

		curl_close($curl);

		$result = array();

		if ($httpcode == 201) {
				$result['status'] = 201;
				$result['message'] = $response;
		}
		else {
			$result['status'] = $httpcode;
			if ($httpcode == 0 || !$response || $response == null) {
				$result['message'] = 'Connexion error';
			}
			else{
				$result['message'] = $response;
			}
		}

		return $result;
	}
}
