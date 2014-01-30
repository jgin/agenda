<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jasoft\Viringo\CoreBundle\Entity\SystemEntityRole;
use Jasoft\Viringo\CoreBundle\Form\SystemEntityRoleType;

/**
 * SystemEntityRole controller.
 *
 * @Route("/rest/systemSecurityEntityRole")
 */
class SystemSecurityEntityRoleController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{

    /**
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemSecurityEntityRoleManager
     */
    private function getSystemSecurityEntityRoleManager() {
        return $this->get('jasoft_viringo_core.manager.system_security_entity_role');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemSecurityGroupManager
     */
    private function getSystemSecurityGroupManager() {
        return $this->get('jasoft_viringo_core.manager.system_security_group');
    }
    
    /**
     * Lists all SystemEntityRole entities.
     *
     * @Route("/list.htm", name="jasoft_sec_entity_role_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $pageRequestData=$requestUtil->getPageRequestDataFrom($request);
        $dataPage=$this->getSystemSecurityEntityRoleManager()->findPageFrom($pageRequestData);
        
        return $requestUtil->defaultListJsonResponse($dataPage->getData(), $dataPage->getTotalRecords());
    }
    
    /**
     * @Route("/getVerifiedEntityRoles.htm", name="_jasoft_viringo_core_entity_role_get_verified_entity_roles")
     * @Method("GET")
     */
    public function getVerifiedEntityRolesAction() {
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
            $result=$this->getSystemSecurityEntityRoleManager()->getVerifiedEntityRoles($systemSecurityGroup);
            return $requestUtil->defaultSuccessJsonResponse(true, array('entities'=>$result));
        }
    }
}
