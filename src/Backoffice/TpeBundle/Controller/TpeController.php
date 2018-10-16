<?php

namespace Backoffice\TpeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Backoffice\TpeBundle\Controller\DefaultController;
use Backoffice\TpeBundle\Entity\Tpe;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class TpeController extends DefaultController
{
    /**
     * @Route("tpe/")
     */
    public function indexAction()
    {

    	$tpelist = $this->getAllTpe();

        return $this->render('BackofficeTpeBundle:Tpe:index.html.twig', array(
            'tpelist' => $tpelist
        ));
    }

    /**
     * @Route("tpe/add")
     */
    public function addAction(Request $req)
    {
    	$tpe = new Tpe();


    	$form = $this->createFormBuilder($tpe)
    		->add('imei', TextType::class)
    		->add('mac', TextType::class)
    		->add('save', SubmitType::class,array('label' => 'Save TPE'))
    		->getForm();

		$form->handleRequest($req);

		if ($form->isSubmitted() && $form->isValid()) {
			$tpe = $form->getData();


			$params = array(
				'imei' =>  $tpe->getImei(), 
				'mac' => $tpe->getMac()
			);

			$data  = array(
				'params' => $params
			);

			$message = $this->addtpe($data);

			var_dump($message); die;

		}

		return $this->render('BackofficeTpeBundle:Tpe:add.html.twig', array(
			'form' => $form->createView()
		));
    }

    
    /**
     * @Route("/tpe/activate/{id}", name="activate_tpe")
     */
    public function activateAction($id)
    {
        $params = array(
            'id' => $id
        );

        $message = $this->activateTpe($params);

        var_dump($message); die;

    }

}
