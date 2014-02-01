<?php

namespace Jasoft\Viringo\CoreBundle\Service;
/**
 * Description of EmailService
 *
 * @author jgin
 */
class EmailService extends AbstractService {
    
    private $templating;
    
    /**
     *
     * @var \Swift_Mailer
     */
    private $mailer;
    
    /**
     *
     * @var \Swift_Transport
     */
    private $transport;
    
    function __construct($mailer, $transport) {
        $this->mailer = $mailer;
        $this->transport = $transport;
    }

    public function createEmailMessageFromTemplate($subject, $from, $to, $templateName, $templateParams, $utf8encode=true) {
        $emailMessage=new Domain\EmailMessage();
        $msgBody=$this->templating->render($templateName, $templateParams);
        if ($utf8encode) {
            $msgBody=utf8_encode($msgBody);
        }
        $emailMessage
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($msgBody)
        ;
        return $emailMessage;
    }
    
    /**
     * 
     * @param Domain\EmailMessage $emailMessage
     */
    public function sendMessage($emailMessage) {
        $this->mailer->send($emailMessage);
    }
    
    public function flushQueue() {
        /* @var $spool \Swift_MemorySpool */
        $spool = $this->mailer->getTransport()->getSpool();
        if ($spool instanceof \Swift_MemorySpool) {
            $spool->flushQueue($this->transport);
        }
    }
    
    public function getTemplating() {
        return $this->templating;
    }

    public function setTemplating($templating) {
        $this->templating = $templating;
    }
    
}
