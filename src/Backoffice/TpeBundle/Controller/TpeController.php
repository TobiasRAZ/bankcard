<?php

namespace Backoffice\TpeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Backoffice\TpeBundle\Controller\DefaultController;

class TpeController extends DefaultController
{
    /**
     * @Route("tpe/")
     */
    public function indexAction()
    {

    	$allTpe = $this->getAllTpe();

        return $this->render('BackofficeTpeBundle:Tpe:index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("tpe/add")
     */
    public function addAction()
    {
    	
    }

}
