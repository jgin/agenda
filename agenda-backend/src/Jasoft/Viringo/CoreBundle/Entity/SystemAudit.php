<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * ORM\Table(name="system_audit")
 * ORM\Entity(repositoryClass="Jasoft\Viringo\CoreBundle\Repository\SystemAuditRepository")
 */
class SystemAudit extends \Jasoft\Viringo\CoreBundle\Entity\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    
}
