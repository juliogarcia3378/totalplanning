<?php

namespace TotalPlanning\GeneralConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rol
 *
 * @ORM\Table(name="position")
 * @ORM\Entity(repositoryClass="TotalPlanning\GeneralConfigBundle\Repository\PositionRepository")
 */
class Position
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="Position_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Campo obligatorio")
     */
    private $position;
   

  
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
     * Set Position
     *
     * @param string $Position
     * @return Menu
     */
    public function setPosition($Position)
    {
        $this->position= $Position;

        return $this;
    }

    /**
     * Get Position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }


    public function __construct()
    {
    }

    

}