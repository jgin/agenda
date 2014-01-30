<?php

namespace Jasoft\Viringo\CoreBundle\Util;

/**
 * Clase que toma los datos de una petición de una página de datos.
 * Puede usarse para los request de datos del cliente.
 *
 * @author lvercelli
 */
class PageRequestData {
    
    /**
     *
     * @var boolean
     */
    private $active;
    
    /**
     *
     * @var array
     */
    private $filters;
    
    /**
     *
     * @var array
     */
    private $sorting;
    
    /**
     *
     * @var integer
     */
    private $pageNumber;
    
    /**
     *
     * @var integer
     */
    private $pageSize;
    
    function __construct($active=null, $filters=null, $sorting=null, $pageNumber=null, $pageSize=null) {
        $this->active = $active;
        $this->filters = $filters;
        $this->sorting = $sorting;
        $this->pageNumber = $pageNumber;
        $this->pageSize = $pageSize;
    }

    
    public function getActive() {
        return $this->active;
    }

    public function getFilters() {
        return $this->filters;
    }

    public function getSorting() {
        return $this->sorting;
    }

    public function getPageNumber() {
        return $this->pageNumber;
    }

    public function getPageSize() {
        return $this->pageSize;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function setFilters($filters) {
        $this->filters = $filters;
        return $this;
    }

    public function setSorting($sorting) {
        $this->sorting = $sorting;
        return $this;
    }

    public function setPageNumber($pageNumber) {
        $this->pageNumber = $pageNumber;
        return $this;
    }

    public function setPageSize($pageSize) {
        $this->pageSize = $pageSize;
        return $this;
    }


}
