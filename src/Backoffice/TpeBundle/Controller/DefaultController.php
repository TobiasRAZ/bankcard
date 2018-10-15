<?php

namespace Backoffice\TpeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Api\CardBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;



class DefaultController extends Controller
{
    	/*$reponse = $this->forward('ApiCardBundle:Tpe:index')->getContent();*/
	    
    public function getAllTpe()
    {
        $response = $this->forward('ApiCardBundle:Tpe:index')->getContent();

        if (json_decode($response)->status == 204) {            
            return $response;
        }

        else{
            $allTpe= $this->forwrdTpeController('index')->data;
            return $allTpe;
        }

    }

    protected function forwrdTpeController($action, $data = null)
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
