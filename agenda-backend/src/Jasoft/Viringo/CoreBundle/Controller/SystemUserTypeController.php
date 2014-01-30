<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jasoft\Viringo\CoreBundle\Entity\SystemUserType;
use Jasoft\Viringo\CoreBundle\Form\SystemUserTypeType;

/**
 * SystemUserType controller.
 *
 * @Route("/rest/systemUserType")
 */
class SystemUserTypeController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{
    
    /**
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemUserTypeManager
     */
    private function getSystemUserTypeManager() {
        return $this->get('jasoft_viringo_core.manager.system_user_type');
    }

    /**
     * Lists all SystemUserType entities.
     *
     * @Route("/listAll.htm", name="jasoft_sec_systemUserType_listAll")
     * @Method("GET")
     */
    public function listAllAction()
    {
        $requestUtil=$this->getRequestUtil();
        $data=$this->getSystemUserTypeManager()->select(true);
        return $requestUtil->defaultJsonResponse($data);
    }
    
    
    /**
     * Lists all SystemUserType entities.
     *
     * @Route("/", name="sutype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JasoftViringoCoreBundle:SystemUserType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SystemUserType entity.
     *
     * @Route("/", name="sutype_create")
     * @Method("POST")
     * @Template("JasoftViringoCoreBundle:SystemUserType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SystemUserType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sutype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a SystemUserType entity.
    *
    * @param SystemUserType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(SystemUserType $entity)
    {
        $form = $this->createForm(new SystemUserTypeType(), $entity, array(
            'action' => $this->generateUrl('sutype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SystemUserType entity.
     *
     * @Route("/new", name="sutype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SystemUserType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SystemUserType entity.
     *
     * @Route("/{id}", name="sutype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JasoftViringoCoreBundle:SystemUserType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SystemUserType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SystemUserType entity.
     *
     * @Route("/{id}/edit", name="sutype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JasoftViringoCoreBundle:SystemUserType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SystemUserType entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a SystemUserType entity.
    *
    * @param SystemUserType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SystemUserType $entity)
    {
        $form = $this->createForm(new SystemUserTypeType(), $entity, array(
            'action' => $this->generateUrl('sutype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SystemUserType entity.
     *
     * @Route("/{id}", name="sutype_update")
     * @Method("PUT")
     * @Template("JasoftViringoCoreBundle:SystemUserType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JasoftViringoCoreBundle:SystemUserType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SystemUserType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sutype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SystemUserType entity.
     *
     * @Route("/{id}", name="sutype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JasoftViringoCoreBundle:SystemUserType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SystemUserType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sutype'));
    }

    /**
     * Creates a form to delete a SystemUserType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sutype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
