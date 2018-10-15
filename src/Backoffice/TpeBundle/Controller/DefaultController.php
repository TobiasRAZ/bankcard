<?php

namespace Backoffice\TpeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Api\CardBundle\Controller;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {


    	//new \TpeController();

    	//$this->get('http://127.0.0.1:8000/api');

        return $this->render('BackofficeTpeBundle:Default:index.html.twig');
    }
}
