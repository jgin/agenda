<?php

namespace Jasoft\Viringo\CoreBundle\Service;

/**
 * Description of SystemSecurityLoginListener
 *
 * @author lvercelli<lvercelli.jasoftsolutions@gmail.com>
 * 
 * 
 */
class SystemSecurityLoginListener extends \Jasoft\Viringo\CoreBundle\Service\AbstractService {
    
    
    /**
     *
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;
    
    /**
     *
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    private $securityContext;
    
    public function __construct($security, $session)
    {
        $this->securityContext = $security;
        $this->session = $session;
    }

    /**
     * 
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin($event)
    {
//        
//        $timezone = $this->securityContext->getToken()->getUser()->getTimezone();
//        if (empty($timezone)) {
//            $timezone = 'UTC';
//        }
//        $this->session->set('timezone', $timezone);
        
        $authToken=$event->getAuthenticationToken();
        if ($authToken->isAuthenticated()) {
            $cookie=new \Symfony\Component\HttpFoundation\Cookie('username', $authToken->getUsername());
            
        }
    }
}
