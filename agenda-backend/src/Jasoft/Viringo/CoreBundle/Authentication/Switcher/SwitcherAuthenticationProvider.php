<?php

namespace Jasoft\Viringo\CoreBundle\Authentication\Switcher;

/**
 * Description of AuthenticationProvider
 *
 * @author lvercelli
 */
class SwitcherAuthenticationProvider implements \Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface {
    
    /**
     *
     * @var \Symfony\Component\Security\Core\User\UserProviderInterface
     */
    private $userProvider;
    
    private $cacheDir;
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Manager\SystemUserManager
     */
    private $systemUserManager;
    
    /**
     * 
     * @param \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider
     * @param string $cacheDir
     * @param \Jasoft\Viringo\CoreBundle\Manager\SystemUserManager $systemUserManager
     */
    function __construct($systemUserManager) {
        $this->userProvider = $userProvider;
        $this->cacheDir = $cacheDir;
        $this->systemUserManager=$systemUserManager;
    }

    
    public function authenticate(\Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token) {
        // Obtener el tipo de usuario
        $systemUser=$this->systemUserManager->getSystemUserByName($token->getUsername());
        
    }

    public function supports(\Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token) {
        
    }

}
