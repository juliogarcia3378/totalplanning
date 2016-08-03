<?php

namespace TotalPlanning\GeneralConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rol
 *
 * @ORM\Table(name="TypeCenter")
 * @ORM\Entity(repositoryClass="TotalPlanning\GeneralConfigBundle\Repository\TypeCenterRepository")
 */
class TypeCenter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="typeCenter_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="typeCenter", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Campo obligatorio")
     */
    private $typeCenter;
   

   
   /**
     *
     * @ORM\OneToMany(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\Center", mappedBy="typeCenter", cascade={"persist","remove"})
     */
    private $centers;

    


    public function __construct()
    {
       
        $this->centers = new \Doctrine\Common\Collections\ArrayCollection();
       
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
     * Set typeCenter
     *
     * @param string $typeCenter
     * @return Menu
     */
    public function setTypeCenter($typeCenter)
    {
        $this->typeCenter = $typeCenter;

        return $this;
    }

    /**
     * Get typeCenter
     *
     * @return string
     */
    public function getTypeCenter()
    {
        return $this->typeCenter;
    }

   


}