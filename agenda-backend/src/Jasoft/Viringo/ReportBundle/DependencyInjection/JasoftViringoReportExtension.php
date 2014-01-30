<?php

namespace Jasoft\Viringo\ReportBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JasoftViringoReportExtension extends Extension
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
        
        $this->loadBirtConfig($config, $container);
    }
    
    /**
     * 
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadBirtConfig($config, $container) {
        $def=$container->getDefinition('jasoft_viringo_report.service.report');
        if (isset($config['java_hosts'])) {
            $java_hosts=$config['java_hosts'];
            $def
                ->addMethodCall('setJavaHosts', array($java_hosts))
            ;
        }
        $def->addMethodCall('loadBirtEngine');
    }
}
