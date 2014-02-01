<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Audit
 *
 * @ORM\Table(name="system_audit")
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\CoreBundle\Repository\SystemAuditRepository")
 */
class SystemAudit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Entity\SystemEntity
     * @ORM\ManyToOne(targetEntity="\Jasoft\Viringo\CoreBundle\Entity\SystemEntity", fetch="EAGER")
     * @ORM\JoinColumn(name="system_entity_id", referencedColumnName="id")
     * @Serializer\SerializedName(value="systemEntity")
     */
    private $systemEntity;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="instanceId", type="bigint", nullable=true)
     * @Serializer\SerializedName(value="instanceId")
     */
    private $instanceId;
    
    /**
     *
     * @var SystemUser
     * @ORM\ManyToOne(targetEntity="SystemUser", fetch="EAGER")
     * @ORM\JoinColumn(name="system_user_id", referencedColumnName="id")
     * @Serializer\SerializedName(value="systemUser")
     */
    private $systemUser;
    
    /**
     *
     * @var string
     * @ORM\Column(name="actionName", type="string")
     * @Serializer\SerializedName(value="actionName")
     */
    private $actionName;
    
    /**
     *
     * @var \DateTime
     * @ORM\Column(name="eventDate", type="datetime")
     * @Serializer\SerializedName(value="eventDate")
     */
    private $eventDate;
    
    /**
     *
     * @var string
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    private $url;
    
    /**
     *
     * @var string
     * @ORM\Column(name="remoteIpAddress", type="string", nullable=true)
     * @Serializer\SerializedName(value="remoteIpAddress")
     */
    private $remoteIpAddress;

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
     * Set instanceId
     *
     * @param integer $instanceId
     * @return SystemAudit
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;

        return $this;
    }

    /**
     * Get instanceId
     *
     * @return integer 
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * Set actionName
     *
     * @param string $actionName
     * @return SystemAudit
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;

        return $this;
    }

    /**
     * Get actionName
     *
     * @return string 
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     * @return SystemAudit
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set remoteIpAddress
     *
     * @param string $remoteIpAddress
     * @return SystemAudit
     */
    public function setRemoteIpAddress($remoteIpAddress)
    {
        $this->remoteIpAddress = $remoteIpAddress;

        return $this;
    }

    /**
     * Get remoteIpAddress
     *
     * @return string 
     */
    public function getRemoteIpAddress()
    {
        return $this->remoteIpAddress;
    }

    /**
     * Set systemEntity
     *
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemEntity $systemEntity
     * @return SystemAudit
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
     * Set systemUser
     *
     * @param SystemUser $systemUser
     * @return SystemAudit
     */
    public function setSystemUser(SystemUser $systemUser = null)
    {
        $this->systemUser = $systemUser;

        return $this;
    }

    /**
     * Get systemUser
     *
     * @return SystemUser
     */
    public function getSystemUser()
    {
        return $this->systemUser;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return SystemAudit
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
