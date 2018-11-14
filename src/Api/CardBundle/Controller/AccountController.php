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

		$iban = $request->get('iban');
		$cin = $request->get('cin');

		$data['iban'] = $iban;

		$cins = $this->firebaseService()->list('cin/' . $cin);

		$phone = $cins->phone;

		// var_dump($cins->phone);die;

		$user = $this->getInfo($phone);

		$response = array();
		
		if ($cins && !isset($cins->iban)) {

			$postCyclos = $this->postUser($user);

			if ($postCyclos['status'] == 201) {


				$this->firebaseservice()->save('cin/' . $cin ,$data);


				$response = $postCyclos;


			}

			else {
				$response = $postCyclos;
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


		return new JsonResponse($response);

	}

	public function getInfo($phone)
	{

		$password = $this->getPassword($phone);

		$reference = 'newCustomer/' . $phone . '/infos' ;

		$infos = $this->firebaseservice()->list($reference);

		$result = array();

		$result['name'] = $infos->name;
		$result['username'] = $infos->firstName;
		$result['mobilePhones'] = $phone;
		$result['password'] = $password;

		return $result;
	}

	public function getPassword($phone)
	{

		$params = array(
            'phone' => $phone
        );

		$cardInfos = $this->forward('ApiCardBundle:Card:getCardByPhone', $params)->getContent();

		$data = json_decode($cardInfos);

		$password = $data->data->password;

		return $password;
	}

	public function firebaseService() {
        return $this->container->get('api_card.firebaseservice');
    }

    public function postUser($user) {

    	// var_dump($user);die;

		$json = '{
		    "name": "'. $user["name"] .'",
		    "username": "' . $user["username"] . '",
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


		// var_dump($json);die;

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://192.168.2.174:8080/cyclos/api/users",
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
			$result['message'] = $response;
		}

		// var_dump($result);die;

		return $result;

	}



}
