<?php

namespace Api\CardBundle\FirebaseService;

class FirebaseService
{
	
	public function firebase()
	{
		$firebase = new \Firebase\FirebaseLib('https://fincrm-a84da.firebaseio.com', '');
		return $firebase;
	}

	public function list($reference)
	{
		return json_decode($this->firebase()->get($reference));
	}
}
