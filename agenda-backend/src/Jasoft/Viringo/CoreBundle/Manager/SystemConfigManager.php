<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * @author gin
 */
class SystemConfigManager extends AbstractManager {
    
    const MASTER_CONNECTION_URL="master.connection.url";
    
    function __construct(\Doctrine\ORM\EntityManager $entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemConfig');
    }
    
    public function register($entity) {
        $this->validateDuplicate($entity);
        parent::register($entity);
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemConfig $entity
     * @param boolean $exclude Indica si la entidad actual se debe excluir de la búsqueda
     *                          (falso por defecto, lo cual significa que se usaría en una inserción)
     */
    public function validateDuplicate($entity, $exclude=false) {
        $errors=$this->getDuplicates($entity, $exclude);
        if (count($errors) > 0) {
            $message="Error: ";
            if(in_array(1,$errors)){
                $message=$message." Nombre Duplicado,";
            }
            if(in_array(2,$errors)){
                $message=$message." en un registro inactivo,";
            }
            $message= substr($message, 0,-1);
            throw new \Jasoft\Viringo\CoreBundle\Exception\DuplicateEntityException($message);
        }
    }
    
    public function getDuplicates($entity,$exclude=false){   
        $errors=array();
        $duplicateEntity=$this->getRepository()->findDuplicates($entity, $exclude);
        if($duplicateEntity!=null){
            if($duplicateEntity->getName()==$entity->getName()){
                array_push($errors,1);
            }
            if(!$duplicateEntity->isActive()){
               array_push($errors,2);  
            }
        }
        return $errors;
    }
    /**
     * 
     * @param type $name
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemConfig
     */
    public function getSystemConfigByName($name) {
        $result=$this->repository->findOneBy(array('name'=>$name));
        if (empty($result)) {
            throw new \Jasoft\Viringo\CoreBundle\Exception\UndefinedSystemConfigParamException();
        }
        return $result;
    }
    
    /**
     * 
     * @param type $name
     * @return integer
     */
    public function getIntConfigValueByName($name) {
        return $this->getSystemConfigByName($name)->getIntValue();
    }
    
    /**
     * 
     * @param type $name
     * @return string
     */
    public function getTextConfigValueByName($name) {
        return $this->getSystemConfigByName($name)->getTextValue();
    }
    
    
    ///////////////////////////
    /// Getters y Setters
    ///////////////////////////
    
    public function getSystemConfigRepository() {
        return $this->repository;
    }

    public function setSystemConfigRepository(\Jasoft\Viringo\CoreBundle\Repository\SystemConfigRepository $systemConfigRepository) {
        $this->repository = $systemConfigRepository;
    }
}
