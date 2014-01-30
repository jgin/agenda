<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**

 * @ORM\Table(name="system_security_group_role", uniqueConstraints= {
 *      @ORM\UniqueConstraint(name="system_security_group_unique_role", columns={"system_security_group_id", "system_security_role_id"})
 * })
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\CoreBundle\Repository\SystemSecurityGroupRoleRepository")
 */
class SystemSecurityGroupRole extends \Jasoft\Viringo\CoreBundle\Entity\Entity
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
     * @var SystemSecurityGroup
     *
     * @ORM\ManyToOne(targetEntity="SystemSecurityGroup", inversedBy="rolesAssignment")
     * @ORM\JoinColumn(name="system_security_group_id", referencedColumnName="id")
     */
    private $group;

    /**
     * @var SystemSecurityRole
     *
     * @ORM\ManyToOne(targetEntity="SystemSecurityRole")
     * @ORM\JoinColumn(name="system_security_role_id", referencedColumnName="id")
     */
    private $role;


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
     * Set group
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $group
     * @return SystemSecurityGroupRole
     */
    public function setGroup(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set role
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $role
     * @return SystemSecurityGroupRole
     */
    public function setRole(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole 
     */
    public function getRole()
    {
        return $this->role;
    }
}
