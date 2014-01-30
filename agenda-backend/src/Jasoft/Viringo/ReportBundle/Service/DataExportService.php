<?php

namespace Jasoft\Viringo\ReportBundle\Service;

/**
 * Description of GenericReportService
 *
 * @author lvercelli
 */
class DataExportService extends \Jasoft\Viringo\CoreBundle\Service\AbstractService {
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Service\ResourceLocatorService
     */
    private $resourceLocatorService;
    
    /**
     *
     * @var ReportService
     */
    private $reportService;
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Service\ResourceLocatorService $resourceLocatorService
     * @param \Jasoft\Viringo\ReportBundle\Service\ReportService $reportService
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($resourceLocatorService, $reportService, $entityManager) {
        $this->resourceLocatorService = $resourceLocatorService;
        $this->reportService = $reportService;
        $this->entityManager = $entityManager;
    }

    
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Util\PageRequestData $pageRequestData
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param integer $numberOfPages
     */
    public function exportData($pageRequestData, $response, $numberOfPages=1) {
        $fileName=$this->resourceLocatorService->locateResource('JasoftViringoReportBundle', 'reports/generic_list.rptdesign');
        
        $realPageRequestData=clone $pageRequestData;
        $realPageRequestData->setPageSize($numberOfPages*$realPageRequestData->getPageSize());
        
        $report=new \Jasoft\Viringo\ReportBundle\Domain\Report($fileName);
        
    }
    
    
}
