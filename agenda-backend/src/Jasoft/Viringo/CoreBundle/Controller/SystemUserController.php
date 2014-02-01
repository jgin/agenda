<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jasoft\Viringo\CoreBundle\Entity\SystemUser;
use Jasoft\Viringo\CoreBundle\Form\SystemUserType;

/**
 * SystemUser controller.
 *
 * @Route("/rest/systemUser")
 */
class SystemUserController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{

    /**
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemUserManager
     */
    private function getSystemUserManager() {
        return $this->get('jasoft_viringo_security.manager.system_user');
    }

    /**
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemLocalUserManager
     */
    private function getSystemLocalUserManager() {
        return $this->get('jasoft_viringo_security.manager.system_local_user');
    }
    
    /**
     * Lists all SystemUser entities.
     *
     * @Route("/list.htm", name="jasoft_sec_user_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $pageRequestData=$requestUtil->getPageRequestDataFrom($request);
        $dataPage=$this->getSystemUserManager()->findPageFrom($pageRequestData);
        
        return $requestUtil->defaultListJsonResponse($dataPage->getData(), $dataPage->getTotalRecords());
    }
    
    /**
     * @Route("/register.htm", name="jasoft_sec_system_user_register")
     * @Method("POST")
     */
    public function register() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $groupIds=json_decode($request->request->get('gridSystemSecurityGroupSelector'));
        $systemUser=new SystemUser();
        $requestUtil->populateEntityFromRequest($request, $systemUser);
        
        try {
            $this->getSystemUserManager()->registerAndFlush($systemUser);
            $this->getSystemUserManager()->setSystemUserGroups($systemUser, $groupIds);
            
            // registrar como usuario local
            $password=$request->request->get('password');
            $systemLocalUser=new \Jasoft\Viringo\CoreBundle\Entity\SystemLocalUser();
            $systemLocalUser
                ->setSystemUser($systemUser)
                ->setPassword($password)
            ;
            $this->getSystemLocalUserManager()->encodePassword($systemLocalUser);
            $this->getSystemLocalUserManager()->registerAndFlush($systemLocalUser);
        } catch (\Jasoft\Viringo\CoreBundle\Exception\GenericException $ge) {
            return $requestUtil->defaultErrorMessage($ge->getMessage());
        }
        
        return $requestUtil->defaultSuccessJsonResponse();
    }
    
    /**
     * @Route("/update.htm", name="jasoft_sec_system_user_update")
     * @Method("POST")
     */
    public function updateAction() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $id=$request->request->get('id');
        $groupIds=json_decode($request->request->get('gridSystemSecurityGroupSelector'));
        /* @var $systemUser SystemUser */
        $systemUser=$this->getSystemUserManager()->findById($id);
        $requestUtil->populateEntityFromRequest($request, $systemUser);
        
        try {
            $this->getSystemUserManager()->updateAndFlush($systemUser);
            $this->getSystemUserManager()->setSystemUserGroups($systemUser, $groupIds);
            
            // actualizar clave usuario
            $password=$request->request->get('password');
            if (!empty($password)) {
                /* @var $systemLocalUser \Jasoft\Viringo\CoreBundle\Entity\SystemLocalUser */
                try {
                    $systemLocalUser=$this->getSystemLocalUserManager()->getSystemLocalUserByName($systemUser->getUsername());
                } catch (\Doctrine\ORM\NoResultException $ex) {
                    $systemLocalUser=new \Jasoft\Viringo\CoreBundle\Entity\SystemLocalUser();
                    $systemLocalUser->setSystemUser($systemUser);
                }
                $systemLocalUser->setPassword($password);
                $this->getSystemLocalUserManager()->encodePassword($systemLocalUser);
                
                $id=$systemLocalUser->getId();
                if (empty($id)) {
                    $this->getSystemLocalUserManager()->register($systemLocalUser);
                }
                
                $this->getSystemLocalUserManager()->updateAndFlush($systemLocalUser);
            }
        } catch (\Jasoft\Viringo\CoreBundle\Exception\GenericException $ge) {
            return $requestUtil->defaultErrorMessage($ge->getMessage());
        }
        
        return $requestUtil->defaultSuccessJsonResponse();
    }
    
    /**
     * @Route("/delete.htm", name="jasoft_sec_system_user_delete")
     * @Method("POST")
     */
    public function deleteAction() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $id=$request->request->get('id');
        
        $this->getSystemUserManager()->softDeleteByIdAndFlush($id);
        
        return $requestUtil->defaultSuccessJsonResponse();
    }
    
    /**
     * @Route("/activate.htm", name="jasoft_sec_system_user_activate")
     * @Method("POST")
     */
    public function activateAction() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $id=$request->request->get('id');
        
        $this->getSystemUserManager()->activateByIdAndFlush($id);
        
        return $requestUtil->defaultSuccessJsonResponse();
    }
    
    /**
     * @Route("/listSystemSecurityGroupMembership.htm", name="jasoft_sec_system_user_list_system_security_group_membership")
     * @Method("POST")
     */
    public function listSystemSecurityGroupMembershipAction() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        $systemUserId=$request->request->get('id');
        
        $data=$this->getSystemUserManager()->listSystemSecurityGroupMembership($systemUserId);
        return $requestUtil->defaultSuccessJsonResponse(true, array('data'=>$data));
    }
}
