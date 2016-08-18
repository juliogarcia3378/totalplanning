<?php
namespace Core\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dia
 *
 * @ORM\Table(name="grupo_estudiantes")
 * @ORM\HasLifecycleCallbacks()

 * @DocAssert\UniqueEntity(fields={"nombre","semestre","carrera","turno","periodo"}, message="Ya existe ese grupo en ese período.")
 * @ORM\Entity(repositoryClass="Core\Planeacion\AdminBundle\Repository\GrupoEstudiantesRepository")
 */
class GrupoEstudiantes
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="grupo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nivel", type="integer",  nullable=true)
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_completo", type="string", length=50, nullable=true)
     */
    private $nombre;
    /**
     * @var string
     *
     * @ORM\Column(name="aula_string", type="string", length=50, nullable=true)
     */
    private $aulaString;
    /**
     * @var \Turno
     *
     * @ORM\ManyToOne(targetEntity="Turno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="turno", referencedColumnName="id")
     * })
     */
    private $turno;
    /**
     * @var \Aula
     *
     * @ORM\ManyToOne(targetEntity="Aula",inversedBy="grupo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aula", referencedColumnName="id")
     * })
     */
    private $aula;
    /**
     * @var \Carrera	
     *
     * @ORM\ManyToOne(targetEntity="Carrera")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="carrera", referencedColumnName="id")
     * })
     */
    private $carrera;
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
     * @var \Periodo
     *
     * @ORM\ManyToOne(targetEntity="Periodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="periodo", referencedColumnName="id")
     * })
     */
    private $periodo;
    /**
     * @var boolean
     *
     * @ORM\Column(name="bilingue", type="boolean", nullable=false, options={"defaults"=0})
     */
    private $bilingue;
    /**
     * @var boolean
     *
     * @ORM\Column(name="terceros", type="boolean", nullable=false, options={"defaults"=0})
     */
    private $terceros;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paquete", type="boolean", nullable=true, options={"defaults"=0})
     */
    private $paquete;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enlinea", type="boolean", nullable=true, options={"defaults"=0})
     */
    private $enlinea;

   
    /**
     * @var \PlanEstudio
     *
     * @ORM\ManyToOne(targetEntity="PlanEstudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plan_estudio", referencedColumnName="id")
     * })
     */
    private $plan_estudio;
    /**
     * @var \ProfePeriodoHorario
     *
     * @ORM\OneToMany(targetEntity="Core\Planeacion\AdminBundle\Entity\ProfePeriodoHorario",mappedBy="grupo")
     */
    private $profePeriodoHorario;
    ///**
    // * @ORM\PrePersist
    // * @ORM\PreUpdate
    //
    /*public function events()
    {
        if($this->getAula() != null)
            $this->aulaString = $this->getAula()->getNombre();

        if($this->getNombre() > 9 && !$this->getTerceros())
        {
            if($this->getNombre() == 10 ||$this->getTurno()->getId() == ETurno::Nocturno) {
                $name = $this->getTurno()->getId() * 10 + $this->getNombre();
                $this->nombreCompleto = $this->getSemestre()->getNombre2Digitos() . $name . substr(ucfirst($this->getcarrera	()->getNombre()), 0, 1);
            }
            else
            {
                $name = ucfirst( substr($this->getTurno()->getNombre(),0,1)).($this->getNombre()%10);
                $this->nombreCompleto = $this->getSemestre()->getNombre2Digitos() . $name . substr(ucfirst($this->getcarrera	()->getNombre()), 0, 1);
            }
        }
        elseif(!$this->getTerceros())
            $this->nombreCompleto =  $this->getSemestre()->getNombre2Digitos().$this->getTurno()->getId().$this->getNombre().substr(ucfirst($this->getcarrera	()->getNombre()),0,1);
        else {
            $ceros = 3-strlen($this->getNombre());
            $str='';
            for($i=0;$i<$ceros;$i++)
                $str.='0';
            $this->nombreCompleto = $this->getSemestre()->getNombre2Digitos().$str.$this->getNombre() . substr(ucfirst($this->getcarrera	()->getNombre()), 0, 1);
        }

        if($this->campus->getId() != ECampus::UANL)
            $this->nombreCompleto =  substr(ucfirst($this->getCampus()->getNombre()), 0, 1).$this->nombreCompleto;
    }*/
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
    */
    public function events()
    {
        if($this->getAula() != null)
            $this->aulaString = $this->getAula()->getNombre();
	}

    /**
     * Get planEstudio
     *
     * @return integer
     */
    public function getPlanEstudio()
    {
        return $this->plan_estudio;
    }

    /**
     * Set planEstudio
     *
     * @param integer $plan
     * @return GrupoEstudiantes
     */
    public function setPlanEstudio($plan)
    {
        $this->plan_estudio = $plan;
        return $this;
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
     * Set nombre
     *
     * @param string $nombreCompleto
     * @return GrupoEstudiantes
     */
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombre = $nombreCompleto;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombreCompleto()
    {
        return $this->nombre;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombreCompletoAula()
    {
        return $this->getNombre()."/".$this->getAula()->getNombre();
    }


    /**
     * Set carrera	
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Carrera $carrera	
     * @return GrupoEstudiantes
     */
    public function setCarrera(\Core\Planeacion\AdminBundle\Entity\Carrera $carrera	= null)
    {
        $this->carrera	 = $carrera	;
    
        return $this;
    }

    /**
     * Get carrera	
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Carrera	 
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * Set turno
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Turno $turno
     * @return GrupoEstudiantes
     */
    public function setTurno(\Core\Planeacion\AdminBundle\Entity\Turno $turno = null)
    {
        $this->turno = $turno;
    
        return $this;
    }

    /**
     * Get turno
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Turno 
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * Set periodo
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Periodo $periodo
     * @return GrupoEstudiantes
     */
    public function setPeriodo(\Core\Planeacion\AdminBundle\Entity\Periodo $periodo = null)
    {
        $this->periodo = $periodo;
    
        return $this;
    }

    /**
     * Get periodo
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Periodo 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set aula
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Aula $aula
     * @return GrupoEstudiantes
     */
    public function setAula(\Core\Planeacion\AdminBundle\Entity\Aula $aula = null)
    {
        $this->aula = $aula;
    
        return $this;
    }

    /**
     * Get aula
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Aula 
     */
    public function getAula()
    {
        return $this->aula;
    }

    /**
     * Set semestre
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Semestre $semestre
     * @return GrupoEstudiantes
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
     * Set nivel
     *
     * @param integer $nivel
     * @return GrupoEstudiantes
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    
        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer 
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set aulaString
     *
     * @param string $aulaString
     * @return GrupoEstudiantes
     */
    public function setAulaString($aulaString)
    {
        $this->aulaString = $aulaString;
    
        return $this;
    }

    /**
     * Get aulaString
     *
     * @return string 
     */
    public function getAulaString()
    {
        return $this->aulaString;
    }

    /**
     * Set paquete
     *
     * @param boolean $paquete
     * @return GrupoEstudiantes
     */
    public function setPaquete($paquete)
    {
        $this->paquete = $paquete;
        return $this;
    }

    /**
     * Get paquete
     *
     * @return boolean
     */
    public function getPaquete()
    {
        return $this->paquete;
    }

    /**
     * Set bilingue
     *
     * @param boolean $bilingue
     * @return GrupoEstudiantes
     */
    public function setBilingue($bilingue)
    {
        $this->bilingue = $bilingue;
    
        return $this;
    }

    /**
     * Get bilingue
     *
     * @return boolean 
     */
    public function getBilingue()
    {
        return $this->bilingue;
    }
    
    public function getBilingueText()
    {
        $val = 'No';
        if ($this->bilingue){$val = 'Sí';}
        return $val;
    }

   
    
  

    /**
     * Set enlinea
     *
     * @param boolean $enlinea
     * @return GrupoEstudiantes
     */
    public function setEnLinea($enlinea)
    {
        $this->enlinea = $enlinea;

        return $this;
    }

    /**
     * Get enlinea
     *
     * @return boolean
     */
    public function getEnLinea()
    {
        return $this->enlinea;
    }

    /**
     * Set terceros
     *
     * @param boolean $terceros
     * @return GrupoEstudiantes
     */
    public function setTerceros($terceros)
    {
        $this->terceros = $terceros;
    
        return $this;
    }

    /**
     * Get terceros
     *
     * @return boolean 
     */
    public function getTerceros()
    {
        return $this->terceros;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->profePeriodoHorario = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add profePeriodoHorario
     *
     * @param \Core\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profePeriodoHorario
     * @return GrupoEstudiantes
     */
    public function addProfePeriodoHorario(\Core\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profePeriodoHorario)
    {
        $this->profePeriodoHorario[] = $profePeriodoHorario;
    
        return $this;
    }

    /**
     * Remove profePeriodoHorario
     *
     * @param \Core\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profePeriodoHorario
     */
    public function removeProfePeriodoHorario(\Core\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profePeriodoHorario)
    {
        $this->profePeriodoHorario->removeElement($profePeriodoHorario);
    }

    /**
     * Get profePeriodoHorario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfePeriodoHorario()
    {
        return $this->profePeriodoHorario;
    }
}
