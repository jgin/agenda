<?php

namespace Jasoft\Viringo\CoreBundle\Service\UserProvider;

/**
 * Description of UserProvider
 *
 * @author gin
 */
class SystemUserProvider implements \Symfony\Component\Security\Core\User\UserProviderInterface {

    /**
     *
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;
    
    /**
     *
     * @var string
     */
    private $managerName;
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Manager\SystemUserManager
     */
    private $systemUserManager;
    
    /**
     *
     * @var \Symfony\Bridge\Doctrine\Security\User\EntityUserProvider
     */
    private $ystemLocalUserProvider;
    
    
    protected function getEntityManager() {
        return $this->doctrine->getManager($this->managerName);
    }


    public function loadUserByUsername($username) {
        
    }

    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user) {
        
    }

    public function supportsClass($class) {
        
    }
    
    
    public function getDoctrine() {
        return $this->doctrine;
    }

    public function getManagerName() {
        return $this->managerName;
    }

    public function setDoctrine(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine) {
        $this->doctrine = $doctrine;
    }

    public function setManagerName($managerName) {
        $this->managerName = $managerName;
    }

}
