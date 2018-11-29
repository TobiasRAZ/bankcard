<?php

namespace Api\CardBundle\Services;

class FirebaseService
{

	private $host;

	public function __construct($host) {
		$this->host = $host;
	}
	
	public function firebase()
	{
		$firebase = new \Firebase\FirebaseLib($this->host, '');
		return $firebase;
	}

	public function accountList($reference)
	{
		return json_decode($this->firebase()->get($reference));
	}

	public function save($path,$data)
	{
		$this->firebase()->update($path,$data);
	}
}
