<?php

namespace Api\CardBundle\CardService;

class CardService {
	
	private $_em;
	private $_secret;

	public function __construct($em, $secret) {
		$this->_em = $em;
		$this->_secret = $secret;
	}

	public function getRepo($repositoryName) {
        $repo = $this->_em->getRepository("ApiCardBundle:$repositoryName");
        return $repo;
	}

	public function generateAccessToken($algo = 'haval256,5', $iteration = 300)
	{
		$digest = hash($algo, $this->_secret . microtime(), true);
		for ($i=0; $i < 300; $i++) { 
			$digest = hash($algo, $digest, true);
		}
		return base64_encode($digest);
	}

	public function findToken($entityName, $token) {
		$data = $this->getRepo($entityName)
			->findByAccessToken($token);
		$retrievedToken = "";
		foreach($data as $key=>$value) {
			$retrievedToken = $value->accessToken;
		}
		return $retrievedToken;
	}
}