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
		return new JsonResponse($cards);
	}

	/**
	 * Get card by id
	 */
	public function getByIdAction($id) {
		$card = $this->getService()->getById($id);
		return new JsonResponse($card);
	}

	/**
	 * Add new card
	 */
	public function addCardAction(Request $req) {
		$card = new Card();
		$card->setCardNumber($req->request->get('cardNumber'));
		$card->setPin($req->request->get('pin'));
		
		$validator = $this->get('validator');
		$errors = $validator->validate($card);

		$validationError = array();
		if (count($errors) > 0) {
			foreach ($errors->getIterator() as $key => $value) {
				$err['message'] = $value->getMessage();
				$err['parameter'] = $value->getPropertyPath();
				array_push($validationError, $err);
			}
			return new JsonResponse($validationError);
		}
		$card = $this->getService()->add($card);
		return new JsonResponse(array('success' => $card));
	}

	/**
	 * Update Card
	 */
	public function updateCardAction(Request $req, $id)
	{
		$data['id'] = $id;
        $data['cardNumber'] = $req->request->get('cardNumber');
        $data['pin'] = $req->request->get('pin');
        $card = $this->getService()->update($data);
        return new JsonResponse(array('success' => $card));
	}

	public function deleteCardAction($id)
	{
		$card = $this->getService()->delete($id);
        return new JsonResponse(array('success' => $card));
	}
}
