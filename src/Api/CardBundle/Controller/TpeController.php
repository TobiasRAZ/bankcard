<?php

namespace Api\CardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\CardBundle\Entity\Tpe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Api\CardBundle\Controller\DefaultController;

class TpeController extends Controller
{

	protected $_entity = 'Tpe';

	public function indexAction()
	{
		# code...	
	}

	public function getByIdAction($id)
	{
		# code...
	}

	public function getTpeFieldAction($id, $field)		
	{
		# code...
	}

	public function addTpeAction(Request $req)
	{
		# code...
	}

	public function updateTpeAction(Request $req, $id)
	{
		# code...
	}

	public function deleteCardAction($id)
	{
		# code...
	}
}
