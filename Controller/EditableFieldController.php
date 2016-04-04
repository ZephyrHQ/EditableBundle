<?php

namespace Zephyr\EditableBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sg\DatatablesBundle\Controller\EditableController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class EditableController.
 */
class EditableFieldController extends EditableController
{
    /**
     * Edit field.
     *
     * @param Request $request
     *
     * @Route("/sg/datatables/edit/field", name="sg_datatables_edit")
     * @Method("POST")
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function editAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response('Bad request', 400);
        }
        if (!$this->isCsrfTokenValid('editable', $token)) {
            throw new AccessDeniedException('The CSRF token is invalid.');
        }

        $entityName = $request->request->get('entity');
        $field = $request->request->get('name');
        $id = $request->request->get('pk');
        $token = $request->request->get('token');

        $fieldType = null;
        $getter = null;
        $setter = null;

        $em = $this->getDoctrine()->getManager();
        $metadata = $em->getClassMetadata($entityName);

        if (false !== strstr($field, '.')) {
            $parts = explode('.', $field);
            $getter = 'get'.ucfirst($parts[0]);
            $setter = 'set'.ucfirst($parts[1]);
            $targetClass = $metadata->getAssociationTargetClass($parts[0]);
            $targetMeta = $em->getClassMetadata($targetClass);
            $fieldType = $targetMeta->getTypeOfField($parts[1]);
        }

        $entity = $em->getRepository($entityName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The entity does not exist.');
        }

        $finalEntity = null === $getter ? $entity : $entity->$getter();

        if (!$this->isGranted('EDITABLE_EDIT', $finalEntity)) {
            throw $this->createAccessDeniedException();
        }

        return parent::editAction($request);
    }
}
