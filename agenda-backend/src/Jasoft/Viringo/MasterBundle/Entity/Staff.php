<?php

namespace Jasoft\Viringo\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Staff
 *
 * @ORM\Table(name="master_o_staff")
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\MasterBundle\Repository\StaffRepository")
 */
class Staff
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pkStaff", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pkStaff;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint")
     * @Serializer\SerializedName(value="keySpring")
     */
    private $keySpring;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     * @Serializer\SerializedName(value="firstlastname")
     */
    private $firstlastname;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     * @Serializer\SerializedName(value="secondlastname")
     */
    private $secondlastname;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     * @Serializer\SerializedName(value="name")
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     * @Serializer\SerializedName(value="login")
     */
    private $login;
    
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Serializer\SerializedName(value="email")
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     * @Serializer\SerializedName(value="statusRegister")
     */
    private $statusRegister;
    

    /**
     * Get pkStaff
     *
     * @return integer 
     */
    public function getPkStaff()
    {
        return $this->pkStaff;
    }

    /**
     * Set keySpring
     *
     * @param integer $keySpring
     * @return Staff
     */
    public function setKeySpring($keySpring)
    {
        $this->keySpring = $keySpring;

        return $this;
    }

    /**
     * Get keySpring
     *
     * @return integer 
     */
    public function getKeySpring()
    {
        return $this->keySpring;
    }

    /**
     * Set firstlastname
     *
     * @param string $firstlastname
     * @return Staff
     */
    public function setFirstlastname($firstlastname)
    {
        $this->firstlastname = $firstlastname;

        return $this;
    }

    /**
     * Get firstlastname
     *
     * @return string 
     */
    public function getFirstlastname()
    {
        return $this->firstlastname;
    }

    /**
     * Set secondlastname
     *
     * @param string $secondlastname
     * @return Staff
     */
    public function setSecondlastname($secondlastname)
    {
        $this->secondlastname = $secondlastname;

        return $this;
    }

    /**
     * Get secondlastname
     *
     * @return string 
     */
    public function getSecondlastname()
    {
        return $this->secondlastname;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Staff
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
     * Set login
     *
     * @param string $login
     * @return Staff
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Staff
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set statusRegister
     *
     * @param boolean $statusRegister
     * @return Staff
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
