<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * @author gin
 */
abstract class AbstractManager extends AbstractService {
    
    /** 
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    
    /**
     *
     * @var string
     */
    protected $entityName;
    
    /**
     *
     * @var \Symfony\Component\Validator\Validator
     */
    protected $validator;
    
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Service\SystemAuditService
     */
    protected $systemAuditService;
    
    /**
     *
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $translator;


    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Repository\EntityRepository
     */
    protected $repository;
    
    function __construct(\Doctrine\ORM\EntityManager $entityManager, $entityName) {
        $this->entityManager = $entityManager;
        $this->entityName = $entityName;
        $this->repository=$this->entityManager->getRepository($entityName);
    }
    
    /**
     * @param integer $id
     * @return \Jasoft\Viringo\CoreBundle\Entity\Entity
     */
    public function findById($id) {
        return $this->repository->find($id);
    }
    
    /**
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function register($entity) {
        $active=$entity->isActive();
        if (!isset($active)) { $entity->setActive(true); }
        if (!empty($this->systemAuditService)) {
            $this->systemAuditService->auditRegisterEntity($entity);
        }
        $this->entityManager->persist($entity);
        return $entity;
    }
    
    /**
     * 
     * @param object $entity
     * @return boolean
     */
    protected function isPersistedEntity($entity) {
        return \Doctrine\ORM\UnitOfWork::STATE_MANAGED === $this->entityManager->getUnitOfWork()->getEntityState($entity);
    }
    
    /**
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function update($entity) {
        if (!$this->isPersistedEntity($entity)) {
            throw new \Jasoft\Viringo\CoreBundle\Exception\NonPersistedEntityUpdatiingException();
        }
        
        if (!empty($this->systemAuditService)) {
            $this->systemAuditService->auditUpdateEntity($entity);
        }
        return $entity;
    }
    
    /**
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function softDelete($entity) {
        $entity->setActive(false);
        if (!empty($this->systemAuditService)) {
            $this->systemAuditService->auditSoftDeleteEntity($entity);
        }
    }
    
    /**
     * @param integer $id
     */
    public function softDeleteById($id) {
        $entity=$this->findById($id);
        $this->softDelete($entity);
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function activate($entity) {
        $entity->setActive(true);
    }
    
    /**
     * 
     * @param integer $id
     */
    public function activateById($id) {
        $entity=$this->findById($id);
        $this->activate($entity);
    }
    
    public function flushEntityManager() {
        $this->entityManager->flush();
    }

    /**
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function registerAndFlush($entity) {
        $this->register($entity);
        $this->flushEntityManager();
    }

    /**
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function updateAndFlush($entity) {
        $this->update($entity);
        $this->flushEntityManager();
    }

    /**
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function softDeleteAndFlush($entity) {
        $this->softDelete($entity);
        $this->flushEntityManager();
    }

    /**
     * @param integer $id
     */
    public function softDeleteByIdAndFlush($id) {
        $this->softDeleteById($id);
        $this->flushEntityManager();
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\Entity $entity
     */
    public function activateAndFlush($entity) {
        $this->activate($entity);
        $this->flushEntityManager();
    }
    
    /**
     * 
     * @param integer $id
     */
    public function activateByIdAndFlush($id) {
        $this->activateById($id);
        $this->flushEntityManager();
    }
    
    /**
     * Método destinado a los listados para selección (como combos)
     */
    public function select($active=true, $filters=null, $sorting=null) {
//        $query=$this->findQueryBuilder($active, $filter, $sort);
        if (empty($filters)) { $filters=array(); }
        if (isset($active)) {
            $activeSearchFilter=\Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter::createEqFilter('active', $active);
            $filters[]=$activeSearchFilter;
        }
        
        return $this->repository->findData($filters, $sorting);
    }
    
    /**
     * 
     * @param boolean $active
     * @param array $filters
     * @param array $sorting
     * @param integer $pageNumber
     * @param integer $pageSize
     * @return \Jasoft\Viringo\CoreBundle\Util\DataPage
     */
    public function findPage($active=true, $filters=null, $sorting=null, $pageNumber=null, $pageSize=null) {
        if (empty($filters)) { $filters=array(); }
        
        if (!isset($active)) { $active=true; }
        $activeSearchFilter=\Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter::createEqFilter('active', $active);
        $filters[]=$activeSearchFilter;
        
        return $this->repository->findPage($filters, $sorting, $pageNumber, $pageSize);
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Util\PageRequestData $pageRequestData
     * @return \Jasoft\Viringo\CoreBundle\Util\DataPage
     */
    public function findPageFrom($pageRequestData) {
        return $this->findPage($pageRequestData->getActive(), $pageRequestData->getFilters(), 
                $pageRequestData->getSorting(), $pageRequestData->getPageNumber(), $pageRequestData->getPageSize());
    }
    
    /**
     * 
     * @param $entity
     */
    public function validateEntity($entity) {
        $errors=$this->validator->validate($entity);
        if (count($errors)>0) {
            throw new \Jasoft\Viringo\CoreBundle\Exception\EntityValidationException($errors);
        }
    }

    ///////////////////////////
    /// Getters y Setters
    ///////////////////////////
    
    public function getEntityManager() {
        return $this->entityManager;
    }

    public function getEntityName() {
        return $this->entityName;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function setEntityName($entityName) {
        $this->entityName = $entityName;
    }

    public function setRepository(\Jasoft\Viringo\CoreBundle\Repository\EntityRepository $repository) {
        $this->repository = $repository;
    }
    
    public function getValidator() {
        return $this->validator;
    }

    public function setValidator(\Symfony\Component\Validator\Validator $validator) {
        $this->validator = $validator;
    }
    
    public function getSystemAuditService() {
        return $this->systemAuditService;
    }

    public function setSystemAuditService(\Jasoft\Viringo\CoreBundle\Service\SystemAuditService $systemAuditService) {
        $this->systemAuditService = $systemAuditService;
    }
    
    public function getTranslator() {
        return $this->translator;
    }

    public function setTranslator(\Symfony\Component\Translation\TranslatorInterface $translator) {
        $this->translator = $translator;
    }    
}
