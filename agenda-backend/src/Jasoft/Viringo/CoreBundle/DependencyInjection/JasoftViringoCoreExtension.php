<?php

namespace Jasoft\Viringo\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JasoftViringoCoreExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        $this->loadExceptionEmailConfig($config, $container);
    }
    
    /**
     * 
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadExceptionEmailConfig($config, $container) {
        if (isset($config['exception_handling'])) {
            $exception_handling=$config['exception_handling'];
            if (isset($exception_handling['exception_email'])) {
                $exception_email=$exception_handling['exception_email'];
                if (isset($exception_email['send_email'])) {
                    $send_email=$exception_email['send_email'];
                    $def=$container->getDefinition('jasoft_viringo_core.service.exception_handler');
                    if (true===$send_email || 'true'===$send_email) {
                        $def
                            ->addMethodCall('setSendEmail', array(true))
                            ->addMethodCall('setEmailSendingInfo', array($exception_email))
                        ;
                    } else {
                        $def->addMethodCall('setSendEmail', array(false));
                    }
                }
            }
        }
    }
    
}
