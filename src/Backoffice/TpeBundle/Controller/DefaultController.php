<?php

namespace Backoffice\TpeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Api\CardBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;



class DefaultController extends Controller
{

    public function getAllTpe()
    {
        $response = $this->forward('ApiCardBundle:Tpe:index')->getContent();

        if (json_decode($response)->status == 204) {            
            return false;
        }

        else{
            $allTpe= $this->forwrdTpeController('index')->data;
            return $allTpe;
        }

    }


    public function addtpe($tpe)
    {
        $reponse = $this->forwrdTpeController('addTpe', $tpe);


        //var_dump($reponse);die;

        if ($reponse->status == 201) {
            return $reponse;
        }


    }

    public function activateTpe($id)
    {

        $reponse = $this->forwrdTpeController('activateTpe', $id);

        return $reponse;
    }

    public function desactivateTpe($id)
    {
        $reponse = $this->forwrdTpeController('desactivateTpe', $id);

        return $reponse;
    }

    public function deleteTpe($id)
    {
        $reponse = $this->forwrdTpeController('deleteTpe', $id);

        return $reponse;
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
                
            case 'activateTpe':
                $reponse = $this->forward("$controller$action", $data)->getContent();
                return(json_decode($reponse));
                break;
                
            case 'desactivateTpe':
                $reponse = $this->forward("$controller$action", $data)->getContent();
                return(json_decode($reponse));
                break;

            case 'deleteTpe':
                $reponse = $this->forward("$controller$action", $data)->getContent();
                return(json_decode($reponse));
                break;
        }

    }


}
