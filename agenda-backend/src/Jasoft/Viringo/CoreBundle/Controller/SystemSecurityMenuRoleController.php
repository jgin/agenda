<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * SystemEntityRole controller.
 *
 * @Route("/rest/systemSecurityMenuRole")
 */
class SystemSecurityMenuRoleController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{

    /**
     * @return \Jasoft\Viringo\CoreBundle\Service\SystemSecurityMenuRoleService
     */
    private function getSystemSecurityMenuRoleService() {
        return $this->get('jasoft_viringo_security.service.system_security_menu_role');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemSecurityGroupManager
     */
    private function getSystemSecurityGroupManager() {
        return $this->get('jasoft_viringo_security.manager.system_security_group');
    }
    
    /**
     * @Route("/getVerifiedMenuRoles.htm", name="_jasoft_viringo_security_entity_role_get_verified_menu_roles")
     * @Method("GET")
     */
    public function getVerifiedMenuRolesAction() {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        /* @var $groupId integer */
        $groupId=$request->query->get('groupId');
        
        if (!empty($groupId)) {
            /* @var $systemSecurityGroup \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup */
            $systemSecurityGroup=$this->getSystemSecurityGroupManager()->findById($groupId);
            if (empty($systemSecurityGroup)) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('GroupId "'.$groupId. '" not found');
            }
            $result=$this->getSystemSecurityMenuRoleService()->getVerifiedMenuRoles($systemSecurityGroup);
            return $requestUtil->defaultSuccessJsonResponse(true, array('menus'=>$result));
        }
    }
}
