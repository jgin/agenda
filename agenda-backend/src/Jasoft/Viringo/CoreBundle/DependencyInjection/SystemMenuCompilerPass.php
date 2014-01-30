<?php

namespace Jasoft\Viringo\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 */
class SystemMenuCompilerPass implements \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * Procesa todos los servicios con el tag 'jasoft.system_menu'
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container) {
        if (!$container->hasDefinition('jasoft_viringo_core.service.system_menu')) {
            return;
        }
        
        $definition = $container->getDefinition('jasoft_viringo_core.service.system_menu');

        $taggedServices = $container->findTaggedServiceIds('jasoft.system_menu');
        foreach ($taggedServices as $id => $tagAttr) {
            $definition->addMethodCall(
                'addSystemMenuLoader',
                array(new \Symfony\Component\DependencyInjection\Reference($id))
            );
        }
    }

}
