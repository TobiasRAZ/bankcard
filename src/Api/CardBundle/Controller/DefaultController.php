<?php

namespace Api\CardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller {

    protected $_entity;

    protected function getService() {
    	return $this->loadService()->getRepo($this->_entity);
    }

    public function loadService() {
        return $this->container->get('api_card.cardservice');
    }

    public final function rootAction() {
    	return new JsonResponse(array(
				'ressources' => array(
					'api/card' => array(
						'methods' => '[GET,HEAD]',
						'desc' => 'return list of cards'
					),
					'api/card/{id}' => array(
						'methods' => '[GET,HEAD]',
						'args' => array(
							'id' => 'int'
						),
						'desc' => 'return card by id'
					),
					'api/city/add' => array(
						'methods' => '[POST]',
						'args' => array(
							'cardNumber' => 'string',
							'pin' => 'int'
						),
						'desc' => 'add card'
					),
				),
					'version' => '0.0.1'
			));
    }

    protected function generateTokrn() {
    	return $this->loadService()->generateAccessToken();
    }

    protected function findToken($entityName, $access_token) {
    	return $this->loadService()->findToken($entityName, $access_token);
    }
}
