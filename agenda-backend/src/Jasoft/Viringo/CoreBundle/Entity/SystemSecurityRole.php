<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * SystemUser
 *
 * @ORM\Table(name="system_security_role")
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\CoreBundle\Repository\SystemSecurityRoleRepository")
 */
class SystemSecurityRole extends \Jasoft\Viringo\CoreBundle\Entity\Entity
    implements \Symfony\Component\Security\Core\Role\RoleInterface
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
     * @var string
     *
     * @ORM\Column(type="string", length=200, unique=true)
     * @Serializer\SerializedName(value="roleName")
     */
    private $roleName;

    
    
    public function getRole() {
        return $this->getRoleName();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set roleName
     *
     * @param string $roleName
     * @return SystemSecurityRole
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * Get roleName
     *
     * @return string 
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

}
