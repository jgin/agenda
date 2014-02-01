<?php

namespace Jasoft\Viringo\CoreBundle\Service;
/**
 * Description of ExceptionHandlerService
 *
 * @author lvercelli
 */
class ExceptionHandlerService extends AbstractService {
    
    /**
     *
     * @var EmailService
     */
    private $mailer;
    
    /**
     * Información de la aplicacion
     * @var array
     */
    private $appinfo;
    
    /**
     *
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    private $securityContext;
    
    /**
     *
     * @var boolean
     */
    private $sendEmail;
    
    /**
     *
     * @var array
     */
    private $emailSendingInfo;
    
    /**
     * 
     * @param \Symfony\Component\Security\Core\SecurityContext $securityContext
     * @param \Jasoft\Viringo\CoreBundle\Service\EmailService $mailer
     * @param array $appinfo
     */
    function __construct($securityContext, EmailService $mailer, $appinfo) {
        $this->securityContext = $securityContext;
        $this->mailer = $mailer;
        $this->appinfo = $appinfo;
    }

    /**
     * 
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     */
    public function onKernelException(\Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event) {
        $this->handleExceptionEmail($event);
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     */
    private function handleExceptionEmail($event) {
        $exception=$event->getException();
        $request=$event->getRequest();
        if ($this->sendEmail) {
            $emailMessage=$this->mailer->createEmailMessageFromTemplate(
                    $this->emailSendingInfo['subject'], $this->emailSendingInfo['sender'], 
                    $this->emailSendingInfo['receptor'],
                    'JasoftViringoCoreBundle:Exception:template.html.twig', 
                    array(
                        'appinfo'=>$this->appinfo,
                        'exception'=>$exception,
                        'request'=>$request,
                        'requestParams'=>self::getRequestParams($request),
                        'user'=>$this->getUser()
                    ));
            $emailMessage->setContentType(\Jasoft\Viringo\CoreBundle\Controller\Domain\ContentTypes::HTML);
            $this->mailer->sendMessage($emailMessage);
        }
    }
    
    private function getUser() {
        try {
            $token=$this->securityContext->getToken();
            if (!empty($token)) {
                return $this->securityContext->getToken()->getUser();
            }
        } catch (\Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    private static function getRequestParams($request) {
        $result=array();
        if ($request->query->count()>0) {
            $result['GET']=$request->query->all();
        }
        if ($request->request->count()>0) {
            $result['POST']=$request->request->all();
        }
        return $result;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getSendEmail() {
        return $this->sendEmail;
    }

    /**
     * 
     * @param boolean $sendEmail
     * @return \Jasoft\Viringo\CoreBundle\Service\ExceptionHandlerService
     */
    public function setSendEmail($sendEmail) {
        $this->sendEmail = $sendEmail;
        return$this;
    }
    
    /**
     * 
     * @return array
     */
    public function getEmailSendingInfo() {
        return $this->emailSendingInfo;
    }

    /**
     * 
     * @param array $emailSendingInfo
     * @return \Jasoft\Viringo\CoreBundle\Service\ExceptionHandlerService
     */
    public function setEmailSendingInfo($emailSendingInfo) {
        $this->emailSendingInfo = $emailSendingInfo;
        return $this;
    }
}
