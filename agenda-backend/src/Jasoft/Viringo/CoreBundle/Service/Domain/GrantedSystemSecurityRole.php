<?php

namespace Jasoft\Viringo\CoreBundle\Service\Domain;

use JMS\Serializer\Annotation as Serializer;

/**
 *
 * @author lvercelli
 */
class GrantedSystemSecurityRole {
    
    /**
     *
     * @var integer
     * @Serializer\SerializedName(value="roleId")
     */
    private $roleId;
    
    /**
     *
     * @var boolean
     * @Serializer\SerializedName(value="checked")
     */
    private $granted;
    
    /**
     * 
     * @param integer $roleId
     * @param boolean $granted
     */
    function __construct($roleId=null, $granted=null) {
        $this->roleId = $roleId;
        $this->granted = $granted;
    }

    /**
     * 
     * @return integer
     */
    public function getRoleId() {
        return $this->roleId;
    }

    /**
     * 
     * @return boolean
     */
    public function getGranted() {
        return $this->granted;
    }

    /**
     * 
     * @param integer $roleId
     * @return \Jasoft\Viringo\CoreBundle\Service\Domain\GrantedSystemSecurityRole
     */
    public function setRoleId($roleId) {
        $this->roleId = $roleId;
        return $this;
    }

    /**
     * 
     * @param boolean $granted
     * @return \Jasoft\Viringo\CoreBundle\Service\Domain\GrantedSystemSecurityRole
     */
    public function setGranted($granted) {
        $this->granted = $granted;
        return $this;
    }

}
