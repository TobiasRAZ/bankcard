<?php

namespace Api\CardBundle\Controller;

use Api\CardBundle\Entity\Card;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Api\CardBundle\Controller\DefaultController;

class CardController extends DefaultController {
	protected $_entity = 'Card';

	/**
	 * List of cards
	 */
	public function indexAction() {
		$cards = $this->getService()->getAll();
		return $this->reponse($cards);
	}

	/**
	 * Get card by id
	 */
	public function getByIdAction($id) {
		$card = $this->getService()->getById($id);
		return $this->reponse($card);
	}

	/**
	 *  Get specific field for selected card
	 */
	public function getCardFieldAction($id,$fields)
	{
		$card = $this->getService()->getById($id);

		$_card = new Card();
		$_card->setPin($card[0]['pin']);
		$_card->setCardNumber($card[0]['cardNumber']);

		$getter = 'get'.ucfirst($fields);
		
		if (method_exists($_card, $getter)) {
			$value = $_card->$getter();
			return $this->reponse(array('id' => $id, $fields => $value));
		}
		else{
			$message = array(
				'error' => 0,
				'message' => 'Field ' . $fields . ' not found in Card'
			);
			return $this->reponse($message);
		}


	}

	/**
	 * Add new card
	 */
	public function addCardAction(Request $req) {
		$card = new Card();
		$data['cardNumber'] = $req->request->get('cardNumber');
		$data['pin'] = $req->request->get('pin');
		$card->setCardNumber($data['cardNumber']);
		$card->setPin($data['pin']);
		
		$validator = $this->get('validator');
		$errors = $validator->validate($card);

		$validationError = array();
		if (count($errors) > 0) {
			foreach ($errors->getIterator() as $key => $value) {
				$err['message'] = $value->getMessage();
				$err['parameter'] = $value->getPropertyPath();
				array_push($validationError, $err);
			}
			return $this->reponse($validationError);
		}

		$failure = $this->validateCard($data);

		if ($failure == false) {
			$reponse = $this->getService()->add($card);
			return $this->reponse($reponse);
		}

		else{
			return $this->reponse($failure);
		}

		
	}

	/**
	 * Update Card
	 */
	public function updateCardAction(Request $req, $id)
	{
		$errors = array();
		$failure = false;
		$data['id'] = $id;
        $data['cardNumber'] = $req->request->get('cardNumber');
        $data['pin'] = $req->request->get('pin');

        $failure = $this->validateCard($data);

        if ($failure == false) {
        	$reponse = $this->getService()->update($data);
        	return $this->reponse($reponse);
        }

        else{
        	return $this->reponse($failure);
        }

	}

	/**
	 * Delete card
	 */
	public function deleteCardAction($id)
	{
		$reponse = $this->getService()->delete($id);
        return $this->reponse(array($reponse));
	}

	/**
	 * Return Json Reponse
	 */
	private function reponse($content)
	{
		return new JsonResponse($content);
	}

	/**
	 * Verify card before saving
	 */
	private function validateCard($data)
	{
		$errors = array();
		$failure = false;
		if (strlen($data['cardNumber']) != 16) {
        	$failure = true;
        	array_push($errors,array('error' => 'Card number is not a length number 16'));
        }
        if (strlen($data['pin']) != 4) {
        	$failure = true;
        	array_push($errors,array('error' => 'PIN is not a length number 4'));
        }
        if ($failure == true) {
        	$return = $errors;
        }
        else{
        	$return = $failure;
        }
        return $return;
	}
}
