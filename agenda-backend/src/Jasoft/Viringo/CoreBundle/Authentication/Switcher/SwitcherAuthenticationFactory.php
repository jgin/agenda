<?php

namespace Jasoft\Viringo\CoreBundle\Authentication\Switcher;

/**
 * Description of AuthenticationFactory
 *
 * @author lvercelli
 */
class SwitcherAuthenticationFactory extends \Symfony\Bundle\CoreBundle\DependencyInjection\Security\Factory\AbstractFactory {

    public function __construct()
    {
        $this->addOption('username_parameter', '_username');
        $this->addOption('password_parameter', '_password');
//        $this->addOption('csrf_parameter', '_csrf_token');
        $this->addOption('intention', 'authenticate');
        $this->addOption('post_only', true);
    }

    public function getPosition() {
        return 'form';
    }

    public function getKey() {
        return 'jasoft-form-login';
    }

//    public function addConfiguration(NodeDefinition $node)
//    {
//        parent::addConfiguration($node);
//
////        $node
////            ->children()
////                ->scalarNode('csrf_provider')->cannotBeEmpty()->end()
////            ->end()
////        ;
//    }

    protected function getListenerId()
    {
//        return 'jasoft_viringo_core.authentication.switcher.listener';
        return 'security.authentication.listener.form';
    }

    /**
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param type $id
     * @param type $config
     * @param type $userProviderId
     * @return string
     */
    protected function createAuthProvider($container, $id, $config, $userProviderId)
    {
        $provider = 'jasoft_viringo_core.authentication.switcher.provider.'.$id;
        $container
            ->setDefinition($provider, new \Symfony\Component\DependencyInjection\DefinitionDecorator('jasoft_viringo_core.authentication.switcher.provider'))
            ->replaceArgument(0, new \Symfony\Component\DependencyInjection\Reference('jasoft_viringo_core.manager.system_user'))
        ;

        return $provider;
    }

//    protected function createListener($container, $id, $config, $userProvider)
//    {
//        $listenerId = parent::createListener($container, $id, $config, $userProvider);
//
////        if (isset($config['csrf_provider'])) {
////            $container
////                ->getDefinition($listenerId)
////                ->addArgument(new Reference($config['csrf_provider']))
////            ;
////        }
//
//        return $listenerId;
//    }

//    protected function createEntryPoint($container, $id, $config, $defaultEntryPoint)
//    {
////        $entryPointId = 'security.authentication.form_entry_point.'.$id;
////        $container
////            ->setDefinition($entryPointId, new DefinitionDecorator('security.authentication.form_entry_point'))
////            ->addArgument(new Reference('security.http_utils'))
////            ->addArgument($config['login_path'])
////            ->addArgument($config['use_forward'])
////        ;
////
////        return $entryPointId;
//    }
    
}
