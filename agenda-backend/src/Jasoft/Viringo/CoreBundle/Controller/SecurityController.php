<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{
    
    /**
     * @return \Jasoft\Viringo\CoreBundle\Service\SystemMenuService
     */
    protected function getSystemMenuService() {
        return $this->container->get('jasoft_viringo_core.service.system_menu');
    }
    
    /**
     * @Route("/login", name="_jasoft_viringo_core_login")
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
     * @Route("/login_check", name="_jasoft_viringo_core_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="_jasoft_viringo_core_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
    
    /**
     * @Route("/rest/security/listAllowedMenus.htm", name="_jasoft_viringo_core_list_allowed_menus")
     * @Method("GET")
     */
    public function listAllowedMenusAction() {
        $menus=array('root'=>$this->getSystemMenuService()->getRootMenu()->getChildren());
        return $this->getRequestUtil()->defaultSuccessJsonResponse(true, $menus);
    }
}
