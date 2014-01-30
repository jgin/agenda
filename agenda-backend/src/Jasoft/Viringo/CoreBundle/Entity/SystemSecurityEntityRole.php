<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * SystemSecurityEntityRole
 *
 * @ORM\Table(name="system_security_entity_role")
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\CoreBundle\Repository\SystemSecurityEntityRoleRepository")
 */
class SystemSecurityEntityRole extends \Jasoft\Viringo\CoreBundle\Entity\Entity
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
     * @var \Jasoft\Viringo\CoreBundle\Entity\SystemEntity
     *
     * @ORM\ManyToOne(targetEntity="\Jasoft\Viringo\CoreBundle\Entity\SystemEntity", fetch="EAGER")
     * @ORM\JoinColumn(name="system_entity_id", referencedColumnName="id")
     * @Serializer\SerializedName(value="systemEntity")
     */
    private $systemEntity;
    
    /**
     * @var SystemSecurityRole
     *
     * @ORM\ManyToOne(targetEntity="SystemSecurityRole", fetch="EAGER")
     * @ORM\JoinColumn(name="list_system_role_id", referencedColumnName="id")
     * @Serializer\SerializedName(value="listRole")
     */
    private $listRole;
    
    /**
     * @var SystemSecurityRole
     *
     * @ORM\ManyToOne(targetEntity="SystemSecurityRole", fetch="EAGER")
     * @ORM\JoinColumn(name="create_system_role_id", referencedColumnName="id")
     * @Serializer\SerializedName(value="createRole")
     */
    private $createRole;
    
    /**
     * @var SystemSecurityRole
     *
     * @ORM\ManyToOne(targetEntity="SystemSecurityRole", fetch="EAGER")
     * @ORM\JoinColumn(name="update_system_role_id", referencedColumnName="id")
     * @Serializer\SerializedName(value="updateRole")
     */
    private $updateRole;
    
    /**
     * @var SystemSecurityRole
     *
     * @ORM\ManyToOne(targetEntity="SystemSecurityRole", fetch="EAGER")
     * @ORM\JoinColumn(name="delete_system_role_id", referencedColumnName="id")
     * @Serializer\SerializedName(value="deleteRole")
     */
    private $deleteRole;
    
    /**
     * @var SystemSecurityRole
     *
     * @ORM\ManyToOne(targetEntity="SystemSecurityRole", fetch="EAGER")
     * @ORM\JoinColumn(name="export_system_role_id", referencedColumnName="id")
     * @Serializer\SerializedName(value="exportRole")
     */
    private $exportRole;
    
    
    

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
     * Set systemEntity
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemEntity $systemEntity
     * @return SystemSecurityEntityRole
     */
    public function setSystemEntity(\Jasoft\Viringo\CoreBundle\Entity\SystemEntity $systemEntity = null)
    {
        $this->systemEntity = $systemEntity;

        return $this;
    }

    /**
     * Get systemEntity
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemEntity 
     */
    public function getSystemEntity()
    {
        return $this->systemEntity;
    }

    /**
     * Set listRole
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $listRole
     * @return SystemSecurityEntityRole
     */
    public function setListRole(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $listRole = null)
    {
        $this->listRole = $listRole;

        return $this;
    }

    /**
     * Get listRole
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole 
     */
    public function getListRole()
    {
        return $this->listRole;
    }

    /**
     * Set createRole
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $createRole
     * @return SystemSecurityEntityRole
     */
    public function setCreateRole(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $createRole = null)
    {
        $this->createRole = $createRole;

        return $this;
    }

    /**
     * Get createRole
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole 
     */
    public function getCreateRole()
    {
        return $this->createRole;
    }

    /**
     * Set updateRole
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $updateRole
     * @return SystemSecurityEntityRole
     */
    public function setUpdateRole(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $updateRole = null)
    {
        $this->updateRole = $updateRole;

        return $this;
    }

    /**
     * Get updateRole
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole 
     */
    public function getUpdateRole()
    {
        return $this->updateRole;
    }

    /**
     * Set deleteRole
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $deleteRole
     * @return SystemSecurityEntityRole
     */
    public function setDeleteRole(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $deleteRole = null)
    {
        $this->deleteRole = $deleteRole;

        return $this;
    }

    /**
     * Get deleteRole
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole 
     */
    public function getDeleteRole()
    {
        return $this->deleteRole;
    }

    /**
     * Set exportRole
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $exportRole
     * @return SystemSecurityEntityRole
     */
    public function setExportRole(\Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $exportRole = null)
    {
        $this->exportRole = $exportRole;

        return $this;
    }

    /**
     * Get exportRole
     *
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole 
     */
    public function getExportRole()
    {
        return $this->exportRole;
    }
}
