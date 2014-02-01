<?php

namespace Jasoft\Viringo\CoreBundle\Service;

/**
 *
 * @author lvercelli<lvercelli.jasoftsolutions@gmail.com>
 * 
 * 
 */
class SystemAuditService extends \Jasoft\Viringo\CoreBundle\Service\AbstractService
    implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    
    const ACTION_CREATE='create';
    const ACTION_UPDATE='update';
    const ACTION_DELETE='delete';
    const ACTION_EXPORT='export';
    const ACTION_NAVIGATE='navigate';
    
    private $systemEntityArray;
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Util\RequestUtil
     */
    private $requestUtil;
    
    function __construct() {
        $this->systemEntityArray=array();
    }

    
    public function getRequestUtil() {
        return $this->requestUtil;
    }

    public function setRequestUtil(\Jasoft\Viringo\CoreBundle\Util\RequestUtil $requestUtil) {
        $this->requestUtil = $requestUtil;
    }

    /**
     * Devuelve el usuario logeado actual
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemUser
     */
    private function getCurrentSystemUserByName() {
        return $this->getSystemUserRepository()->findOneByUsername($this->getSystemSecurityService()->getCurrentUserName());
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function auditRegisterEntity($entity) {
        $entity
            ->setCreatedAt(new \DateTime())
            ->setCreatedByIp($this->requestUtil->getRemoteIpAddress())
            ->setCreatedByUser($this->getCurrentSystemUserByName())
        ;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function auditUpdateEntity($entity) {
        $entity
            ->setUpdatedAt(new \DateTime())
            ->setUpdatedByIp($this->requestUtil->getRemoteIpAddress())
            ->setUpdatedByUser($this->getCurrentSystemUserByName())
        ;
        $this->registerCrudAudit($entity, self::ACTION_UPDATE);
    }
    
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function auditSoftDeleteEntity($entity) {
        $entity
            ->setDeletedAt(new \DateTime())
            ->setDeletedByIp($this->requestUtil->getRemoteIpAddress())
            ->setDeletedByUser($this->getCurrentSystemUserByName())
        ;
        $this->registerCrudAudit($entity, self::ACTION_DELETE);
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function registerCreateAudit($entity) {
        $this->registerCrudAudit($entity, self::ACTION_CREATE);
        $this->getEntityManager()->flush();
    }
    
    public function registerCrudAudit($entity, $action) {
        $systemAudit=$this->createCrudAudit($entity, $action);
        $this->registerAudit($systemAudit);
    }
    
    /**
     * 
     * @param string $entityName
     */
    private function getSystemEntityByName($entityName) {
        $entityName=\Jasoft\Viringo\CoreBundle\Service\Domain\SystemEntityUtil::getLastPartName($entityName);
        if (!array_key_exists($entityName, $this->systemEntityArray)) {
            $this->systemEntityArray[$entityName]=$this->getSystemEntityRepository()->findOneBy(array('name'=>$entityName, 'active'=>true));
        }
        return $this->systemEntityArray[$entityName];
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemAudit
     */
    private function createCrudAudit($entity, $action) {
        $systemEntity=$this->getSystemEntityByName(get_class($entity));
        if (empty($systemEntity)) { return null; }
        
        $systemAudit=new \Jasoft\Viringo\CoreBundle\Entity\SystemAudit();
        $id=$this->getEntityManager()->getUnitOfWork()->getSingleIdentifierValue($entity);
        $systemAudit
            ->setSystemEntity($systemEntity)
            ->setActionName($action)
            ->setInstanceId($id)
        ;
        
        return $systemAudit;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemAudit $systemAudit
     */
    private function registerAudit($systemAudit) {
        if (empty($systemAudit)) { return; }
        $systemAudit
            ->setEventDate(new \DateTime())
            ->setRemoteIpAddress($this->requestUtil->getRemoteIpAddress())
            ->setSystemUser($this->getCurrentSystemUserByName())
        ;
        
        $this->getEntityManager()->persist($systemAudit);
    }
    
    public function onKernelRequest(\Symfony\Component\HttpKernel\Event\GetResponseEvent $event) {
        $req=$event->getRequest();
        $systemAudit=new \Jasoft\Viringo\CoreBundle\Entity\SystemAudit();
        $systemAudit
            ->setActionName(self::ACTION_NAVIGATE)
            ->setUrl($event->getRequest()->getUri())
        ;
        $this->registerAudit($systemAudit);
        $this->getEntityManager()->flush();
    }
    
    /**
     * 
     * @param array $filters
     * @param array $sorting
     * @param integer $pageNumber
     * @param integer $pageSize
     * @return \Jasoft\Viringo\CoreBundle\Util\DataPage
     */
    public function findPage($filters=null, $sorting=null, $pageNumber=null, $pageSize=null) {
        if (empty($filters)) { $filters=array(); }

        if (!$this->getSystemSecurityService()->hasRoleSuperAdmin()) {
            $excludeSAFilter=\Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter::createNotEqFilter('systemUser.username', SystemSecurityService::SUPER_ADMIN_USER_NAME);
            $filters[]=$excludeSAFilter;
        }
        
//        if (!isset($active)) { $active=true; }
//        $activeSearchFilter=\Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter::createEqFilter('active', $active);
//        $filters[]=$activeSearchFilter;
        
        return $this->getSystemAuditRepository()->findPage($filters, $sorting, $pageNumber, $pageSize);
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Util\PageRequestData $pageRequestData
     * @return \Jasoft\Viringo\CoreBundle\Util\DataPage
     */
    public function findPageFrom($pageRequestData) {
        return $this->findPage($pageRequestData->getFilters(), 
                $pageRequestData->getSorting(), $pageRequestData->getPageNumber(), $pageRequestData->getPageSize());
    }

    
    
    ////////////////////////////////////////////////////////////////////////////
    /////// DEPENDENCES
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container=$container;
    }
    
    /**
     * 
     * @return SystemSecurityService
     */
    protected function getSystemSecurityService() {
        return $this->container->get('jasoft.security');
    }
    
    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager() {
        return $this->container->get('doctrine.orm.entity_manager');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemEntityRepository
     */
    protected function getSystemEntityRepository() {
        return $this->getEntityManager()->getRepository('JasoftViringoCoreBundle:SystemEntity');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemUserRepository
     */
    protected function getSystemUserRepository() {
        return $this->getEntityManager()->getRepository('JasoftViringoCoreBundle:SystemUser');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemAuditRepository
     */
    protected function getSystemAuditRepository() {
        return $this->getEntityManager()->getRepository('JasoftViringoCoreBundle:SystemAudit');
    }

}
