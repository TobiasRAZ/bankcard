<?php

namespace Api\CardBundle\FirebaseService;

class FirebaseService
{

	private $endpoint;

	public function __construct($endpoint) {
		$this->endpoint = $endpoint;
	}
	
	public function firebase()
	{
		$firebase = new \Firebase\FirebaseLib('https://fincrm-a84da.firebaseio.com', '');
		return $firebase;
	}

	public function list($reference)
	{
		return json_decode($this->firebase()->get($reference));
	}

	public function save($path,$data)
	{
		$this->firebase()->update($path,$data);
	}
}
