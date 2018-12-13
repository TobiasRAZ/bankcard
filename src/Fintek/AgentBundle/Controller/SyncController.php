<?php

namespace Fintek\AgentBundle\Controller;

use Fintek\AgentBundle\Entity\Sync;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
