<?php

namespace Api\CardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Api\CardBundle\Controller\DefaultController;


class AccountController extends Controller
{


	public function addAction(Request $req)
	{

		$request = $req->request;

		$response = array();
		
		$iban = $request->get('iban');
		$cin = $request->get('cin');

		if ($cin && $iban) {
			$data['iban'] = $iban;

			$cins = $this->firebaseService()->list('cin/' . $cin);
			
			if ($cins && !isset($cins->iban)) {
				
				$phone = $cins->phone;

				if ($phone) {
					$user = $this->getInfo($phone);

					if ($user) {
						$postCyclos = $this->cyclosService()->cerateAccount($user);

						if ($postCyclos['status'] == 201) {

							$this->firebaseservice()->save('cin/' . $cin ,$data);

							$response = $postCyclos;

						}

						else {
							$response = $postCyclos;
						}
					}
					else{
						$response['status'] = 400;
						$response['message'] = 'User informations not found';
					}
				}

				else {
					$response['status'] = 400;
					$response['message'] = 'Phone not found';
				}
				
			}

			else if($cins) {
				$response['status'] = 400;
				$response['message'] = 'CIN already used';
			}

			else {
				$response['status'] = 400;
				$response['message'] = 'CIN not found';
			}
		}

		else{
			$response['status'] = 400;
			$response['message'] = 'cin,iban required';
		}

		return new JsonResponse($response);

	}

	public function getInfo($phone)
	{

		$password = $this->getPassword($phone);

		$result = array();

		if ($password) {
			
			$reference = 'newCustomer/' . $phone . '/infos' ;

			$infos = $this->firebaseservice()->list($reference);


			$result['name'] = $infos->name;
			$result['username'] = $infos->firstName;
			$result['mobilePhones'] = $phone;
			$result['password'] = $password;
		}

		else{
			$result = null;
		}


		return $result;
	}

	public function getPassword($phone)
	{

		$params = array(
            'phone' => $phone
        );

		$cardInfos = $this->forward('ApiCardBundle:Card:getCardByPhone', $params)->getContent();


		$data = json_decode($cardInfos);

		if ($data->data) {
			$password = $data->data->password;
		}

		else{
			$password = null;
		}


		return $password;
	}

	public function firebaseService() {
        return $this->container->get('api_card.firebaseservice');
    }

    public function cyclosService()
    {
    	return $this->container->get('api_card.cyclosservice');
    }

 //    public function postUser($user) {

	// 	$cyclosEndpoint = $this->getParameter('cyclos')['endpoint'];

	// 	$json = '{
	// 	    "name": "'. $user["name"] .'",
	// 	    "username": "' . $user["username"] . '",
	// 	    "passwords":[
	// 	    	{
	// 	    	    "type": "login",
	// 	            "value": "' . $user["password"] . '",
	// 	            "checkConfirmation": true,
	// 	            "confirmationValue": "' . $user["password"] . '",
	// 	            "forceChange": true
	// 	    	}
	// 	    ],
	// 	    "group":"members",
	// 	    "mobilePhones": [
	// 	    	{
	// 		      "name": "mobile",
	// 		      "number": "' . $user["mobilePhones"] . '",
	// 		      "extension": "string",
	// 		      "enabledForSms": true,
	// 		      "verified": true,
	// 		      "kind": "landLine"
	// 			 }
	// 		]
	// 	}';

	// 	$curl = curl_init();
	// 	curl_setopt_array($curl, array(
	// 	  CURLOPT_URL => $cyclosEndpoint,
	// 	  CURLOPT_RETURNTRANSFER => true,
	// 	  CURLOPT_CUSTOMREQUEST => "POST",
	// 	  CURLOPT_POSTFIELDS => $json,
	// 	  CURLOPT_HTTPHEADER => array(
	// 	    "Content-Type: application/json",
	// 	  ),
	// 	));

	// 	$response = curl_exec($curl);

	// 	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	// 	$err = curl_error($curl);

	// 	curl_close($curl);

	// 	$result = array();

	// 	if ($httpcode == 201) {
	// 			$result['status'] = 201;
	// 			$result['message'] = $response;
	// 	}
	// 	else {
	// 		$result['status'] = $httpcode;
	// 		if ($httpcode == 0 || !$response || $response == null) {
	// 			$result['message'] = 'Connexion error';
	// 		}
	// 		else{
	// 			$result['message'] = $response;
	// 		}
	// 	}

	// 	return $result;

	// }



}
