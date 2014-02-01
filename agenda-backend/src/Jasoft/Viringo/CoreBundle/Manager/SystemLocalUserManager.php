<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * Description of SystemLocalUserManager
 *
 * @author gin
 */
class SystemLocalUserManager extends \Jasoft\Viringo\CoreBundle\Manager\AbstractManager {
    
    /**
     *
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    private $encoderFactory;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemLocalUser');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemLocalUserRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }
    
    /**
     * 
     * @param type $userName
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemLocalUser
     */
    public function getSystemLocalUserByName($userName) {
        return $this->getRepository()->getSystemLocalUserByName($userName);
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemLocalUser $systemLocalUser
     */
    public function encodePassword($systemLocalUser) {
        $encoder=$this->encoderFactory->getEncoder($systemLocalUser->getSystemUser());
        $encodedPassword=$encoder->encodePassword($systemLocalUser->getPassword(), null);
        $systemLocalUser->setPassword($encodedPassword);
    }

    /**
     * 
     * @param type $systemUser
     */
    public function verifyDuplicate($systemUser) {
        
    }

    /**
     * 
     * @return \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    public function getEncoderFactory() {
        return $this->encoderFactory;
    }

    /**
     * 
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface $encoderFactory
     * @return \Jasoft\Viringo\CoreBundle\Manager\SystemLocalUserManager
     */
    public function setEncoderFactory(\Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface $encoderFactory) {
        $this->encoderFactory = $encoderFactory;
        return $this;
    }

}
