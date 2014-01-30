<?php

namespace Jasoft\Viringo\CoreBundle\Service;

use Jasoft\Viringo\CoreBundle\Entity\SystemMenu;

/**
 * Description of SystemMenuService
 *
 * @author jgin
 */
class SystemMenuService extends AbstractService {
    
    /**
     *
     * @var SystemMenu
     */
    private $rootMenu;
    
    /**
     *
     * @var Domain\SystemMenuLoader[]
     */
    private $systemMenuLoaders;
    
    function __construct() {
        $this->systemMenuLoaders=array();
    }
    
    public function loadAllMenus() {
        $this->rootMenu=SystemMenu::create();
        $this->rootMenu->setExpanded(true);
        foreach ($this->systemMenuLoaders as $sml) {
            $sml->loadMenus($this);
        }
    }
    
    /**
     * 
     * @param Domain\SystemMenuLoader $systemMenuLoader
     */
    public function addSystemMenuLoader($systemMenuLoader) {
        $this->systemMenuLoaders[]=$systemMenuLoader;
    }
    
    public function getRootMenu() {
        if (empty($this->rootMenu)) {
            $this->loadAllMenus();
        }
        return $this->rootMenu;
    }

}
