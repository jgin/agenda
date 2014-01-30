<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * @author gin
 */
class SystemUserTypeManager extends AbstractManager {
    
    const USER_TYPE_MASTER='master';
    const USER_TYPE_LOCAL='local';
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemUserType');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemUserTypeRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUserType $entity
     */
    public function exists($entity) {
        return $this->getRepository()->exists($entity);
    }
    
    /**
     * 
     * @param string $name
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemUserType
     */
    public function findByName($name) {
        return $this->getRepository()->findOneByName($name);
    }
    
    /**
     * 
     * @param string $name
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemUserType
     */
    public function getPersisted($name) {
        $sut=$this->findByName($name);
        if (empty($sut)) {
            $sut=new \Jasoft\Viringo\CoreBundle\Entity\SystemUserType();
            $sut->setName($name)->setCaption($name);
            $this->registerAndFlush($sut);
        }
        return $sut;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUserType $sut
     */
    public static function isMasterUserType($sut) {
        return self::USER_TYPE_MASTER===$sut->getName();
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUserType $sut
     */
    public static function isLocalUserType($sut) {
        return self::USER_TYPE_LOCAL===$sut->getName();
    }

}
