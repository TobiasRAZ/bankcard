<?php

namespace Fintek\AgentBundle\Controller;

use Fintek\AgentBundle\Entity\Sync;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Sync controller.
 *
 * @Route("sync")
 */
class SyncController extends Controller
{
    /**
     * Lists all sync entities.
     *
     * @Route("/", name="sync_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $syncs = $em->getRepository('FintekAgentBundle:Sync')->findAll();

        return $this->render('sync/index.html.twig', array(
            'syncs' => $syncs,
        ));
    }

    protected function curlRequest($url, $options = array(), $method = "GET") {
        $options[CURLOPT_URL] = $url;
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_CUSTOMREQUEST] = $method;
        $curl = curl_init();
        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        return json_decode($response);
    }

    protected function cyclosRequest($url, $auth, $method = "GET", $options = array()) {
        $options[CURLOPT_HTTPHEADER] = array(
            "Content-Type: application/json",
            "Authorization: Basic $auth"
          );
        return $this->curlRequest($url, $options, $method);
    }

    protected function getAccountList($auth) {
        $url = 'http://192.168.2.174:8080/cyclos/api/self/accounts';
        return $this->cyclosRequest($url, $auth);
    }

    protected function getStoriesCy($auth) {
        $account_list = $this->getAccountList($auth);
        $account = array_shift($account_list);
        $account_fintek_type_id = $account->type->id;
        $url = "http://192.168.2.174:8080/cyclos/api/self/accounts/$account_fintek_type_id/history";
        return $this->cyclosRequest($url, $auth);
    }

    protected function getStoriesMO() {
        $url = "http://192.168.2.174/miniOrchid/app/historic/api/account/1";
        $stories = $this->curlRequest($url);
        return $stories->historics;
    }

    protected function jsonResponse($status) {
        $response = new JsonResponse(array(), $status);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    protected function addCyclosHistory($payment, $auth) {
        $url = "http://192.168.2.174:8080/cyclos/api/self/payments";
        $options[CURLOPT_POSTFIELDS] = json_encode($payment);
        $response = $this->cyclosRequest($url, $auth, "POST", $options);
        //var_dump($response);
    }

    /**
     *
     * @Route("/api", name="sync_api")
     * @Method("PUT")
     */
    public function apiAction()
    {
        $fintek = new \stdClass;
        $sipem = new \stdClass;
        $fintek->auth = "ZmludGVrOmZpbnRlaw==";
        $fintek->cy_id = "5516994579231450170";
        $sipem->cy_id = "5544016176995673146";
        $sipem->auth = "c2lwZW06c2lwZW0=";

        $orchid_stories = $this->getStoriesMO();

        if (empty($orchid_stories))
            return $this->jsonResponse(204);

        $cyclos_stories = $this->getStoriesCy($fintek->auth);

        foreach ($orchid_stories as $story) {
            $payment = array(
                "amount" => $story->amount,
                "description" => $story->libelle,
                "type" => "user.trade",
                "customValues" => array(
                    "orchidHistoric" => $story->id
                )
            );
            //var_dump($story->id);
            switch ($story->libelle) {
                case 'deposit':
                    $payment["subject"] = $fintek->cy_id;
                    $this->addCyclosHistory($payment, $sipem->auth);
                    break;
                
                case 'withdrawal':
                    $payment["subject"] = $sipem->cy_id;
                    $this->addCyclosHistory($payment, $fintek->auth);
                    break;
            }
        }
        //die();
        return $this->jsonResponse(204);
    }

    /**
     * Creates a new sync entity.
     *
     * @Route("/new", name="sync_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sync = new Sync();
        $form = $this->createForm('Fintek\AgentBundle\Form\SyncType', $sync);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sync);
            $em->flush();

            return $this->redirectToRoute('sync_show', array('id' => $sync->getId()));
        }

        return $this->render('sync/new.html.twig', array(
            'sync' => $sync,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sync entity.
     *
     * @Route("/{id}", name="sync_show")
     * @Method("GET")
     */
    public function showAction(Sync $sync)
    {
        $deleteForm = $this->createDeleteForm($sync);

        return $this->render('sync/show.html.twig', array(
            'sync' => $sync,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sync entity.
     *
     * @Route("/{id}/edit", name="sync_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sync $sync)
    {
        $deleteForm = $this->createDeleteForm($sync);
        $editForm = $this->createForm('Fintek\AgentBundle\Form\SyncType', $sync);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sync_edit', array('id' => $sync->getId()));
        }

        return $this->render('sync/edit.html.twig', array(
            'sync' => $sync,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sync entity.
     *
     * @Route("/{id}", name="sync_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sync $sync)
    {
        $form = $this->createDeleteForm($sync);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sync);
            $em->flush();
        }

        return $this->redirectToRoute('sync_index');
    }

    /**
     * Creates a form to delete a sync entity.
     *
     * @param Sync $sync The sync entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sync $sync)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sync_delete', array('id' => $sync->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
