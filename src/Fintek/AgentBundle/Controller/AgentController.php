<?php

namespace Fintek\AgentBundle\Controller;

use Fintek\AgentBundle\Entity\Agent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Agent controller.
 *
 * @Route("agent")
 */
class AgentController extends Controller
{
    protected function jsonResponse($status, $agents) {

        $_agents = array();
        foreach ($agents as $agent) {
            $_agents[] = $agent->toArray();
        }

        $response = new JsonResponse(array(
            "status" => $status,
            "agents" => $_agents
        ), $status);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, DELETE, PUT');
        return $response;
    }

    protected function errorResponse($message) {
        return $this->jsonResponse(400, $message);
    }

    /**
     * Lists all agent entities.
     *
     * @Route("/api/{cyclos_id}", name="api_agent_index")
     * @Method("GET")
     */
    public function ApiIndexAction($cyclos_id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FintekAgentBundle:Agent');

        if ($cyclos_id)
            $agents = $repository->findByCyclosId($cyclos_id);
        else
            $agents = $repository->findAll();

        return $this->jsonResponse(200, $agents);

        return $this->render('agent/index.html.twig', array(
            'agents' => $agents,
        ));
    }

    /**
     * Lists all agent entities.
     *
     * @Route("/", name="agent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agents = $em->getRepository('FintekAgentBundle:Agent')->findAll();

        return $this->render('agent/index.html.twig', array(
            'agents' => $agents,
        ));
    }

    /**
     * Creates a new agent entity.
     *
     * @Route("/new", name="agent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $agent = new Agent();
        $form = $this->createForm('Fintek\AgentBundle\Form\AgentType', $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agent);
            $em->flush();

            return $this->redirectToRoute('agent_show', array('id' => $agent->getId()));
        }

        return $this->render('agent/new.html.twig', array(
            'agent' => $agent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a agent entity.
     *
     * @Route("/{id}", name="agent_show")
     * @Method("GET")
     */
    public function showAction(Agent $agent)
    {
        $deleteForm = $this->createDeleteForm($agent);

        return $this->render('agent/show.html.twig', array(
            'agent' => $agent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing agent entity.
     *
     * @Route("/{id}/edit", name="agent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Agent $agent)
    {
        $deleteForm = $this->createDeleteForm($agent);
        $editForm = $this->createForm('Fintek\AgentBundle\Form\AgentType', $agent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agent_edit', array('id' => $agent->getId()));
        }

        return $this->render('agent/edit.html.twig', array(
            'agent' => $agent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a agent entity.
     *
     * @Route("/{id}", name="agent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Agent $agent)
    {
        $form = $this->createDeleteForm($agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($agent);
            $em->flush();
        }

        return $this->redirectToRoute('agent_index');
    }

    /**
     * Creates a form to delete a agent entity.
     *
     * @param Agent $agent The agent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Agent $agent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('agent_delete', array('id' => $agent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
