<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup;

/**
 * SystemSecurityGroup controller.
 *
 * @Route("/rest/systemSecurityGroup")
 */
class SystemSecurityGroupController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{

    /**
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemSecurityGroupManager
     */
    private function getSystemSecurityGroupManager() {
        return $this->get('jasoft_viringo_core.manager.system_security_group');
    }
    
    /**
     * Lists all SystemSecurityGroup entities.
     *
     * @Route("/list.htm", name="jasoft_sec_system_security_group_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $pageRequestData=$requestUtil->getPageRequestDataFrom($request);
        $dataPage=$this->getSystemSecurityGroupManager()->findPageFrom($pageRequestData);
        
        return $requestUtil->defaultListJsonResponse($dataPage->getData(), $dataPage->getTotalRecords());
    }

    /**
     * Lists all SystemSecurityGroup entities.
     *
     * @Route("/listAll.htm", name="jasoft_sec_system_security_group_list_all")
     * @Method("GET")
     */
    public function listAllAction() {
        $requestUtil=$this->getRequestUtil();
        $data=$this->getSystemSecurityGroupManager()->select(true);
        return $requestUtil->defaultJsonResponse($data);
    }
    
    /**
     * @Route("/register.htm", name="jasoft_sec_system_security_group_register")
     * @Method("POST")
     */
    public function register() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $systemUser=new SystemSecurityGroup();
        $requestUtil->populateEntityFromRequest($request, $systemUser);
        
        try {
            $this->getSystemSecurityGroupManager()->registerAndFlush($systemUser);
        } catch (\Jasoft\Viringo\CoreBundle\Exception\GenericException $ge) {
            return $requestUtil->defaultErrorMessage($ge->getMessage());
        }
        
        return $requestUtil->defaultSuccessJsonResponse();
    }
    
    /**
     * @Route("/update.htm", name="jasoft_sec_system_security_group_update")
     * @Method("POST")
     */
    public function updateAction() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $id=$request->request->get('id');
        $money=$this->getSystemSecurityGroupManager()->findById($id);
        $requestUtil->populateEntityFromRequest($request, $money);
        
        try {
            $this->getSystemSecurityGroupManager()->updateAndFlush($money);
        } catch (\Jasoft\Viringo\CoreBundle\Exception\GenericException $ge) {
            return $requestUtil->defaultErrorMessage($ge->getMessage());
        }
        
        return $requestUtil->defaultSuccessJsonResponse();
    }
    
    /**
     * @Route("/delete.htm", name="jasoft_sec_system_security_group_delete")
     * @Method("POST")
     */
    public function deleteAction() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $id=$request->request->get('id');
        
        $this->getSystemSecurityGroupManager()->softDeleteByIdAndFlush($id);
        
        return $requestUtil->defaultSuccessJsonResponse();
    }
    
    /**
     * @Route("/activate.htm", name="jasoft_sec_system_security_group_activate")
     * @Method("POST")
     */
    public function activateAction() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $id=$request->request->get('id');
        
        $this->getSystemSecurityGroupManager()->activateByIdAndFlush($id);
        
        return $requestUtil->defaultSuccessJsonResponse();
    }
}
