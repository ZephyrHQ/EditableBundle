<?php

namespace Zephyr\EditableBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zephyr\EditableBundle\Entity\Content;

/**
 * Content controller.
 *
 * @Route("/content")
 */
class ContentController extends Controller
{
    /**
     * Lists all Content entities.
     *
     * @Route("/", name="admin_content_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('zephyr_editable.datatable.content');
        $datatable->buildDatatable();

        return $this->render('ZephyrEditableBundle:Content:index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="admin_content_results")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('zephyr_editable.datatable.content');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new Content entity.
     *
     * @Route("/new", name="admin_content_new", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $content = new Content();
        $form = $this->createForm('Zephyr\EditableBundle\Form\ContentType', $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($content);
            $em->flush();

            return $this->redirectToRoute('admin_content_show', array('id' => $content->getId()));
        }

        return $this->render('ZephyrEditableBundle:Content:new.html.twig', array(
            'content' => $content,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Content entity.
     *
     * @Route("/{id}", name="admin_content_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Content $content)
    {
        $deleteForm = $this->createDeleteForm($content);

        return $this->render('ZephyrEditableBundle:Content:show.html.twig', array(
            'content' => $content,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Content entity.
     *
     * @Route("/{id}/edit", name="admin_content_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Content $content)
    {
        $deleteForm = $this->createDeleteForm($content);
        $editForm = $this->createForm('Zephyr\EditableBundle\Form\ContentType', $content);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($content);
            $em->flush();

            return $this->redirectToRoute('admin_content_edit', array('id' => $content->getId()));
        }

        return $this->render('ZephyrEditableBundle:Content:edit.html.twig', array(
            'content' => $content,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Content entity.
     *
     * @Route("/{id}", name="admin_content_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Content $content)
    {
        $form = $this->createDeleteForm($content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($content);
            $em->flush();
        }

        return $this->redirectToRoute('admin_content_index');
    }

    /**
     * Creates a form to delete a Content entity.
     *
     * @param Content $content The Content entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Content $content)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_content_delete', array('id' => $content->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
