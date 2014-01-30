<?php

namespace Jasoft\Viringo\CoreBundle\Service;

/**
 *
 * @author lvercelli<lvercelli.jasoftsolutions@gmail.com>
 * 
 * 
 */
class SystemAuditService extends \Jasoft\Viringo\CoreBundle\Service\AbstractService {
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Util\RequestUtil
     */
    private $requestUtil;

    public function getRequestUtil() {
        return $this->requestUtil;
    }

    public function setRequestUtil(\Jasoft\Viringo\CoreBundle\Util\RequestUtil $requestUtil) {
        $this->requestUtil = $requestUtil;
    }

    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function auditRegisterEntity($entity) {
        $entity->setCreatedAt(new \DateTime());
        $entity->setCreatedByIp($this->requestUtil->getRemoteIpAddress());
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function auditUpdateEntity($entity) {
        $entity->setUpdatedAt(new \DateTime());
        $entity->setUpdatedByIp($this->requestUtil->getRemoteIpAddress());
        
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function auditSoftDeleteEntity($entity) {
        $entity->setDeletedAt(new \DateTime());
        $entity->setDeletedByIp($this->requestUtil->getRemoteIpAddress());
        
    }
    
}
