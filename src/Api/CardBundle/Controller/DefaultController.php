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
					'api/card/add' => array(
						'methods' => '[POST]',
						'args' => array(
							'cardNumber' => 'string',
							'pin' => 'int'
						),
						'desc' => 'add card'
					),
					'api/card/{id}/update' => array(
						'methods' => '[PUT]',
						'args' => array(
							'id' => 'int',
							'cardNumber' => 'string',
							'pin' => 'int',
						),
						'desc' => 'update selected card'
					),
					'api/card/{id}' => array(
						'methods' => '[DELETE]',
						'args' => array(
							'id' => 'int'
						),
						'desc' => 'remove selected card'
					),
				),
				'informations' => array(
					'api' => array(
						'description' => 'bank card API',
						'version' => '0.0.1'
					),
					'author' => array(
						'team' => 'Eqima',
						'website' => 'https://byeqima.com'
					)
				),
			));
    }

    protected function generateTokrn() {
    	return $this->loadService()->generateAccessToken();
    }

    protected function findToken($entityName, $access_token) {
    	return $this->loadService()->findToken($entityName, $access_token);
    }
}
