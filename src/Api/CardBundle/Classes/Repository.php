<?php

namespace Api\CardBundle\Classes;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\ORMException;
use PDOException;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * 
 */
abstract class Repository extends \Doctrine\ORM\EntityRepository
{
	
	public function getAll()
	{
		# code...
	}

	public function getById($id)
	{
		# code...
	}

	public function add($data)
	{
		# code...
	}

	abstract public function update($data)
	{
		# code...
	}

	public function delete($id)
	{
		# code...
	}
}