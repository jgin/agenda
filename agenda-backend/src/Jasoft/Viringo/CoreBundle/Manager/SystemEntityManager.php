<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * Description of SystemEntityService
 *
 * @author lvercelli
 */
class SystemEntityManager extends AbstractManager {
    
    /**
     *
     * @var array
     */
    private $exceptionArray;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct(\Doctrine\ORM\EntityManager $entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemEntity');
        $this->exceptionArray=array();
    }

    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemEntityRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }

    
    public function loadSystemEntities() {
        $em=$this->entityManager;
        $allMD=$em->getMetadataFactory()->getAllMetadata();
        $entities=array();
        
        /* @var $md \Doctrine\Common\Persistence\Mapping\ClassMetadata */
        foreach ($allMD as $md) {//            if (array_search($md->getName(), self::$exceptions)===false) {
            if (array_search($md->getName(), $this->exceptionArray)===false) {
                $entities[]=$md->getName();
            }
        }
        
        return $entities;
    }
    
    public static function createNewSystemEntity($name, $caption) {
        $se=new \Jasoft\Viringo\CoreBundle\Entity\SystemEntity();
        $se->setName($name)
                ->setCaption($caption)
        ;
        return $se;
    }
    
    /**
     * 
     * @param string $entityName
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemEntity
     */
    public function getPersisted($entityName) {
        $se=$this->getRepository()->findOneByName($entityName);
        if (empty($se)) {
            $se=self::createNewSystemEntity($entityName, $entityName);
            $this->registerAndFlush($se);
        }
        return $se;
    }
    
    /**
     * 
     * @param string $name
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemEntity
     */
    public function findByName($name) {
        return $this->repository->findOneByName($name);
    }
    
    public function registerAllEntities() {
        $entityNames=$this->loadSystemEntities();
        $this->getRepository()->resetAllEntities();
        
        foreach ($entityNames as $entityName) {
            $systemEntity=$this->findByName($entityName);
            if (empty($systemEntity)) {
                $systemEntity=self::createNewSystemEntity($entityName, $entityName);
                $this->register($systemEntity);
            } else {
                $systemEntity->setActive(true);
            }
        }
        $this->flushEntityManager();
    }
    
    /**
     * 
     * @param string $className Nombre de la clase a no tener en cuenta como entidad en la base de datos
     */
    public function addEntityClassException($className) {
        $this->exceptionArray[]=$className;
    }

}
