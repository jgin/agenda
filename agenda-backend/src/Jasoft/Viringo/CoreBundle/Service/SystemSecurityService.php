<?php

namespace Jasoft\Viringo\CoreBundle\Service;

/**
 * Description of SystemSecurityService
 *
 * @author lvercelli<lvercelli.jasoftsolutions@gmail.com>
 * 
 */
class SystemSecurityService extends \Jasoft\Viringo\CoreBundle\Service\AbstractService {
    
    const ROLE_SUPERADMIN="ROLE_SUPERADMIN";
//    const ROLE_USER="ROLE_SUPERADMIN";
    
    /**
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    private $securityContext;
    
    /**
     * 
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $security
     */
    function __construct($securityContext) {
        $this->securityContext=$securityContext;
    }

    /**
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemUser Usuario actual logeado
     */
    public function getCurrentUser() {    
        /* @var $currentUser \Jasoft\Viringo\CoreBundle\Entity\SystemUser */
        $currentUser=$this->securityContext->getToken()->getUser();
        $currentUser->eraseCredentials();
        return $currentUser;
    }
    
    /**
     * 
     * @param Domain\RoleCapable $roleCapable
     * @param string $roleName
     * @return boolean
     */
    public function itemHasRole($roleCapable, $roleName) {
        $roles=$roleCapable->getOrderedRoles();
        if (empty($roles) || !is_array($roles) || count($roles)==0) { 
            return false;
        }
        
        /* Si es superadmin tiene todos los permisos */
        $hasRoleSuperAdmin=\Jasoft\Viringo\CoreBundle\Util\ArrayUtil::binarySearch($roles, self::ROLE_SUPERADMIN);
        if (isset($hasRoleSuperAdmin)) {
            return true;
        }
        
        $exist=\Jasoft\Viringo\CoreBundle\Util\ArrayUtil::binarySearch($roles, $roleName);
        if (isset($exist)) {
            return true;
        }
        
        return false;
    }
    
}
