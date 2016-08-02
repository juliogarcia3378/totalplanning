<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="profe_periodo")
 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\ProfePeriodoRepository")
 */
class ProfePeriodo
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="profe_periodo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="antiguedad", type="integer", nullable=false, options={"defaults"=0})
     */
    private $antiguedad;
    /**
     * @var integer
     *
     * @ORM\Column(name="horas_cubrir", type="integer", nullable=false, options={"defaults"=0})
     */
    private $horasCubrir;
    /**
     * @var integer
     *
     * @ORM\Column(name="horas_asignadas", type="integer", nullable=false, options={"defaults"=0})
     */
    private $horasAsignadas;
    /**
     * @var integer
     *
     * @ORM\Column(name="descarga_ant", type="integer", nullable=true)
     */
    private $descargaAnt;
    /**
     * @var integer
     *
     * @ORM\Column(name="descarga_admva", type="integer", nullable=true)
     */
    private $descargaADMVA;
    /**
     * @var integer
     *
     * @ORM\Column(name="asistencia_sem_anterior", type="integer", nullable=true)
     */
    private $asistenciaSemAnterior;

    /**
     * @var \Peridio
     *
     * @ORM\ManyToOne(targetEntity="Periodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="periodo", referencedColumnName="id",nullable=false)
     * })
     */
    private $periodo;


    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria", referencedColumnName="id")
     * })
     */
    private $categoria;

    /**
     * @var \Profesor
     *
     * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="profePeriodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profesor", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $profesor;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Materia", inversedBy="profePeriodo")
     * @ORM\JoinTable(name="profe_periodo_materia",
     *   joinColumns={
     *     @ORM\JoinColumn(name="profe_periodo", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="materia", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    protected $materia;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Materia", inversedBy="profePeriodoManual", cascade={"persist"})
     * @ORM\JoinTable(name="historico_materia_manual",
     *   joinColumns={
     *     @ORM\JoinColumn(name="profe_periodo", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="materia", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    protected $historicoMateriaManual;
    /**
     * @var \ProfePeriodoHorario
     *
     * @ORM\OneToMany(targetEntity="ProfePeriodoHorario",mappedBy="profePeriodo", cascade={"persist","remove"})
     */
    private $profePeriodoHorario;
    
      /**
     * @var \ProfePeriodoHorario
     *
     * @ORM\OneToMany(targetEntity="GrupoHorarioAnteproyecto",mappedBy="profePeriodo", cascade={"persist","remove"})
     */
    private $grupoHorarioAnteproyecto;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    public function getMateriaStringList()
    {
        $r = '';
        $count = 0;
        foreach($this->materia as $materia)
        {
            /**
             * @var $materia Materia
             */
            if($count++ == 0)
                $r.= $materia->getTexto();
            else
                $r.= ', '.$materia->getTexto();
        }
        return $r;
    }
    public function getHoraStringList()
    {
        $r = '';
        $count = 0;
        foreach($this->getProfePeriodoHorario() as $horario)
        {
            /**
             * @var $materia Materia
             */
            if($count++ == 0)
                $r.= $horario->getTexto();
            else
                $r.= ', '.$horario->getTexto();
        }
        return $r;
    }
    /**
     * Set horasCubrir
     *
     * @param integer $horasCubrir
     * @return ProfePeriodo
     */
    public function setHorasCubrir($horasCubrir)
    {
        $this->horasCubrir = $horasCubrir;
    
        return $this;
    }

    /**
     * Get horasCubrir
     *
     * @return integer 
     */
    public function getHorasCubrir()
    {
        return $this->horasCubrir;
    }

    /**
     * Set horasAsignadas
     *
     * @param integer $horasAsignadas
     * @return ProfePeriodo
     */
    public function setHorasAsignadas($horasAsignadas)
    {
        $this->horasAsignadas = $horasAsignadas;
    
        return $this;
    }

    /**
     * Get horasAsignadas
     *
     * @return integer 
     */
    public function getHorasAsignadas()
    {
        return $this->horasAsignadas;
    }

    /**
     * Set periodo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Periodo $periodo
     * @return ProfePeriodo
     */
    public function setPeriodo(\ADEPSOFT\Planeacion\AdminBundle\Entity\Periodo $periodo = null)
    {
        $this->periodo = $periodo;
    
        return $this;
    }

    /**
     * Get periodo
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Periodo 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set profesor
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor $profesor
     * @return ProfePeriodo
     */
    public function setProfesor(\ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor $profesor = null)
    {
        $this->profesor = $profesor;
    
        return $this;
    }

    /**
     * Get profesor
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }

    /**
     * Set descargaAnt
     *
     * @param integer $descargaAnt
     * @return ProfePeriodo
     */
    public function setDescargaAnt($descargaAnt)
    {
        $this->descargaAnt = $descargaAnt;
    
        return $this;
    }

    /**
     * Get descargaAnt
     *
     * @return integer 
     */
    public function getDescargaAnt()
    {
        return $this->descargaAnt;
    }

    /**
     * Set descargaADMVA
     *
     * @param integer $descargaADMVA
     * @return ProfePeriodo
     */
    public function setDescargaADMVA($descargaADMVA)
    {
        $this->descargaADMVA = $descargaADMVA;
    
        return $this;
    }

    /**
     * Get descargaADMVA
     *
     * @return integer 
     */
    public function getDescargaADMVA()
    {
        return $this->descargaADMVA;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->antiguedad=0;
        $this->descargaADMVA=0;
        $this->descargaAnt = 0;
        $this->horasAsignadas = 0;
        $this->asistenciaSemAnterior=0;
        $this->horasCubrir=0;
        $this->materia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profePeriodoHorario = new \Doctrine\Common\Collections\ArrayCollection();
         $this->grupoHorarioAnteproyecto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->historicoMateriaManual = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add materia
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materia
     * @return ProfePeriodo
     */
    public function addMateria(\ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materia)
    {
        $this->materia[] = $materia;
    
        return $this;
    }

    /**
     * Remove materia
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materia
     */
    public function removeMateria(\ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materia)
    {
        $this->materia->removeElement($materia);
    }

    /**
     * Get materia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * Set antiguedad
     *
     * @param integer $antiguedad
     * @return ProfePeriodo
     */
    public function setAntiguedad($antiguedad)
    {
        $this->antiguedad = $antiguedad;
    
        return $this;
    }

    /**
     * Get antiguedad
     *
     * @return integer 
     */
    public function getAntiguedad()
    {
        return $this->antiguedad;
    }

    /**
     * Set asistenciaSemAnterior
     *
     * @param integer $asistenciaSemAnterior
     * @return ProfePeriodo
     */
    public function setAsistenciaSemAnterior($asistenciaSemAnterior)
    {
        $this->asistenciaSemAnterior = $asistenciaSemAnterior;
    
        return $this;
    }

    /**
     * Get asistenciaSemAnterior
     *
     * @return integer 
     */
    public function getAsistenciaSemAnterior()
    {
        return $this->asistenciaSemAnterior;
    }

    /**
     * Set categoria
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Categoria $categoria
     * @return ProfePeriodo
     */
    public function setCategoria(\ADEPSOFT\Planeacion\AdminBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Categoria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Add profePeriodoHorario
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profePeriodoHorario
     * @return ProfePeriodo
     */
    public function addProfePeriodoHorario(\ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profePeriodoHorario)
    {
        $profePeriodoHorario->setProfePeriodo($this);
        $this->profePeriodoHorario[] = $profePeriodoHorario;
    
        return $this;
    }

    /**
     * Remove profePeriodoHorario
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profePeriodoHorario
     */
    public function removeProfePeriodoHorario(\ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profePeriodoHorario)
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

     /**
     * Add profePeriodoHorario
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profePeriodoHorario
     * @return ProfePeriodo
     */
    public function addGrupoHorarioAnteproyectoo(\ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoHorarioAnteproyecto $profePeriodoHorario)
    {
        $profePeriodoHorario->setProfePeriodo($this);
        $this->grupoHorarioAnteproyecto[] = $profePeriodoHorario;
    
        return $this;
    }

    /**
     * Remove profePeriodoHorario
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoHorarioAnteproyecto $profePeriodoHorario
     */
    public function removeGrupoHorarioAnteproyecto(\ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoHorarioAnteproyecto $profePeriodoHorario)
    {
        $this->grupoHorarioAnteproyecto->removeElement($profePeriodoHorario);
    }

    /**
     * Get profePeriodoHorario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupoHorarioAnteproyecto()
    {
        return $this->grupoHorarioAnteproyecto;
    }



    /**
     * Add historicoMateriaManual
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $historicoMateriaManual
     * @return ProfePeriodo
     */
    public function addHistoricoMateriaManual(\ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $historicoMateriaManual)
    {
        $this->historicoMateriaManual[] = $historicoMateriaManual;
    
        return $this;
    }

    /**
     * Remove historicoMateriaManual
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $historicoMateriaManual
     */
    public function removeHistoricoMateriaManual(\ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $historicoMateriaManual)
    {
        $this->historicoMateriaManual->removeElement($historicoMateriaManual);
    }

    /**
     * Get historicoMateriaManual
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHistoricoMateriaManual()
    {
        return $this->historicoMateriaManual;
    }



}