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

		$data['iban'] = $request->get('iban');
		$data['cin'] = $request->get('cin');


		$cins = $this->firebaseService()->list('cin');

		var_dump($cins);die;

	}

	public function firebaseService() {
        return $this->container->get('api_card.firebaseservice');
    }



}
