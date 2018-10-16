<?php

namespace Api\CardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Api\CardBundle\Entity\Tpe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Api\CardBundle\Controller\DefaultController;

class TpeController extends DefaultController
{

	protected $_entity = 'Tpe';

	public function indexAction()
	{
		return $this->findAll();	
	}

	public function getByIdAction($id)
	{
		return $this->findById($id);
	}

	public function getTpeFieldAction($id, $field)		
	{
		# code...
	}

	public function getTpeByImeiAction($imei)
	{
		$reponse = $this->getService()->getByImei($imei);
		return $this->reponse($reponse);
	}

	public function getTpeByMacAction($mac)
	{
		$reponse = $this->getService()->getByMac($mac);
		return $this->reponse($reponse);
	}

	public function addTpeAction(Request $req, $params = null)
	{


		$tpe = new Tpe();

		if ($params) {
			$data['imei'] = $params['imei'];
			$data['mac'] = $params['mac'];
			$data['active'] = $params['active'];
		}

		else{
			$data['imei'] = $req->request->get('imei');
			$data['mac'] = $req->request->get('mac');
			$data['active'] = $req->request->get('active');
		}


		$tpe->setImei($data['imei']);
		$tpe->setMac($data['mac']);
		$tpe->setActive($data['active']);
		
		$validator = $this->get('validator');
		$errors = $validator->validate($tpe);

		$validationError = array();
		if (count($errors) > 0) {
			foreach ($errors->getIterator() as $key => $value) {
				$err['message'] = $value->getMessage();
				$err['parameter'] = $value->getPropertyPath();
				array_push($validationError, $err);
			}
			return $this->reponse($validationError);
		}

		$failure = $this->validateTpe($data);

		if ($failure == false) {
			$reponse = $this->getService()->add($tpe);
			return $this->reponse($reponse);
		}

		else{
			return $this->reponse($failure);
		}

	}

	public function updateTpeAction(Request $req, $id)
	{
		$errors = array();
		$failure = false;
		$data['id'] = $id;
        $data['imei'] = $req->request->get('imei');
        $data['mac'] = $req->request->get('mac');

        $failure = $this->validateTpe($data);

        if ($failure == false) {
        	$reponse = $this->getService()->update($data);
        	return $this->reponse($reponse);
        }

        else{
        	return $this->reponse($failure);
        }
	}

	public function deleteTpeAction($id)
	{
		return $this->delete($id);
	}

	public function validateTpe($value='')
	{
		$error = false;
		return $error;
	}

	public function activateTpeAction($id)
	{
		$reponse = $this->getService()->activate($id);
		return $this->reponse($reponse);
	}
}
