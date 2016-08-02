<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carrera
 *
 * @ORM\Table(name="Carrera")
 * @ORM\Entity(repositoryClass="ADEPSOFT\ComunBundle\Util\NomencladoresRepository")
 */
class Carrera
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="Carrera_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;

    /**
     *
     * @ORM\OneToMany(targetEntity="PlanEstudio", mappedBy="Carrera", cascade={"persist","remove"})
     */
    private $planEstudio;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    public function __toString(){
        return $this->getNombre();
    }
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Carrera
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->planEstudio = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Add planEstudio
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\PlanEstudio $planEstudio
     * @return Carrera
     */
    public function addPlanEstudio(\ADEPSOFT\Planeacion\AdminBundle\Entity\PlanEstudio $planEstudio)
    {
        $planEstudio->setCarrera($this);
        $this->planEstudio[] = $planEstudio;
    
        return $this;
    }

    /**
     * Remove planEstudio
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\PlanEstudio $planEstudio
     */
    public function removePlanEstudio(\ADEPSOFT\Planeacion\AdminBundle\Entity\PlanEstudio $planEstudio)
    {
        $this->planEstudio->removeElement($planEstudio);
    }

    /**
     * Get planEstudio
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlanEstudio()
    {
        return $this->planEstudio;
    }
}