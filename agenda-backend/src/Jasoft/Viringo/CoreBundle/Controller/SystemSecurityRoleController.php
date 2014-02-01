<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole;

/**
 * SystemSecurityRole controller.
 *
 * @Route("/rest/systemSecurityRole")
 */
class SystemSecurityRoleController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{

    /**
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemSecurityRoleManager
     */
    private function getSystemSecurityRoleManager() {
        return $this->get('jasoft_viringo_security.manager.system_security_role');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemSecurityGroupManager
     */
    private function getSystemSecurityGroupManager() {
        return $this->get('jasoft_viringo_security.manager.system_security_group');
    }
    
    /**
     * @Route("/searchSecurityItem.htm", name="jasoft_sec_system_security_role_search_security_item")
     * @Method("GET")
     */
    public function searchSecurityItemAction()
    {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $type=$request->query->get('type');
        $query=$request->query->get('query');
        
        $dataPage=null;
        $pageRequestData=$requestUtil->getPageRequestDataFrom($request);
        if ('group' === $type) {
            $dataPage=$this->getSystemSecurityGroupManager()->findSecurityItemPage($pageRequestData, $query);
        }
        
        return $requestUtil->defaultListJsonResponse($dataPage->getData(), $dataPage->getTotalRecords());
    }
    
    /**
     * @Route("/saveGrantedSecurityRoles.htm", name="jasoft_sec_system_security_role_save_granted_roles")
     * @Method("POST")
     */
    public function saveGrantedSecurityRolesAction() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        /* @var $groupId integer */
        $groupId=$request->request->get('groupId');
        $grantedRoles=  preg_split('/,/', $request->request->get('grantedRoles'));
        
        if (!empty($groupId)) {
            /* @var $systemSecurityGroup \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup */
            $systemSecurityGroup=$this->getSystemSecurityGroupManager()->findById($groupId);
            if (empty($systemSecurityGroup)) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('GroupId "'.$groupId. '" not found');
            }
            $result=$this->getSystemSecurityGroupManager()->saveGrantedSecurityGroupRoles($systemSecurityGroup, $grantedRoles);
            return $requestUtil->defaultSuccessJsonResponse(true, array('menus'=>$result));
        }
    }
    
}
