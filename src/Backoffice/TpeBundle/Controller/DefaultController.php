<?php

namespace Backoffice\TpeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Api\CardBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;



class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {

    	$reponse = $this->forward('ApiCardBundle:Tpe:index')->getContent();

		var_dump($reponse);    

        return $this->render('BackofficeTpeBundle:Default:index.html.twig');
    }


    public function forwrdTpeController($action, $data = null)
    {


        $controller = 'ApiCardBundle:Tpe:';

        switch ($action) {
            case 'index':
                $reponse = $this->forward("$controller$action")->getContent();
                return json_decode($reponse);
                break;
        }

    }


}
