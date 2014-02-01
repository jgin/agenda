<?php

namespace Jasoft\Viringo\CoreBundle\Service;

/**
 * @author lvercelli
 */
class SystemSecurityMenuRoleService extends \Jasoft\Viringo\CoreBundle\Service\AbstractService {
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Service\SystemMenuService
     */
    private $systemMenuService;
    
    /**
     *
     * @var SystemSecurityRoleManager
     */
    private $systemSecurityRoleManager;
    
    /**
     *
     * @var SystemSecurityService
     */
    private $securityService;
    
    /**
     * 
     * @param Domain\RoleCapable $roleCapable
     * @return Domain\GrantedSystemSecurityMenuRole
     */
    public function getVerifiedMenuRoles($roleCapable) {
        /* @var $rootMenu \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityEntityRole[] */
        $rootMenu=$this->systemMenuService->getRootMenu();
        
        $result=$this->recursiveVerifySystemMenu($rootMenu, $roleCapable);
        
        return $result;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemMenu $systemMenu
     * @param Domain\RoleCapable $roleCapable
     * @return \Jasoft\Viringo\CoreBundle\Service\Domain\GrantedSystemSecurityMenuRole
     */
    private function recursiveVerifySystemMenu($systemMenu, $roleCapable) {
        $result=new Domain\GrantedSystemSecurityMenuRole();
        
        $result->setMenuTitle($systemMenu->getText());
        $roleName=$systemMenu->getRoleName();
        if (!empty($roleName)) {
            $ssr=$this->systemSecurityRoleManager->getPersisted($roleName);
            $result
                ->setRoleId($ssr->getId())
                ->setGranted($this->securityService->itemHasRole($roleCapable, $systemMenu->getRoleName()))
            ;
        } else {
            $result->setGranted(true);
        }
        $result
            ->setIconCls($systemMenu->getIconCls())
            ->setLeaf($systemMenu->isLeaf())
            ->setExpanded($systemMenu->isExpanded())
        ;
        $children=$systemMenu->getChildren();
        if (!empty($children)) {
            foreach ($children as $submenu) {
                $result->addChild($this->recursiveVerifySystemMenu($submenu, $roleCapable));
            }
        }
        
        return $result;
    }
    
    public function getAlowedMenus() {
        $rootMenu=$this->systemMenuService->getRootMenu();
        $this->filterAllowedMenus($rootMenu);
        return $rootMenu;
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
    
    public function getSystemMenuService() {
        return $this->systemMenuService;
    }

    public function setSystemMenuService(\Jasoft\Viringo\CoreBundle\Service\SystemMenuService $systemMenuService) {
        $this->systemMenuService = $systemMenuService;
    }
    
    public function getSystemSecurityRoleManager() {
        return $this->systemSecurityRoleManager;
    }

    public function setSystemSecurityRoleManager(SystemSecurityRoleManager $systemSecurityRoleManager) {
        $this->systemSecurityRoleManager = $systemSecurityRoleManager;
    }

    public function getSecurity() {
        return $this->securityService;
    }

    public function setSecurity(SystemSecurityService $security) {
        $this->securityService = $security;
    }
}
