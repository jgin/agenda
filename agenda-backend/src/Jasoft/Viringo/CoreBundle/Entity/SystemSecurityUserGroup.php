<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**

 * @ORM\Table(name="system_security_user_group", uniqueConstraints= {
 *      @ORM\UniqueConstraint(name="system_security_user_group_unique_membership", columns={"system_user_id", "system_security_group_id"})
 * })
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\CoreBundle\Repository\SystemSecurityUserGroupRepository")
 */
class SystemSecurityUserGroup extends \Jasoft\Viringo\CoreBundle\Entity\Entity
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
     * @var SystemUser
     *
     * @ORM\ManyToOne(targetEntity="SystemUser", inversedBy="securityGroups")
     * @ORM\JoinColumn(name="system_user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var SystemSecurityGroup
     *
     * @ORM\ManyToOne(targetEntity="SystemSecurityGroup")
     * @ORM\JoinColumn(name="system_security_group_id", referencedColumnName="id")
     */
    private $group;


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
     * @return SystemSecurityUserGroup
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
     * Set user
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUser $user
     * @return SystemSecurityUserGroup
     */
    public function setUser(\Jasoft\Viringo\CoreBundle\Entity\SystemUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemUser 
     */
    public function getUser()
    {
        return $this->user;
    }
}
