<?php
namespace Core\Planeacion\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Materia
 *
 * @ORM\Table(name="materia")
 * @ORM\HasLifecycleCallbacks()
 * @DocAssert\UniqueEntity(fields={"clave","planEstudio"}, message="Ya existe una materia con esa clave en ese plan de estudio.")
 * @ORM\Entity(repositoryClass="Core\Planeacion\AdminBundle\Repository\MateriaRepository")
 */
class Materia
{
    /**
     * @var float
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="materia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", length=10,nullable=false)
     */
    private $clave;

    /**
     * @var integer
     *
     * @ORM\Column(name="frecuencia_semanal", type="integer", nullable=true)
     */
    private $frecuenciaSemanal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=false, options={"default" = 1})
     */
    private $activo;


    /**
     * @var \Semestre
     *
     * @ORM\ManyToOne(targetEntity="Semestre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="semestre", referencedColumnName="id")
     * })
     */
    private $semestre;
    /**
     * @var \PlanEstudio
     *
     * @ORM\ManyToOne(targetEntity="PlanEstudio",inversedBy="materias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plan_estudio", referencedColumnName="id")
     * })
     */
    private $planEstudio;
    /**
     * @var \TipoMateria
     *
     * @ORM\ManyToOne(targetEntity="TipoMateria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_materia", referencedColumnName="id", nullable=false)
     * })
     */
    private $tipoMateria;

    /**
     * @var \ProfePeriodo
     *
     * @ORM\ManyToMany(targetEntity="ProfePeriodo",mappedBy="materia", cascade={"persist","remove"})
     */
    private $profePeriodo;
    /**
     * @var \ProfePeriodo
     *
     * @ORM\ManyToMany(targetEntity="ProfePeriodo",mappedBy="historicoMateriaManual", cascade={"persist","remove"})
     */
    private $profePeriodoManual;
    /**
     * @var \PreferenciaProfeMateria
     *
     * @ORM\OneToMany(targetEntity="PreferenciaProfeMateria",mappedBy="materia", cascade={"persist","remove"})
     */
    private $preferenciaProfeMateria;

    /**
     * @var \PreferenciaProfeMateria
     *
     * @ORM\OneToMany(targetEntity="ProfePeriodoHorario",mappedBy="materia", cascade={"persist","remove"})
     */
    private $profePeriodoHorario;
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function events()
    {
        if($this->getSemestre() == null && $this->getTipoMateria()->getId() == 1 && $this->getActivo() == true)
            throw new Exception('Error');
        $this->nombre=strtoupper($this->nombre);
    }
    public function getTextoSinLicenciatura()
    {
        return $this->getClave().'-'.$this->getNombre();
    }
    public function getTexto()
    {
        if($this->getPlanEstudio() != null) {
            return $this->getClave() . '-' . $this->getNombre() . '-' . $this->getCarrera();
        }
        else
            return $this->getClave() . '-' . $this->getNombre() ;
    }
    public function getTextoConSemestre()
    {
        if($this->getPlanEstudio() != null) {
            if ($this->getSemestre())
                return $this->getClave() . '-' . $this->getNombre() . '-' . $this->getCarrera() . '/Sem:' . $this->getSemestre()->getNombre();
            else
                return $this->getClave() . '-' . $this->getNombre() . '-' . $this->getCarrera();
        }
        else{
            if ($this->getSemestre())
                return $this->getClave() . '-' . $this->getNombre();
            else
                return $this->getClave() . '-' . $this->getNombre();
        }
    }
    public function getCarrera()
    {
        return substr(ucfirst($this->getPlanEstudio()->getCarrera()->getNombre()),0,1);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activo=true;
        $this->profePeriodo=new ArrayCollection();
        $this->profePeriodoManual=new ArrayCollection();
        $this->preferenciaProfeMateria=new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Materia
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
     * Set clave
     *
     * @param string $clave
     * @return Materia
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    
        return $this;
    }

    /**
     * Get clave
     *
     * @return string 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set frecuenciaSemanal
     *
     * @param integer $frecuenciaSemanal
     * @return Materia
     */
    public function setFrecuenciaSemanal($frecuenciaSemanal)
    {
        $this->frecuenciaSemanal = $frecuenciaSemanal;
    
        return $this;
    }

    /**
     * Get frecuenciaSemanal
     *
     * @return integer 
     */
    public function getFrecuenciaSemanal()
    {
        return $this->frecuenciaSemanal;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Materia
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
     * Set semestre
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Semestre $semestre
     * @return Materia
     */
    public function setSemestre(\Core\Planeacion\AdminBundle\Entity\Semestre $semestre = null)
    {
        $this->semestre = $semestre;
    
        return $this;
    }

    /**
     * Get semestre
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Semestre 
     */
    public function getSemestre()
    {
        return $this->semestre;
    }


    /**
     * Set planEstudio
     *
     * @param \Core\Planeacion\AdminBundle\Entity\PlanEstudio $planEstudio
     * @return Materia
     */
    public function setPlanEstudio(\Core\Planeacion\AdminBundle\Entity\PlanEstudio $planEstudio = null)
    {
        $this->planEstudio = $planEstudio;

        return $this;
    }

    /**
     * Get planEstudio
     *
     * @return \Core\Planeacion\AdminBundle\Entity\PlanEstudio
     */
    public function getPlanEstudio()
    {
        return $this->planEstudio;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="horas_extra", type="boolean", nullable=false, options={"default"=0})
     */
    private $horasextra;

    /**
     * Add profePeriodo
     *
     * @param \Core\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodo
     * @return Materia
     */
    public function addProfePeriodo(\Core\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodo)
    {
        $profePeriodo->addMateria($this);
        $this->profePeriodo[] = $profePeriodo;
    
        return $this;
    }

    /**
     * Remove profePeriodo
     *
     * @param \Core\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodo
     */
    public function removeProfePeriodo(\Core\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodo)
    {
        $profePeriodo->removeMateria($this);
        $this->profePeriodo->removeElement($profePeriodo);
    }

    /**
     * Get profePeriodo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfePeriodo()
    {
        return $this->profePeriodo;
    }

    /**
     * Add profePeriodoManual
     *
     * @param \Core\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodoManual
     * @return Materia
     */
    public function addProfePeriodoManual(\Core\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodoManual)
    {
        $profePeriodoManual->addHistoricoMateriaManual($this);
        $this->profePeriodoManual[] = $profePeriodoManual;
    
        return $this;
    }

    /**
     * Remove profePeriodoManual
     *
     * @param \Core\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodoManual
     */
    public function removeProfePeriodoManual(\Core\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodoManual)
    {
        $this->profePeriodoManual->removeElement($profePeriodoManual);
    }

    /**
     * Get profePeriodoManual
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfePeriodoManual()
    {
        return $this->profePeriodoManual;
    }

    /**
     * Set tipoMateria
     *
     * @param \Core\Planeacion\AdminBundle\Entity\TipoMateria $tipoMateria
     * @return Materia
     */
    public function setTipoMateria(\Core\Planeacion\AdminBundle\Entity\TipoMateria $tipoMateria = null)
    {
        $this->tipoMateria = $tipoMateria;
    
        return $this;
    }

    /**
     * Get tipoMateria
     *
     * @return \Core\Planeacion\AdminBundle\Entity\TipoMateria 
     */
    public function getTipoMateria()
    {
        return $this->tipoMateria;
    }

    /**
     * Set horasextra
     *
     * @param boolean $horasextra
     * @return GrupoEstudiantes
     */
    public function setHorasExtra($horasextra)
    {
        $this->horasextra = $horasextra;
        return $this;
    }

    /**
     * Get horasextra
     *
     * @return boolean
     */
    public function getHorasExtra()
    {
        return $this->horasextra;
    }

    /**
     * Add preferenciaProfeMateria
     *
     * @param \Core\Planeacion\AdminBundle\Entity\PreferenciaProfeMateria $preferenciaProfeMateria
     * @return Materia
     */
    public function addPreferenciaProfeMateria(\Core\Planeacion\AdminBundle\Entity\PreferenciaProfeMateria $preferenciaProfeMateria)
    {
        $this->preferenciaProfeMateria[] = $preferenciaProfeMateria;
    
        return $this;
    }

    /**
     * Remove preferenciaProfeMateria
     *
     * @param \Core\Planeacion\AdminBundle\Entity\PreferenciaProfeMateria $preferenciaProfeMateria
     */
    public function removePreferenciaProfeMateria(\Core\Planeacion\AdminBundle\Entity\PreferenciaProfeMateria $preferenciaProfeMateria)
    {
        $this->preferenciaProfeMateria->removeElement($preferenciaProfeMateria);
    }

    /**
     * Get preferenciaProfeMateria
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreferenciaProfeMateria()
    {
        return $this->preferenciaProfeMateria;
    }

    public function getclaveNombreCarrera()
    {
        if ($this->planEstudio != null) {
            return $this->clave . ' / ' . $this->nombre . '[' . $this->planEstudio->getLicenciatura()->getNombre() . ']';
        } else {
            return null;
        }
    }
}