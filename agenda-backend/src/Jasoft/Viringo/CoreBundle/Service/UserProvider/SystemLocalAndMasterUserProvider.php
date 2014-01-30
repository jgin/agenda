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
     * @var \Jasoft\Viringo\MasterBundle\Service\LdapManager
     */
    private $masterLdapManager;
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Manager\SystemUserManager $systemUserManager
     * @param \Jasoft\Viringo\MasterBundle\Service\LdapManager $masterLdapManager
     */
    function __construct(\Jasoft\Viringo\CoreBundle\Manager\SystemUserManager $systemUserManager, \Jasoft\Viringo\MasterBundle\Service\LdapManager $masterLdapManager) {
        $this->systemUserManager = $systemUserManager;
        $this->masterLdapManager = $masterLdapManager;
    }

    public function loadUserByUsername($username) {
        $systemUser=$this->systemUserManager->getSystemUserByName($username);
        if (empty($systemUser) || !$systemUser->isActive()) {
            throw new \Symfony\Component\Security\Core\Exception\UsernameNotFoundException();
        }
        if (\Jasoft\Viringo\CoreBundle\Manager\SystemUserTypeManager::isMasterUserType($systemUser->getUserType())) {
            $ldap=$this->masterLdapManager->findLdapByStaffLogin($username);
            
            $systemUser->setSalt(null);
            $systemUser->setPassword($ldap->getPassword());
        }
        if (\Jasoft\Viringo\CoreBundle\Manager\SystemUserTypeManager::isLocalUserType($systemUser->getUserType())) {
            
        }
        
        $roles=array();
        
        
        return $systemUser;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUser $systemUser
     */
    private static function getRolesArrayOf($systemUser) {
//        $systemUser->getSecurityGroups()
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
