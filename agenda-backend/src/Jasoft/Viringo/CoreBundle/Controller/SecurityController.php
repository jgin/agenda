<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{
    
    /**
     * @return \Jasoft\Viringo\CoreBundle\Service\SystemSecurityService
     */
    protected function getSystemSecurityService() {
        return $this->container->get('jasoft.security');
    }
    
    /**
     * @return \Jasoft\Viringo\CoreBundle\Service\SystemSecurityMenuRoleService
     */
    protected function getSystemSecurityMenuRoleService() {
        return $this->container->get('jasoft_viringo_security.service.system_security_menu_role');
    }
    
    /**
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemSecurityEntityRoleManager
     */
    protected function getSystemSecurityEntityRoleManager() {
        return $this->container->get('jasoft_viringo_security.manager.system_security_entity_role');
    }
    
    /**
     * @Route("/login", name="_jasoft_viringo_security_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }

    /**
     * @Route("/login_check", name="_jasoft_viringo_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="_jasoft_viringo_security_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
    
    /**
     * @Route("/rest/security/listAllowedMenus.htm", name="_jasoft_viringo_security_list_allowed_menus")
     * @Method("GET")
     */
    public function listAllowedMenusAction() {
        $menus=array('root'=>$this->getSystemSecurityMenuRoleService()->getAlowedMenus()->getChildren());
        return $this->getRequestUtil()->defaultSuccessJsonResponse(true, $menus);
    }
    
    /**
     * Lista los permisos del usuario actual para la entidad solicitada
     *
     * @Route("/rest/systemSecurityRole/getGrantedEntityRoles.htm")
     * @Method("GET")
     */
    public function getGrantedEntityRolesAction() {
        $requestUtil=$this->getRequestUtil();
        $request=$this->getRequest();
        
        $entityName=$request->query->get('entityName');
        $data = $this->getSystemSecurityEntityRoleManager()->getGrantedEntityRoles($entityName);
        
        return $requestUtil->defaultSuccessJsonResponse(true, array('data'=>$data));
    }
    
}
