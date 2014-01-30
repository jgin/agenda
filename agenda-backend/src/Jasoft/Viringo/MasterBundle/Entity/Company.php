<?php

namespace Jasoft\Viringo\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Company
 *
 * @ORM\Table(name="master_o_company")
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\MasterBundle\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pkCompany", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName(value="pkCompany")
     */
    private $pkCompany;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @JMS\SerializedName(value="companyName")
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @JMS\SerializedName(value="keySpring")
     */
    private $keySpring;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank
     * @JMS\SerializedName(value="keySpringAssociate")
     */
    private $keySpringAssociate;
    
    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank
     * @JMS\SerializedName(value="statusRegister")
     */
    private $statusRegister;
    

    /**
     * Get pkCompany
     *
     * @return integer 
     */
    public function getPkCompany()
    {
        return $this->pkCompany;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return Company
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set keySpring
     *
     * @param string $keySpring
     * @return Company
     */
    public function setKeySpring($keySpring)
    {
        $this->keySpring = $keySpring;

        return $this;
    }

    /**
     * Get keySpring
     *
     * @return string 
     */
    public function getKeySpring()
    {
        return $this->keySpring;
    }

    /**
     * Set keySpringAssociate
     *
     * @param string $keySpringAssociate
     * @return Company
     */
    public function setKeySpringAssociate($keySpringAssociate)
    {
        $this->keySpringAssociate = $keySpringAssociate;

        return $this;
    }

    /**
     * Get keySpringAssociate
     *
     * @return string 
     */
    public function getKeySpringAssociate()
    {
        return $this->keySpringAssociate;
    }

    /**
     * Set statusRegister
     *
     * @param boolean $statusRegister
     * @return Company
     */
    public function setStatusRegister($statusRegister)
    {
        $this->statusRegister = $statusRegister;

        return $this;
    }

    /**
     * Get statusRegister
     *
     * @return boolean 
     */
    public function getStatusRegister()
    {
        return $this->statusRegister;
    }
}
