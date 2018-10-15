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
        return $this->render('BackofficeTpeBundle:Tpe:index.html.twig', array(
            // ...
        ));
    }

}
