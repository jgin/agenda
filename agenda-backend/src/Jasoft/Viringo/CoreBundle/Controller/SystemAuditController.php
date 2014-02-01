<?php

namespace Jasoft\Viringo\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author lvercelli
 * 
 * @Route("/rest/systemAudit")
 */
class SystemAuditController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Service\SystemAuditService
     */
    protected $systemAuditService;
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        parent::setContainer($container);
        if (!empty($container)) {
            $this->systemAuditService=$this->container->get('jasoft_viringo_security.service.system_audit');
        }
    }

    /**
     *
     * @Route("/list.htm")
     * @Method("GET")
     */
    public function listAction()
    {
        $request=$this->getRequest();
        $requestUtil=$this->getRequestUtil();
        
        $pageRequestData=$requestUtil->getPageRequestDataFrom($request);
        $dataPage=$this->systemAuditService->findPageFrom($pageRequestData);
        
        return $requestUtil->defaultListJsonResponse($dataPage->getData(), $dataPage->getTotalRecords());
    }
}
