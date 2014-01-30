<?php

namespace Jasoft\Viringo\ReportBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ReportController extends \Jasoft\Viringo\CoreBundle\Controller\AbstractController
{
    
    /**
     * @return \Jasoft\Viringo\ReportBundle\Service\ReportService
     */
    private function getReportService() {
        return $this->get('jasoft.report');
    }
    
    /**
     * @Route("/{bundle}/{reportName}/{format}", defaults={"format"="pdf"})
     */
    public function renderAction($bundle, $reportName, $format)
    {
        try {
            $reportFilePath=$this->getResourceLocator()->locateResource($bundle, "reports/$reportName");
            $resportService=$this->getReportService();

            $report=new \Jasoft\Viringo\ReportBundle\Domain\Report($reportFilePath);
            $report->setParamaterValue('testParam', 'Hello from SF2');

            $response=new \Symfony\Component\HttpFoundation\Response();
            
            $resportService->renderReport($report, $response, $format);
            
            $response->headers->set('content-type', \Jasoft\Viringo\CoreBundle\Controller\Domain\ContentTypes::getContentTypeByFormatStr($format));
            $cd=$response->headers->makeDisposition(\Symfony\Component\HttpFoundation\ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'report.'.$format);
            $response->headers->set('content-disposition', $cd);
            
            return $response;
        } catch (\InvalidArgumentException $ex) {
            throw new \Symfony\Component\Filesystem\Exception\FileNotFoundException(null, 0, $ex, $reportName);
        }
    }
}
