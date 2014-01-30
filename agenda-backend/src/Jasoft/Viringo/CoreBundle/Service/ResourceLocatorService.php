<?php

namespace Jasoft\Viringo\CoreBundle\Service;

/**
 * Description of ResourceLocator
 *
 * @author lvercelli
 */
class ResourceLocatorService extends AbstractService {
    
    /**
     *
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    private $kernel;
    
    function __construct(\Symfony\Component\HttpKernel\Kernel $kernel) {
        $this->kernel = $kernel;
    }
    
    /**
     * 
     * @param string $bundle Nombre completo del bundle donde está el recurso
     * @param string $filePath 
     * @return string Ruta completa del archivo localizado
     */
    public function locateResource($bundle, $filePath) {
        return $this->kernel->locateResource("@$bundle/Resources/$filePath");
    }

}
