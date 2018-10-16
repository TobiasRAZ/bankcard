<?php

namespace Api\CardBundle\Repository;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Api\CardBundle\Classes\Repository;
/**
 * TpeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TpeRepository extends Repository
{



	public function desactivate($id)
	{
		$qb = $this->createQueryBuilder('c');
		$q  = $qb->update()
			->set('c.active', ':active')
			->setParameter('active', false)
			->where("c.id = :id")
			->setParameter('id', (int)$id)
			->getQuery();

		try{
			$tpe = $q->execute();
			if ($tpe == 1) {
				$message['status'] = Response::HTTP_OK;
				$message['message'] = 'Tpe desactivation successful';
			}
			else{
				$message['status'] = Response::HTTP_BAD_REQUEST;
				$message['message'] = 'Tpe is already inactive';
			}
		} catch(Exception $e){
			$message['status'] = $e->getCode();
			$message['message'] = $e->getMessage();
		}

		return $message;
	}


	public function activate($id)
	{

		$qb = $this->createQueryBuilder('c');
		$q  = $qb->update()
			->set('c.active', ':active')
			->setParameter('active', true)
			->where("c.id = :id")
			->setParameter('id', (int)$id)
			->getQuery();

		try{
			$tpe = $q->execute();
			if ($tpe == 1) {
				$message['status'] = Response::HTTP_OK;
				$message['message'] = 'Tpe activation successful';
			}
			else{
				$message['status'] = Response::HTTP_BAD_REQUEST;
				$message['message'] = 'Tpe is already active';
			}
		} catch(Exception $e){
			$message['status'] = $e->getCode();
			$message['message'] = $e->getMessage();
		}

		return $message;
	}


	public function update($data) {
	    $qb = $this->createQueryBuilder('c');
		$q = $qb->update()
		    ->set('c.imei', ':imei')
		    ->set('c.mac', ':mac')
		    ->setParameter('imei', $data['imei'])
		    ->setParameter('mac', $data['mac'])
		    ->where("c.id = :id")
		    ->setParameter('id', (int)$data['id'])
		    ->getQuery();
		try{
			$card = $q->execute();
            if ($card == 1) {
            	$message['status'] = Response::HTTP_OK;
            	$message['message'] = 'Updating successful';
            }
            else{
            	$message['status'] = Response::HTTP_BAD_REQUEST;
            	$message['message'] = 'No update made, old values and new are equal';
            }
		} catch (Exception $e){
			$message['status'] = $e->getCode();
            $message['message'] = $e->getMessage();
		}
		return $message;
	}

	function getByImei($imei)
	{
		$qb = $this->createQueryBuilder('c');
		$q = $qb->where("c.imei = :imei")
			    ->setParameter('imei', $imei)
			    ->getQuery();
		try{
			$data = $q->getArrayResult();
			if (!$data) {
				$message['status'] = Response::HTTP_NO_CONTENT;
				$message['message'] = 'Can not find an index that does not exist in the database';
				$message['data'] = null;
			}
			else{
				//$message = $card;
				$message['status'] = Response::HTTP_OK;
				$message['message'] = 'Success Request';
				$message['data'] = $data[0];
			}
		} catch (Exception $e){
			$message['status'] = $e->getCode();
            $message['message'] = $e->getMessage();
		}

		return $message;
	}

	function getByMac($mac)
	{
		$qb = $this->createQueryBuilder('c');
		$q = $qb->where("c.mac = :mac")
			    ->setParameter('mac', $mac)
			    ->getQuery();
		try{
			$data = $q->getArrayResult();
			if (!$data) {
				$message['status'] = Response::HTTP_NO_CONTENT;
				$message['message'] = 'Can not find an index that does not exist in the database';
				$message['data'] = null;
			}
			else{
				//$message = $card;
				$message['status'] = Response::HTTP_OK;
				$message['message'] = 'Success Request';
				$message['data'] = $data[0];
			}
		} catch (Exception $e){
			$message['status'] = $e->getCode();
            $message['message'] = $e->getMessage();
		}

		return $message;
	}
}
