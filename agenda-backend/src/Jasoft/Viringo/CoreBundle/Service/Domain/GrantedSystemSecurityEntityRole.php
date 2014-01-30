<?php

namespace Jasoft\Viringo\CoreBundle\Service\Domain;

/**
 *
 * @author lvercelli
 */
class GrantedSystemSecurityEntityRole {
    
    /**
     *
     * @var string
     */
    private $entityName;
    
    /**
     *
     * @var string
     */
    private $title;
    
    /**
     *
     * @var GrantedSystemSecurityRole
     */
    private $list;
    
    /**
     *
     * @var GrantedSystemSecurityRole
     */
    private $create;
    
    /**
     *
     * @var GrantedSystemSecurityRole
     */
    private $update;
    
    /**
     *
     * @var GrantedSystemSecurityRole
     */
    private $delete;
    
    /**
     *
     * @var GrantedSystemSecurityRole
     */
    private $export;
    
    public function getEntityName() {
        return $this->entityName;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getList() {
        return $this->list;
    }

    public function getCreate() {
        return $this->create;
    }

    public function getUpdate() {
        return $this->update;
    }

    public function getDelete() {
        return $this->delete;
    }

    public function getExport() {
        return $this->export;
    }

    public function setEntityName($entityName) {
        $this->entityName = $entityName;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setList(GrantedSystemSecurityRole $list) {
        $this->list = $list;
        return $this;
    }

    public function setCreate(GrantedSystemSecurityRole $create) {
        $this->create = $create;
        return $this;
    }

    public function setUpdate(GrantedSystemSecurityRole $update) {
        $this->update = $update;
        return $this;
    }

    public function setDelete(GrantedSystemSecurityRole $delete) {
        $this->delete = $delete;
        return $this;
    }

    public function setExport(GrantedSystemSecurityRole $export) {
        $this->export = $export;
        return $this;
    }

}
