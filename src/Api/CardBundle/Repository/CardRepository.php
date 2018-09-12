<?php

namespace Api\CardBundle\Repository;
use Api\CardBundle\Entity\Card;

/**
 * cardRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CardRepository extends \Doctrine\ORM\EntityRepository
{
	public function getAll()
	{
		return $this
			->createQueryBuilder('c')
		    ->getQuery()
		    ->getArrayResult();
	}

	public function getById($id) {
	    return $this
		    ->createQueryBuilder('c')
		    ->where("c.id = :id")
		    ->setParameter('id', $id)
		    ->getQuery()
		    ->getArrayResult();
	}

	public function add($data) {
		$em = $this->_em;
		$em->persist($data);
		$em->flush();
		if(null !== $data->getId()) return 1;
	}
}
