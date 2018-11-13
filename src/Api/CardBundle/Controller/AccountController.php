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

		var_dump($data);die;
	}
}
