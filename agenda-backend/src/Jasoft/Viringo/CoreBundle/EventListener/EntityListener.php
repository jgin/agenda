<?php

namespace Jasoft\Viringo\CoreBundle\EventListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Jasoft\Viringo\CoreBundle\Entity\Entity;
use Jasoft\Viringo\CoreBundle\Repository\EntityRepository;

/**
 * Description of EntityListener
 *
 * @author gin
 */
class EntityListener {
    
    public function onFlush(OnFlushEventArgs $args) {
        $now=new \DateTime();
        $ip=$_SERVER['REMOTE_ADDR'];
        
        $uow=$args->getEntityManager()->getUnitOfWork();
        
        foreach ($uow->getScheduledEntityInsertions() AS $entity) {
            if ($entity instanceof Entity) {
                $entity->setCreatedAt($now);
                //$entity->setUpdatedAt($now);
                $entity->setCreatedByIp($ip);
                //$entity->setUpdatedByIp($ip);
                $entity->setActive(true);
                
                // FIXME: Quitar esto de usuarios
                $entity->setCreatedByUser(0);
                
                $cmd=$args->getEntityManager()->getClassMetadata(get_class($entity));
                $uow->recomputeSingleEntityChangeSet($cmd, $entity);
                
                $repository=$args->getEntityManager()->getRepository(get_class($entity));
                if ($repository instanceof EntityRepository) {
                    $repository->onFlush($args);
                }
            }
        }

        foreach ($uow->getScheduledEntityUpdates() AS $entity) {
            if ($entity instanceof Entity) {
                if ($entity->isDeleted()) {
                    $entity->setDeletedAt($now);
                    $entity->setDeletedByIp($ip);
                } else {
                    $entity->setUpdatedAt($now);
                    $entity->setUpdatedByIp($ip);
                }
                $cmd=$args->getEntityManager()->getClassMetadata(get_class($entity));
                $uow->recomputeSingleEntityChangeSet($cmd, $entity);
            }
            $repository=$args->getEntityManager()->getRepository(get_class($entity));
            if ($repository instanceof EntityRepository) {
                $repository->onFlush($args);
            }
        }
        
    }
    
    public function prePersist(LifecycleEventArgs $args) {
        $entity=$args->getEntity();
        $repository=$args->getEntityManager()->getRepository(get_class($entity));
        if ($repository instanceof EntityRepository) {
            $repository->prePersist($args);
        }
    }
    
    public function preUpdate(PreUpdateEventArgs $args) {
        $entity=$args->getEntity();
        $repository=$args->getEntityManager()->getRepository(get_class($entity));
        if ($repository instanceof EntityRepository) {
            $repository->preUpdate($args);
        }
    }
    
}
