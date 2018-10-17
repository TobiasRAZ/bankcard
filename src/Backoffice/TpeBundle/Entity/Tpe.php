<?php
namespace Backoffice\TpeBundle\Entity;

class Tpe
{
	
	protected $imei;

	protected $mac;

	protected $active;


	function __construct($object = null)
	{
		if ($object) {
			$this->setImei($object->imei);
			$this->setMac($object->mac);
			$this->setActive($object->active);
		}
	}


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

	public function getActive()
	{
		return $this->active;
	}

	public function setActive($active)
	{
		$this->active = $active;
	}
}