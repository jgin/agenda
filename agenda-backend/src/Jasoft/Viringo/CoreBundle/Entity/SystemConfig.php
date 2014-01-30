<?php

namespace Jasoft\Viringo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SystemConfig
 *
 * @ORM\Table(name="system_config")
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\CoreBundle\Repository\SystemConfigRepository")
 */
class SystemConfig extends Entity
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="textValue", type="text", nullable=true)
     */
    private $textValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="intValue", type="bigint", nullable=true)
     */
    private $intValue;

    /**
     * @var float
     *
     * @ORM\Column(name="floatValue", type="float", nullable=true)
     */
    private $floatValue;


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
     * Set name
     *
     * @param string $name
     * @return SystemConfig
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set textValue
     *
     * @param string $textValue
     * @return SystemConfig
     */
    public function setTextValue($textValue)
    {
        $this->textValue = $textValue;

        return $this;
    }

    /**
     * Get textValue
     *
     * @return string 
     */
    public function getTextValue()
    {
        return $this->textValue;
    }

    /**
     * Set intValue
     *
     * @param integer $intValue
     * @return SystemConfig
     */
    public function setIntValue($intValue)
    {
        $this->intValue = $intValue;

        return $this;
    }

    /**
     * Get intValue
     *
     * @return integer 
     */
    public function getIntValue()
    {
        return $this->intValue;
    }

    /**
     * Set floatValue
     *
     * @param float $floatValue
     * @return SystemConfig
     */
    public function setFloatValue($floatValue)
    {
        $this->floatValue = $floatValue;

        return $this;
    }

    /**
     * Get floatValue
     *
     * @return float 
     */
    public function getFloatValue()
    {
        return $this->floatValue;
    }
}
