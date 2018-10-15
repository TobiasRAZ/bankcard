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

    	// $reponse = $this->forward('ApiCardBundle:Tpe:index')->getContent();

        //$allTpe= $this->forwrdTpeController('index')->data;

        //var_dump($allTpe);


        $data = array (

            'imei' => '147852',
            'mac' => '147852'
        );

        $addTpe = $this->forwrdTpeController('addTpe', $data);

        var_dump($addTpe);

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

            case 'addTpe':
                $reponse = $this->forward("$controller$action", $data)->getContent();
                return(json_decode($reponse));
                break;
        }

    }


}
