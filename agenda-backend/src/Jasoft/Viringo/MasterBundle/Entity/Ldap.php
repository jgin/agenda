<?php

namespace Jasoft\Viringo\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Ldap
 *
 * @ORM\Table(name="master_o_ldap")
 * @ORM\Entity(repositoryClass="Jasoft\Viringo\MasterBundle\Repository\LdapRepository")
 */
class Ldap
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pkLdap", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pkLdap;

    /**
     * @var Staff
     *
     * @ORM\ManyToOne(targetEntity="Staff")
     * @ORM\JoinColumn(name="fkStaff", referencedColumnName="pkStaff")
     */
    private $staff;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $login;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40)
     */
    private $password;
    

    /**
     * Get pkLdap
     *
     * @return integer 
     */
    public function getPkLdap()
    {
        return $this->pkLdap;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Ldap
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
     * Set password
     *
     * @param string $password
     * @return Ldap
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set staff
     *
     * @param \Jasoft\Viringo\MasterBundle\Entity\Staff $staff
     * @return Ldap
     */
    public function setStaff(\Jasoft\Viringo\MasterBundle\Entity\Staff $staff = null)
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * Get staff
     *
     * @return \Jasoft\Viringo\MasterBundle\Entity\Staff 
     */
    public function getStaff()
    {
        return $this->staff;
    }
}
