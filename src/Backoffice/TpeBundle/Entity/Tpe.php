<?php
namespace Backoffice\TpeBundle\Entity;

class Tpe
{
	
	protected $imei;

	protected $mac;


	public function getImei()
	{
		return $this->imei;
	}

	public function setImei($imei)
	{
		$this->imei = $imei;
	}

	public function getMac()
	{
		return $this->mac;
	}

	public function setMac($mac)
	{
		$this->mac = $mac;
	}
}