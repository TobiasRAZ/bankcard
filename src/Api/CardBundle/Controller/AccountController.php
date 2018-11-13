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

		$this->firebaseservice()->save('cin/' . $cin ,$data);

		$cins = $this->firebaseService()->list('cin/' . $cin);

		$response['status'] = 200;

		return new JsonResponse($response);

	}

	public function firebaseService() {
        return $this->container->get('api_card.firebaseservice');
    }



}
