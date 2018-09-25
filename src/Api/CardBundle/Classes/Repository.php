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
		$qb = $this->createQueryBuilder('c');
		$q = $qb->getQuery();

		try{
			$data = $q->getArrayResult();
			if (!$data) {
				$message['status'] = Response::HTTP_NO_CONTENT;
				$message['message'] = 'this index does not exist in the database';
				$data['data'] = null;
			}
			else{
				$message['status'] = Response::HTTP_OK;
				$message['message'] = 'Success Request';
				$message['data'] = $data;
			}
		} catch(Exception $e){

		}
		return $message;
	}

	public function getById($id)
	{
		$qb = $this->createQueryBuilder('c');
		$q = $qb->where("c.id = :id")
			    ->setParameter('id', $id)
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

	public function add($data)
	{
		$em = $this->_em;
		$message = array();
		try{
			$em->persist($data);
			$em->flush();
			$message['status'] = Response::HTTP_CREATED;
			$message['message'] = 'Saving successful';
		} catch (DBALException $e) {
            $message['status'] = Response::HTTP_BAD_REQUEST;
            $message['message'] = $e->getMessage();
        } catch (PDOException $e) {
            $message['status'] = Response::HTTP_BAD_REQUEST;
            $message['message'] = $e->getMessage();
        } catch (ORMException $e) {
            $message['status'] = Response::HTTP_BAD_REQUEST;
            $message['message'] = $e->getMessage();
        } catch (Exception $e) {
            $message['status'] = Response::HTTP_BAD_REQUEST;
            $message['message'] = $e->getMessage();
        }
        return $message;
	}

	abstract public function update($data);

	public function delete($id)
	{
		$qb = $this->createQueryBuilder('c')
		    ->delete()
		    ->where("c.id = :id")
		    ->setParameter('id', $id)
		    ->getQuery();
		//return $card;
		try{
			$data = $qb->execute();		
        	if ($data == 1) {
        		$message['status'] = Response::HTTP_OK;
        		$message['message'] = 'Deleting successful';
        	}
        	else{
        		$message['status'] = Response::HTTP_NO_CONTENT;
        		$message['message'] = 'Can not delete an index that does not exist in the database';
        	}
		} catch(Exception $e){
			$message['status'] = $e->getCode();
            $message['message'] = $e->getMessage();
		}
		return $message;
	}
}