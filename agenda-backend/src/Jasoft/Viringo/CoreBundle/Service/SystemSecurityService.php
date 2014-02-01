<?php

namespace Jasoft\Viringo\CoreBundle\Service;

/**
 * Description of SystemSecurityService
 *
 * @author lvercelli<lvercelli.jasoftsolutions@gmail.com>
 * 
 */
class SystemSecurityService extends \Jasoft\Viringo\CoreBundle\Service\AbstractService {
    
    const ROLE_SUPER_ADMIN="ROLE_SUPER_ADMIN";
    const SUPER_ADMIN_USER_NAME='sa';
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
     * TODO: Tomar el usuario desde base de datos
     */
    public function getCurrentUser() {    
        $token=$this->securityContext->getToken();
        if (empty($token)) {
            return null;
        }
        /* @var $currentUser \Jasoft\Viringo\CoreBundle\Entity\SystemUser */
        $currentUser=$this->securityContext->getToken()->getUser();
        $currentUser->eraseCredentials();
        return $currentUser;
    }

    /**
     * @return string
     */
    public function getCurrentUserName() {
        $token=$this->securityContext->getToken();
        if (empty($token)) {
            return "";
        }
        return $token->getUsername();
    }
    
    public function hasRole($roleName) {
        /* @var $roles \Symfony\Component\Security\Core\Role\RoleInterface[] */
        $roles=$this->securityContext->getToken()->getRoles();
        
        // Se asume que el array está ordenado ascendentemente
        $rsaPos=self::binarySearchRoles($roles, self::ROLE_SUPER_ADMIN);
        if (isset($rsaPos)) {
            return true;
        }
        
        $position=self::binarySearchRoles($roles, $roleName);
        return isset($position);
    }
    
    private static function binarySearchRoles($roles, $roleName) {
        if (empty($roles) || count($roles)==0) {
            return null;
        }
        
        $low=0;
        $high=count($roles)-1;
        while ($high>=$low) {
            $probe=floor(($high+$low)/2);
            $comparison=strcasecmp($roleName, $roles[$probe]->getRole());
            if ($comparison<0) {
                $high=$probe-1;
            } else if ($comparison>0) {
                $low=$probe+1;
            } else {
                return $probe;
            }
        }
        
        return null;
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
        $hasRoleSuperAdmin=\Jasoft\Viringo\CoreBundle\Util\ArrayUtil::binarySearch($roles, self::ROLE_SUPER_ADMIN);
        if (isset($hasRoleSuperAdmin)) {
            return true;
        }
        
        $exist=\Jasoft\Viringo\CoreBundle\Util\ArrayUtil::binarySearch($roles, $roleName);
        if (isset($exist)) {
            return true;
        }
        
        return false;
    }
    
    public function getAlowedMenus() {
        $rootMenu=$this->getRootMenu();
        $this->filterAllowedMenus($rootMenu);
    }
    
    /**
     * 
     * @param SystemMenu $rootMenu
     */
    private function filterAllowedMenus($rootMenu) {
        $allowedSubmenus=array();
        foreach ($rootMenu->getChildren() as $subMenu) {
            if ($this->securityService->hasRole($subMenu->getRoleName())) {
                $this->filterAllowedMenus($subMenu);
                $allowedSubmenus[]=$subMenu;
            }
        }
        $rootMenu->setChildren($allowedSubmenus);
    }
    
    public function hasRoleSuperAdmin() {
        return $this->hasRole(self::ROLE_SUPER_ADMIN);
    }
    
}
