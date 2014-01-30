<?php

namespace Jasoft\Viringo\ReportBundle\Service;

/**
 * Description of ReportService
 *
 * @author lvercelli
 */
class ReportService extends \Jasoft\Viringo\CoreBundle\Service\AbstractService {

    const REPORT_FORMAT_PDF='pdf';
    
    const REPORT_FORMAT_XLS='xls';
    
    const REPORT_FORMAT_HTML='html';
    
    private $birtReportEngine;
    
    /**
     *
     * @var string
     */
    private $javaHosts;
    
    public function loadBirtEngine() {
        if (!empty($this->javaHosts)) {
            define ("JAVA_HOSTS", $this->javaHosts);
        }
        require_once ("JavaBridge/Java.inc");
        $ctx = java_context()->getServletContext();
        $this->birtReportEngine = Java("org.eclipse.birt.php.birtengine.BirtEngine")->getBirtEngine($ctx);
        java_context()->onShutdown(Java("org.eclipse.birt.php.birtengine.BirtEngine")->getShutdownHook());
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\ReportBundle\Domain\Report $report
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    public function renderReport($report, $response, $format=self::REPORT_FORMAT_PDF) {
        $reportDesign=$this->birtReportEngine->openReportDesign($report->getFileName());
        $renderTask=$this->birtReportEngine->createRunAndRenderTask($reportDesign);
        
        $this->setReportParameters($reportDesign, $renderTask, $report->getParameters());
        
        $output=new \Java("java.io.ByteArrayOutputStream");
        if (self::REPORT_FORMAT_PDF===$format || self::REPORT_FORMAT_XLS===$format
                || self::REPORT_FORMAT_HTML===$format) {
            $renderTaskConfig=$this->getRenderTaskConfiguration($format);
            $renderTaskConfig->setOutputStream($output);
            $renderTask->setRenderOption($renderTaskConfig);
        } else {
            throw new \InvalidArgumentException('El formato ['.$format.'] no es v�lido.');
        }
        
        $renderTask->run();
        $renderTask->close();
        
        $response->setContent(java_values($output->toByteArray()));
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Jasoft\Viringo\ReportBundle\Domain\Report $report
     * @param string $format
     */
    protected function configureResponse($response, $report, $format) {
        $response->headers->set('content-type', 
                \Jasoft\Viringo\CoreBundle\Controller\Domain\ContentTypes::getContentTypeByFormatStr($format));
        
        $response->headers->set('content-disposition', 'attachment; filename=report.'.$format);
    }

    /**
     * 
     * @param type $reportDesign
     * @param type $renderTask
     * @param type $values
     */
    protected function setReportParameters($reportDesign, $renderTask, $values) {
        $rawParameters=$reportDesign->getDesignHandle()->getParameters();
        
        $parameterCount=(int)java_values($rawParameters->getCount());
        
        for ($i=0; $i<$parameterCount; $i++) {
            $param=$rawParameters->get($i);
            
            $paramName=java_values($param->getName());
            
            if (isset($values[$paramName])) {
                $paramValue=$values[$paramName];
                $paramDataType=java_values($param->getDataType());
                $parsedValue=$this->parseValueToType($paramDataType, $paramValue);
                $renderTask->setParameterValue($paramName, $parsedValue);
            }
        }
    }
    
    protected function getRenderTaskConfiguration($format) {
        $opt=null;
        switch ($format) {
            case self::REPORT_FORMAT_PDF :
                $opt=new \Java("org.eclipse.birt.report.engine.api.PDFRenderOption");
                $opt->setOutputFormat('pdf');
                break;
            case self::REPORT_FORMAT_XLS :
                $opt=new \Java("org.eclipse.birt.report.engine.api.RenderOption");
                $opt->setOutputFormat('xls');
                break;
            case self::REPORT_FORMAT_HTML:
                $opt=new \Java("org.eclipse.birt.report.engine.api.HTMLRenderOption");
                $opt->setOutputFormat('html');
                break;
        }
        return $opt;
    }
    
    protected function parseValueToType($type, $value) {
        $resultValue=null;
        switch ($type) {
            case 'integer' :
                $resultValue=new \Java('java.lang.Integer', $value);
                break;
            case 'string' :
                $resultValue=new \Java('java.lang.String', utf8_encode($value));
                break;
            case 'date' :
                $number=strtotime($value)."000";
                $resultValue=new \Java('java.sql.Date', $number);
                break;
            case 'float' :
                $resultValue=new \Java('java.lang.Float', $value);
                break;
            case 'decimal' :
                $resultValue=new \Java('java.lang.Double', $value);
                break;
            case 'boolean' :
                $resultValue=new \Java('java.lang.Boolean', $value);
                break;
            case 'time' :
                $number=strtotime($value)."000";
                $resultValue=new \Java('java.sql.Time', $number);
                break;
            case 'datetime' :
                $number=strtotime($value)."000";
                $resultValue=new \Java('java.sql.Timestamp', $number);
                break;
        }
        return $resultValue;
    }
    
    public function getJavaHosts() {
        return $this->javaHosts;
    }

    public function setJavaHosts($javaHosts) {
        $this->javaHosts = $javaHosts;
    }

}
