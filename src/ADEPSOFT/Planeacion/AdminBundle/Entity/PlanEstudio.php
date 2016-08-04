<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dia
 *
 * @ORM\Table(name="plan_estudio")
 * @DocAssert\UniqueEntity(fields={"nombre","Carrera"}, message="Ya existe un plan de estudio con ese nombre en esa Carrera.")
 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\PlanEstudioRepository")
 */
class PlanEstudio
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="plan_estudio_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;
    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=false, options={"defaults"=1})
     */
    private $activo;


    /**
     * @var \Materia
     *
     * @ORM\OneToMany(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\Materia",mappedBy="planEstudio")
     */
    private $materias;

    /**
     * @var \GrupoEstudiantes
     *
     * @ORM\OneToMany(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes",mappedBy="plan_estudio")
     */
    private $grupoEstudiantes;

    /**
     * @var \Carrera
     *
     * @ORM\ManyToOne(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\Carrera",inversedBy="planEstudio")
     * @ORM\JoinColumns({
     * })
     */
    private $carrera;

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
     * Get nombre
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->nombre.'-'.substr(ucfirst($this->getCarrera()->getNombre()),0,1);
    }
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Dia
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
     * Set Carrera
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Carrera $carrera
     * @return Carrera
     */
    public function setCarrera(\ADEPSOFT\Planeacion\AdminBundle\Entity\Carrera $Carrera = null)
    {
        $this->carrera = $Carrera;
    
        return $this;
    }

    /**
     * Get Carrera
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Carrera 
     */
    public function getCarrera()
    {
        return $this->carrera;
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
     * Constructor
     */
    public function __construct()
    {
        $this->materias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupoEstudiantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add materias
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materias
     * @return PlanEstudio
     */
    public function addMateria(\ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materias)
    {
        $this->materias[] = $materias;

        return $this;
    }

    /**
     * Remove materias
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materias
     */
    public function removeMateria(\ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materias)
    {
        $this->materias->removeElement($materias);
    }

    /**
     * Get materias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMaterias()
    {
        return $this->materias;
    }
    /**
     * Add materias
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $grupoEstudiants
     * @return PlanEstudio
     */
    public function addGrupoEstudiantes(\ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $grupoEstudiantes)
    {
        $this->grupoEstudiantes[] = $grupoEstudiantes;

        return $this;
    }

    /**
     * Remove materias
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $estu
     */
    public function removeGrupoEstudiantes(\ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $est)
    {
        $this->grupoEstudiantes->removeElement($est);
    }

    /**
     * Get materias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrupoEstudiantes()
    {
        return $this->grupoEstudiantes;
    }
    public function __toString()
    {
        return $this->nombre;
    }
}