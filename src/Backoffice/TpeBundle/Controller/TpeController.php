<?php

namespace Backoffice\TpeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Backoffice\TpeBundle\Controller\DefaultController;
use Backoffice\TpeBundle\Entity\Tpe;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class TpeController extends DefaultController
{
    /**
     * @Route("tpe/", name="tpe_list")
     */
    public function indexAction()
    {

    	$tpelist = $this->getAllTpe();

        return $this->render('BackofficeTpeBundle:Tpe:index.html.twig', array(
            'tpelist' => $tpelist
        ));
    }

    /**
     * @Route("tpe/add", name="tpe_add")
     */
    public function addAction(Request $req)
    {
    	$tpe = new Tpe();


    	$form = $this->createFormBuilder($tpe)
    		->add('imei', TextType::class)
            ->add('mac', TextType::class)
    		// ->add('active', RadioType::class)
    		->add('save', SubmitType::class)
    		->getForm();

		$form->handleRequest($req);

		if ($form->isSubmitted() /*&& $form->isValid()*/) {
			$tpe = $form->getData();

			$params = array(
				'imei' =>  $tpe->getImei(), 
				'mac' => $tpe->getMac(),
                'active' => false
			);

			$data  = array(
				'params' => $params
			);

			$message = $this->addtpe($data);

			// var_dump($message); die;

            return $this->redirectToRoute('tpe_list');

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

        // var_dump($message); die;

        return $this->redirectToRoute('tpe_list');
        

    }

    
    /**
     * @Route("/tpe/desactivate/{id}", name="desactivate_tpe")
     */
    public function desactivateAction($id)
    {
        $params = array(
            'id' => $id
        );

        $message = $this->desactivateTpe($params);

        // var_dump($message); die;

        return $this->redirectToRoute('tpe_list');
        

    }

    /**
     * @Route("/tpe/delete/{id}", name="delete_tpe")
     */
    public function deleteAction($id)
    {
        $params = array(
            'id' => $id
        );

        $message = $this->deleteTpe($params);

        // var_dump($message); die;

        return $this->redirectToRoute('tpe_list');
        

    }

    
    /**
     * @Route("/tpe/{id}", name="tpe_getbyid")
     */
    public function getByIdAction($id)
    {
        $params = array(
            'id' => $id
        );

        $message = $this->getTpe($params);

        return $message;
        // var_dump($message); die;
    }

    /**
     * @Route("/tpe/edit/{id}", name="tpe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id, Request $req)
    {
        $tpe = new Tpe($this->getByIdAction($id)->data);

        $form = $this->createFormBuilder($tpe)
            ->add('imei', TextType::class)
            ->add('mac', TextType::class)
            // ->add('active', RadioType::class)
            // ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($req); 

        if ($form->isSubmitted() /*&& $form->isValid()*/) {

            $params = array(
                'imei' =>  $tpe->getImei(), 
                'mac' => $tpe->getMac(),
                'id' => $id
            );

            $data  = array(
                'params' => $params
            );

            $message = $this->updateTpe($data);

            return $this->redirectToRoute('tpe_list');

        }

        return $this->render('BackofficeTpeBundle:Tpe:edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $id
        ));

    }



}
