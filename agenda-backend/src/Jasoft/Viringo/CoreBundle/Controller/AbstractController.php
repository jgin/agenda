<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

/**
 * Description of AbstractController
 *
 * @author lvercelli
 */
class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {
    
    /**
     * @return \Jasoft\Viringo\CoreBundle\Util\RequestUtil
     */
    public function getRequestUtil() {
        return $this->get('jasoft.request');
    }
    
    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest() {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Service\ResourceLocatorService
     */
    public function getResourceLocator() {
        return $this->container->get('jasoft.resource_locator');
    }
    
    /**
     * Información de la aplicación.
     * Cargada del archivo app_parameters
     * @return array
     */
    public function getAppInfo() {
        return $this->container->getParameter('app_info');
    }
    
}
