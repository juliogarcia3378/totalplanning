<?php

namespace TotalPlanning\GeneralConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rol
 *
 * @ORM\Table(name="Country")
 * @ORM\Entity(repositoryClass="TotalPlanning\GeneralConfigBundle\Repository\CountryRepository")
 */
class Country
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="country_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Campo obligatorio")
     */
    private $country_code;
    /**
     * @var string
     *
     * @ORM\Column(name="country_name", type="text", nullable=false)
     */
    private $country_name;

    /**
    * @var \Center
     *
     * @ORM\OneToMany(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\Center", mappedBy="country", cascade={"persist","remove"})
     */
    private $centers;

  
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
     * Set country_code
     *
     * @param string $country_code
     * @return Menu
     */
    public function setCountryCode($country_code)
    {
        $this->country_code = $country_code;

        return $this;
    }

    /**
     * Get country_code
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }

    /**
     * Set country_code
     *
     * @param string $country_code
     * @return Menu
     */
    public function setCountryName($country_code)
    {
        $this->country_name= $country_code;

        return $this;
    }

    /**
     * Get country_code
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->country_name;
    }


 public function __construct()
    {
        $this->centers = new \Doctrine\Common\Collections\ArrayCollection();
    }

     /**
     * Add Center
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Center $center
     * @return Profesor
     */
    public function addCenter(\ADEPSOFT\Planeacion\AdminBundle\Entity\Center $center)
    {
        $centers->setCountry($this);
        $this->centers[] = $center;
    
        return $this;
    }

    /**
     * Remove Center
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Center $Center
     */
    public function removeCenter(\ADEPSOFT\Planeacion\AdminBundle\Entity\Center $Center)
    {
        $this->Center->removeElement($Center);
    }

    /**
     * Get Center
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCenter()
    {
        return $this->centers;
    }

}