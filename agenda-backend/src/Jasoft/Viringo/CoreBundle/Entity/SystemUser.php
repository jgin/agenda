<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * SystemUser
 *
 * @ORM\Table(name="system_user")
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\CoreBundle\Repository\SystemUserRepository")
 */
class SystemUser extends \Jasoft\Viringo\CoreBundle\Entity\Entity
    implements \Symfony\Component\Security\Core\User\UserInterface,
        \Symfony\Component\Security\Core\User\EquatableInterface
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
     */
    private $username;

    /**
     * @var SystemUserType
     *
     * @ORM\ManyToOne(targetEntity="SystemUserType", fetch="EAGER")
     * @ORM\JoinColumn(name="system_user_type_id", referencedColumnName="id")
     * @Serializer\SerializedName(value="userType")
     */
    private $userType;
    
    /**
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="SystemSecurityUserGroup", mappedBy="user")
     * @Serializer\Exclude
     */
    private $securityGroups;

    /**
     *
     * @var boolean 
     * @ORM\Column(type="boolean", nullable=true)
     * @Serializer\Exclude
     */
    private $hidden;

    
    /**
     * Constructor
     */
    public function __construct() {
        $this->securityGroups = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return SystemUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * Set userType
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUserType $userType
     * @return SystemUser
     */
    public function setUserType(\Jasoft\Viringo\CoreBundle\Entity\SystemUserType $userType = null)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemUserType 
     */
    public function getUserType()
    {
        return $this->userType;
    }
    

    /**
     * Add securityGroups
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityUserGroup $securityGroups
     * @return SystemUser
     */
    public function addSecurityGroup(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityUserGroup $securityGroups)
    {
        $this->securityGroups[] = $securityGroups;

        return $this;
    }

    /**
     * Remove securityGroups
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityUserGroup $securityGroups
     */
    public function removeSecurityGroup(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityUserGroup $securityGroups)
    {
        $this->securityGroups->removeElement($securityGroups);
    }
    
    /**
     * Set hidden
     *
     * @param boolean $hidden
     * @return SystemUser
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Is hidden
     *
     * @return boolean 
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Get securityGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSecurityGroups()
    {
        return $this->securityGroups;
    }

    private $password;
    
    private $salt;
    
    private $roles;
    
    public function eraseCredentials() {
        unset($this->password);
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }
    
    public function setRoles($roles) {
        $this->roles = $roles;
        return $this;
    }
    
    public function isEqualTo(\Symfony\Component\Security\Core\User\UserInterface $user) {
        return $user->getUsername()===$this->getUsername();
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName(value="groupsString")
     * @return string
     */
    public function getGroupsString() {
        $grps=array();
        /* @var $sg SystemSecurityUserGroup */
        foreach ($this->getSecurityGroups() as $sg) {
            if ($sg->isActive()) {
                $grps[]=$sg->getGroup()->getGroupName();
            }
        }
        return implode(', ', $grps);
    }

}
