<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="grupo_horario_anteproyecto")
 * * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\GrupoHorarioAnteproyectoRepository")
 */
class GrupoHorarioAnteproyecto
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="grupo_horario_anteproyecto_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * @var \Materia
     *
     * @ORM\ManyToOne(targetEntity="Materia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="materia", referencedColumnName="id")
     * })
     */
    private $materia;
    /**
     * @var \HoraPeriodo
     *
     * @ORM\ManyToOne(targetEntity="HoraPeriodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hora_periodo", referencedColumnName="id",nullable=true)
     * })
     */
    private $hora;
    /**
     * @var \GrupoEstudiantes
     *
     * @ORM\ManyToOne(targetEntity="GrupoEstudiantes",inversedBy="profePeriodoHorario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grupo_estudiantes", referencedColumnName="id")
     * })
     */
    private $grupo;

    /**
     * @var \Dia
     *
     * @ORM\ManyToOne(targetEntity="Dia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dia", referencedColumnName="id")
     * })
     */
    private $dia;

    /**
     * @var \Aula
     *
     * @ORM\ManyToOne(targetEntity="Aula")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aula", referencedColumnName="id",nullable=true)
     * })
     */
    private $aula;


    /**
     * @var \ProfePeriodo
     *
     * @ORM\ManyToOne(targetEntity="ProfePeriodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profe_periodo", referencedColumnName="id",nullable=true)
     * })
     */
    private $profePeriodo;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    public function getTexto()
    {
        $dia = substr($this->getDia()->getNombre(),0,3);
        $hora = $this->getHora()->getNombre();
        $materia = $this->getMateria()->getTexto();
        $grupo = $this->getGrupo()->getNombreCompleto();
//        return $dia.':'.$hora.':'.$materia.':'.$grupo;
//        ldd($dia);
        return $this->getMateria()->getClave().'-'.$this->getDia()->getNombre().'-'.$hora;
    }


    /**
     * Set profePeriodo
     *
     */
    public function setAula(\ADEPSOFT\Planeacion\AdminBundle\Entity\Aula $aula = null)
    {
        $this->aula = $aula;

        return $this;
    }

    public function getAula()
    {
        return $this->aula;
    }

    /**
     * Set materia
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materia
     * @return ProfePeriodoMateria
     */
    public function setMateria(\ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materia = null)
    {
        $this->materia = $materia;
    
        return $this;
    }

    /**
     * Get materia
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia 
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * Set grupo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo $grupo
     * @return ProfePeriodoHorario
     */
    public function setProfePeriodo(\ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo $grupo = null)
    {
        $this->profePeriodo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo
     */
    public function getProfePeriodo()
    {
        return $this->profePeriodo;
    }
    /**
     * Set dia
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Dia $dia
     * @return ProfePeriodoMateria
     */
    public function setDia(\ADEPSOFT\Planeacion\AdminBundle\Entity\Dia $dia = null)
    {
        $this->dia = $dia;
    
        return $this;
    }

    /**
     * Get dia
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Dia 
     */
    public function getDia()
    {
        return $this->dia;
    }


    /**
     * Set grupo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $grupo
     * @return ProfePeriodoHorario
     */
    public function setGrupo(\ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $grupo = null)
    {
        $this->grupo = $grupo;
    
        return $this;
    }

    /**
     * Get grupo
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
     /**
     * set grupo
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo
     */
    public function removeProfePeriodo()
    {
       $this->profePeriodo=null;
    }

    /**
     * Set hora
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\HoraPeriodo $hora
     * @return ProfePeriodoHorario
     */
    public function setHora(\ADEPSOFT\Planeacion\AdminBundle\Entity\HoraPeriodo $hora = null)
    {
        $this->hora = $hora;
    
        return $this;
    }

    /**
     * Get hora
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\HoraPeriodo 
     */
    public function getHora()
    {
        return $this->hora;
    }


}