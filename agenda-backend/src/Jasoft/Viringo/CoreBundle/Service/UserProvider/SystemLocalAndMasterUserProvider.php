<?php

namespace Jasoft\Viringo\CoreBundle\Service\UserProvider;

/**
 * Description of SystemLocalAndMasterUserProvider
 *
 * @author lvercelli
 */
class SystemLocalAndMasterUserProvider implements \Symfony\Component\Security\Core\User\UserProviderInterface {
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Manager\SystemUserManager
     */
    private $systemUserManager;
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Manager\SystemLocalUserManager
     */
    private $systemLocalUserManager;
    
    /**
     *
     * @var \Jasoft\Viringo\MasterBundle\Service\LdapManager
     */
    private $masterLdapManager;
    
//    function __construct(\Jasoft\Viringo\CoreBundle\Manager\SystemUserManager $systemUserManager, \Jasoft\Viringo\CoreBundle\Manager\SystemLocalUserManager $systemLocalUserManager, \Jasoft\Viringo\MasterBundle\Service\LdapManager $masterLdapManager) {
    function __construct(\Jasoft\Viringo\CoreBundle\Manager\SystemUserManager $systemUserManager, \Jasoft\Viringo\CoreBundle\Manager\SystemLocalUserManager $systemLocalUserManager) {
        $this->systemUserManager = $systemUserManager;
        $this->systemLocalUserManager = $systemLocalUserManager;
//        $this->masterLdapManager = $masterLdapManager;
    }

    public function loadUserByUsername($username) {
        $systemUser=$this->systemUserManager->getSystemUserByName($username);
        if (empty($systemUser) || !$systemUser->isActive()) {
            throw new \Symfony\Component\Security\Core\Exception\UsernameNotFoundException();
        }
//        if (\Jasoft\Viringo\CoreBundle\Manager\SystemUserTypeManager::isMasterUserType($systemUser->getUserType())) {
//            $ldap=$this->masterLdapManager->findLdapByStaffLogin($username);
//            
//            if (empty($ldap)) {
//                throw new \Symfony\Component\Security\Core\Exception\UsernameNotFoundException();
//            }
//            
//            $systemUser->setPassword($ldap->getPassword());
//        }
        if (\Jasoft\Viringo\CoreBundle\Manager\SystemUserTypeManager::isLocalUserType($systemUser->getUserType())) {
            $systemLocalUser=$this->systemLocalUserManager->getSystemLocalUserByName($systemUser->getUsername());
            
            $systemUser->setPassword($systemLocalUser->getPassword());
        }
        $systemUser->setSalt(null);
        
        $systemUser->setRoles($this->getRolesArrayOf($systemUser));
        
        return $systemUser;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUser $systemUser
     */
    private function getRolesArrayOf($systemUser) {
        $roles=array();
        $systemSecurityGroupRoles=$this->systemUserManager->getAllOrderedSecurityRolesOf($systemUser);
        /* @var $ssgr \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole */
        foreach ($systemSecurityGroupRoles as $ssgr) {
            $roles[]=$ssgr->getRoleName();
        }
        
        return $roles;
    }

    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user) {
        if (!($user instanceof \Jasoft\Viringo\CoreBundle\Entity\SystemUser)) {
            throw new \Symfony\Component\Security\Core\Exception\UnsupportedUserException();
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class === 'Jasoft\Viringo\CoreBundle\Entity\SystemUser';
    }

}
