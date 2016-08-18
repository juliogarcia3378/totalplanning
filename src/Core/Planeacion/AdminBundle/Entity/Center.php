<?php
namespace Core\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dia
 *
 * @ORM\Table(name="center")
 * @DocAssert\UniqueEntity(fields={"token","000"}, message="Ya existe ese centro registrado.")
 * @ORM\Entity(repositoryClass="Core\Planeacion\AdminBundle\Repository\CenterRepository")
 */
class Center
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="center_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=250, nullable=false)
     */
    private $location;
    
    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=250, nullable=false)
     */
    private $token;
    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=false, options={"defaults"=1})
     */
    private $activo;




    /**
     * @var \TotalPlanning\GeneralConfigBundle\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="TotalPlanning\GeneralConfigBundle\Entity\Country",inversedBy="centers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country", referencedColumnName="id")
     * })
     */
    private $country;

       /**
     * @var \TypeCenter
     *
     * @ORM\ManyToOne(targetEntity="TotalPlanning\GeneralConfigBundle\Entity\TypeCenter",inversedBy="centers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeCenter", referencedColumnName="id", nullable=false)
     * })
     */
    private $typeCenter;

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
     * Set country
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Country $country
     * @return Country
     */
    public function setCountry(\TotalPlanning\GeneralConfigBundle\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country
     *
     * @param \Core\Planeacion\AdminBundle\Entity\TypeCenter $typeCenter
     * @return TypeCenter
     */
    public function setTypeCenter(\TotalPlanning\GeneralConfigBundle\Entity\TypeCenter $typeCenter = null)
    {
        $this->typeCenter = $typeCenter;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \Core\Planeacion\AdminBundle\Entity\TypeCenter 
     */
    public function getTypeCenter()
    {
        return $this->typeCenter;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return PlanEstudio
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    
        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }


    /**
     * Set activo
     *
     * @param boolean $token
     * @return Token
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return name
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
     * Set name
     *
     * @param string $name
     * @return name
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }
    


    
    public function __toString()
    {
        return $this->name;
    }
}