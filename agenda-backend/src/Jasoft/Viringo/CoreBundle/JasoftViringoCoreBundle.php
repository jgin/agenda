<?php

namespace Jasoft\Viringo\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JasoftViringoCoreBundle extends Bundle
{
    
    public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new DependencyInjection\SystemMenuCompilerPass());
    }
    
}
