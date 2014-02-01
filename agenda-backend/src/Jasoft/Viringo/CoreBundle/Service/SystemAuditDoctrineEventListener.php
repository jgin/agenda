<?php

namespace Jasoft\Viringo\CoreBundle\Service;

/**
 *
 * @author lvercelli<lvercelli.jasoftsolutions@gmail.com>
 * 
 * 
 */
class SystemAuditDoctrineEventListener extends \Jasoft\Viringo\CoreBundle\Service\AbstractService
    implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    
    /**
     *
     * @var SystemAuditService
     */
    private $systemAuditService;
    
    public function postPersist(\Doctrine\ORM\Event\LifecycleEventArgs $event) {
        $entity=$event->getEntity();
        if ($entity instanceof \Jasoft\Viringo\CoreBundle\Entity\SystemAudit) {
            return ;
        }
        $this->systemAuditService->registerCreateAudit($entity);
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->systemAuditService=$container->get('jasoft_viringo_security.service.system_audit');
    }

}
