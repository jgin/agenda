<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * SystemUser
 *
 * @ORM\Table(name="system_security_group")
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\CoreBundle\Repository\SystemSecurityGroupRepository")
 */
class SystemSecurityGroup extends \Jasoft\Viringo\CoreBundle\Entity\Entity
    implements \Jasoft\Viringo\CoreBundle\Service\Domain\RoleCapable
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
     * @ORM\Column(type="string", length=255, unique=true)
     * @Serializer\SerializedName(value="groupName")
     */
    private $groupName;
    
    /**
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="SystemSecurityGroupRole", mappedBy="group")
     * @Serializer\Exclude
     */
    private $rolesAssignment;


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
     * Constructor
     */
    public function __construct()
    {
        $this->rolesAssignment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set groupName
     *
     * @param string $groupName
     * @return SystemSecurityGroup
     */
    public function setGroupName($groupName)
    {
        $this->groupName = strtoupper($groupName);

        return $this;
    }

    /**
     * Get groupName
     *
     * @return string 
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Add roleAssignment
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroupRole $RoleAssignment
     * @return SystemSecurityGroup
     */
    public function addRoleAssignment(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroupRole $RoleAssignment)
    {
        $this->rolesAssignment[] = $RoleAssignment;

        return $this;
    }

    /**
     * Remove roleAssignment
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroupRole $roleAssignment
     */
    public function removeRoleAssignment(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroupRole $roleAssignment)
    {
        $this->rolesAssignment->removeElement($roleAssignment);
    }

    /**
     * Get rolesAssignment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRolesAssignment()
    {
        return $this->rolesAssignment;
    }

    private $orderedRoles;
    
    public function getOrderedRoles() {
        if (empty($this->orderedRoles)) {
            $this->loadOrderedRoles();
        }
        return $this->orderedRoles;
    }
    
    public function loadOrderedRoles() {
        $result=array();
        /* @var $ra SystemSecurityGroupRole */
        foreach ($this->rolesAssignment as $ra) {
            if ($ra->isActive()) {
                $result[]=$ra->getRole()->getRoleName();
            }
        }
        sort($result);
        $this->orderedRoles=$result;
    }

}
