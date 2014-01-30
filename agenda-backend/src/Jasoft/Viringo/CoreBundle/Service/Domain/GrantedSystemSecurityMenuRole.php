<?php

namespace Jasoft\Viringo\CoreBundle\Service\Domain;

use JMS\Serializer\Annotation as Serializer;

/**
 *
 * @author lvercelli
 */
class GrantedSystemSecurityMenuRole extends GrantedSystemSecurityRole {
    
    /**
     *
     * @var string
     * @Serializer\SerializedName(value="text")
     */
    private $menuTitle;
    
    /**
     *
     * @var GrantedSystemSecurityMenuRole[]
     */
    private $children;
    
    /**
     *
     * @var boolean
     */
    private $leaf;
    
    /**
     *
     * @var string
     * @Serializer\SerializedName(value="iconCls")
     */
    private $iconCls;
    
    /**
     *
     * @var boolean
     */
    private $expanded;
    
    function __construct() {
        $this->children=array();
    }

    
    public function getMenuTitle() {
        return $this->menuTitle;
    }

    public function getChildren() {
        return $this->children;
    }

    public function isLeaf() {
        return $this->leaf;
    }

    public function getIconCls() {
        return $this->iconCls;
    }

    public function isExpanded() {
        return $this->expanded;
    }

    public function setMenuTitle($menuTitle) {
        $this->menuTitle = $menuTitle;
        return $this;
    }

    /**
     * 
     * @param array $children
     * @return \Jasoft\Viringo\CoreBundle\Service\Domain\GrantedSystemSecurityMenuRole
     */
    public function setChildren($children) {
        $this->children = $children;
        return $this;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Service\Domain\GrantedSystemSecurityMenuRole $child
     * @return \Jasoft\Viringo\CoreBundle\Service\Domain\GrantedSystemSecurityMenuRole
     */
    public function addChild(GrantedSystemSecurityMenuRole $child) {
        $this->children[] = $child;
        return $this;
    }

    public function setLeaf($leaf) {
        $this->leaf = $leaf;
        return $this;
    }

    public function setIconCls($iconCls) {
        $this->iconCls = $iconCls;
        return $this;
    }

    public function setExpanded($expanded) {
        $this->expanded = $expanded;
        return $this;
    }


}
