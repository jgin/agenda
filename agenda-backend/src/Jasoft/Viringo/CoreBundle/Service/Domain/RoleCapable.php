<?php

namespace Jasoft\Viringo\CoreBundle\Service\Domain;

/**
 * Description of RoleCapable
 *
 * @author lvercelli
 */
interface RoleCapable {
    
    /**
     * Retorna los roles de esta entidad de forma ordenada ascendentemente
     * @return array Array con el nombre de todos los roles asignados y habilitados
     */
    function getOrderedRoles();
}
