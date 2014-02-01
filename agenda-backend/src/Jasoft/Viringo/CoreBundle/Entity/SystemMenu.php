<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Description of SystemMenu
 *
 * @author lvercelli
 */
class SystemMenu {
    
    /**
     *
     * @var string 
     * 
     * @Serializer\SerializedName(value="name")
     */
    private $name;
    
    /**
     *
     * @var string
     * @Serializer\SerializedName(value="entityName")
     */
    private $entityName;
    
    /**
     *
     * @var string
     * @Serializer\SerializedName(value="roleName")
     */
    private $roleName;
    
    /**
     *
     * @var string
     * @Serializer\SerializedName(value="text")
     */
    private $text;
    
    /**
     *
     * @var boolean
     * @Serializer\SerializedName(value="expanded")
     */
    private $expanded;
    
    /**
     *
     * @var string
     * @Serializer\SerializedName(value="iconCls")
     */
    private $iconCls;
    
    /**
     *
     * @var boolean
     * @Serializer\SerializedName(value="leaf")
     */
    private $leaf;
    
    /**
     *
     * @var boolean
     * @Serializer\SerializedName(value="useController")
     */
    private $useController;
    
    /**
     *
     * @var array
     * @Serializer\SerializedName(value="children")
     */
    private $children;
    
    /**
     *
     * @var array
     * 
     * @Serializer\Exclude
     */
    private $childrenPaths;
    
    /**
     *
     * @var string
     */
    private $view;
    
    /**
     * 
     * @return SystemMenu
     */
    public static function create() {
        return new SystemMenu();
    }
    
    
    function __construct() {
        $this->children=array();
        $this->childrenPaths=array();
    }

    
    public function getEntityName() {
        return $this->entityName;
    }

    public function getRoleName() {
        return $this->roleName;
    }

    public function getText() {
        return $this->text;
    }

    public function isExpanded() {
        return $this->expanded;
    }

    public function getIconCls() {
        return $this->iconCls;
    }

    public function isLeaf() {
        return $this->leaf;
    }

    public function getUseController() {
        return $this->useController;
    }

    /**
     * 
     * @return SystemMenu[]
     */
    public function getChildren() {
        return $this->children;
    }

    public function setEntityName($entityName) {
        $this->entityName = $entityName;
        return $this;
    }

    public function setRoleName($roleName) {
        $this->roleName = $roleName;
        return $this;
    }

    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    public function setExpanded($expanded) {
        $this->expanded = $expanded;
        return $this;
    }

    public function setIconCls($iconCls) {
        $this->iconCls = $iconCls;
        return $this;
    }

    public function setLeaf($leaf) {
        $this->leaf = $leaf;
        return $this;
    }

    public function setUseController($useController) {
        $this->useController = $useController;
        return $this;
    }

    /**
     * 
     * @param SystemMenu[] $children
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemMenu
     */
    public function setChildren($children) {
        $this->children = $children;
        return $this;
    }

    public function getView() {
        return $this->view;
    }

    public function setView($view) {
        $this->view = $view;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    /**
     * 
     * @param string $name
     * @param SystemMenu $systemMenu
     */
    public function addChild($name, SystemMenu $systemMenu, $pos=null) {
        if (!empty($this->childrenPaths[$name])) {
            throw new \Exception('El menu con nombre "'.$name.'" ya existe.');
        }
        $systemMenu->setName($name);
        if (isset($pos)) {
            array_splice($this->children, $pos, 0, array($systemMenu));
        } else {
            $this->children[]=$systemMenu;
        }
        $this->childrenPaths[$name]=$systemMenu;
        return $this;
    }
    
    /**
     * 
     * @param array $menus
     */
    public function addChildren(array $menus, $pos=null) {
        /* @var $systemMenu SystemMenu */
        foreach ($menus as $name=>$systemMenu) {
            $this->addChild($name, $systemMenu, $pos);
            if (isset($pos)) { $pos++; }
        }
        return $this;
    }
}
