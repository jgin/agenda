<?php

namespace Jasoft\Viringo\MasterBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Description of MasterAbstractManager
 *
 * @author lvercelli
 */
abstract class MasterAbstractManager extends \Jasoft\Viringo\CoreBundle\Service\AbstractManager {
    
    public function __construct(\Doctrine\ORM\EntityManager $entityManager, $entityName) {
        parent::__construct($entityManager, $entityName);
    }
    
    public function register($entity) {
        throw new \RuntimeException('No se puede registrar ['.__CLASS__.']');
    }
    
    public function update($entity) {
        throw new \RuntimeException('No se puede editar ['.__CLASS__.']');
    }
}
