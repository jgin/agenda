<?php

namespace Jasoft\Viringo\CoreBundle\SystemMenu;

use Jasoft\Viringo\CoreBundle\Entity\SystemMenu;
use Jasoft\Viringo\CoreBundle\Service\Domain\SystemMenuLoader;

/**
 * Description of SecuritySystemMenuLoader
 *
 * @author lvercelli
 */
class SecuritySystemMenuLoader implements SystemMenuLoader {
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Service\SystemMenuService $systemMenuService
     */
    public function loadMenus($systemMenuService) {
        $root=$systemMenuService->getRootMenu();
        $root
                ->addChildren(array(
                    'securityAndAudit'=>SystemMenu::create()
                        ->setExpanded(false)
                        ->setText('Seguridad y auditoria')
                        ->setRoleName('ROLE_GROOUP_MENU_SecurityAndAudit')
                        ->setIconCls('security')
                        ->addChildren(array(
//                            'systemLocalUserChangePassword'=>SystemMenu::create()
//                                ->setEntityName('SystemUser')
//                                ->setLeaf(true)
//                                ->setRoleName('ROLE_MENU_ChangePasswordLoggedSystemUser')
//                                ->setText(utf8_encode('Cambiar contraseña'))
//                                ->setUseController(true)
//                                ->setView('ChangePasswordLogged'),
                            'systemUser'=>SystemMenu::create()
                                ->setEntityName('SystemUser')
                                ->setLeaf(true)
                                ->setRoleName('ROLE_MENU_SystemUser')
                                ->setText('Usuarios del sistema')
                                ->setUseController(true)
                                ->setView('List')
                                ->setIconCls('user'),
                            'systemSecurityGroup'=>SystemMenu::create()
                                ->setEntityName('SystemSecurityGroup')
                                ->setLeaf(true)
                                ->setRoleName('ROLE_MENU_SystemSecurityGroup')
                                ->setText('Grupos de usuarios')
                                ->setUseController(true)
                                ->setView('List'),
                            'systemSecurityRole'=>SystemMenu::create()
                                ->setEntityName('SystemSecurityRole')
                                ->setLeaf(true)
                                ->setRoleName('ROLE_MENU_SystemSecurityRole')
                                ->setText('Permisos del sistema')
                                ->setUseController(true)
                                ->setView('Admin'),
                            'systemAudit'=>SystemMenu::create()
                                ->setEntityName('SystemAudit')
                                ->setLeaf(true)
                                ->setRoleName('ROLE_MENU_SystemAuditRole')
                                ->setText('Auditoria')
                                ->setUseController(true)
                                ->setView('List'),
                    )),
                ));
    }

}
