<?php

namespace Jasoft\Viringo\CoreBundle\Service\Domain;

/**
 * Description of SystemMenuLoader
 *
 * @author jgin
 */
interface SystemMenuLoader {
    
    /**
     * Agrega todos los menus donde corresponden
     * @param \Jasoft\Viringo\CoreBundle\Service\SystemMenuService $systemMenuService
     */
    public function loadMenus($systemMenuService);
}
