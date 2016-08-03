<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use ADEPSOFT\ComunBundle\Util\FechaUtil;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * HoraPeriodo
 *
 * @ORM\Table(name="hora_periodo")
 * @DocAssert\UniqueEntity(fields={"nombre","periodo"}, message="La hora ya se encuentra registrada en ese período.",errorPath="horaTime")
 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\HoraPeriodoRepository")
 */
class HoraPeriodo
{
    /**
     * @var float
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="hora_periodo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;


//    /**
//     * @var \Hora
//     *
//     * @ORM\ManyToOne(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\Hora",inversedBy="horaPeriodo")
//     * @ORM\JoinColumns({
//     *   @ORM\JoinColumn(name="hora", referencedColumnName="id",nullable=true)
//     * })
//     */
//    private $hora;
    /**
     * @var time
     *
     * @ORM\Column(name="hora_time", type="time",  nullable=false)
     */
    private $horaTime;
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;
//    /**
//     * @var \Doctrine\Common\Collections\Collection
//     *
//     * @ORM\ManyToMany(targetEntity="Dia")
//     * @ORM\JoinTable(name="hora_periodo_dia",
//     *   joinColumns={
//     *     @ORM\JoinColumn(name="hora_periodo", referencedColumnName="id", onDelete="CASCADE")
//     *   },
//     *   inverseJoinColumns={
//     *     @ORM\JoinColumn(name="dia", referencedColumnName="id", onDelete="CASCADE")
//     *   }
//     * )
//     */
//    protected $dia;
    /**
     * @var \Periodo
     *
     * @ORM\ManyToOne(targetEntity="Periodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="periodo", referencedColumnName="id",nullable=true)
     * })
     */
    private $periodo;
    /**
     * @var \Periodo
     *
     * @ORM\ManyToOne(targetEntity="Turno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="turno", referencedColumnName="id",nullable=true)
     * })
     */
    private $turno;

//    /**
//     * Get nombre
//     *
//     * @return string
//     */
//    public function getDiaStringList()
//    {
//        $r = '';
//        $count = 0;
//        foreach($this->dia as $dia)
//        {
//            /**
//             * @var $materia Materia
//             */
//            if($count++ == 0)
//                $r.= $dia->getNombre();
//            else
//                $r.= ', '.$dia->getNombre();
//        }
//        return $r;
//    }
    /**
     * Constructor
     */
    public function __construct()
    {
//        $this->dia = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get periodo
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Periodo 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set turno
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Turno $turno
     * @return HoraDiaPeriodo
     */
    public function setTurno(\ADEPSOFT\Planeacion\AdminBundle\Entity\Turno $turno = null)
    {
        $this->turno = $turno;
    
        return $this;
    }

    /**
     * Get turno
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Turno 
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * Set horaTime
     *
     * @param \DateTime $horaTime
     * @return HoraPeriodo
     */
    public function setHoraTime($horaTime)
    {
        if($horaTime instanceof \DateTime) {
            $this->horaTime = $horaTime;
            $var = $this->horaTime->format(FechaUtil::getTimeFormat());
            $this->nombre = $var;
        }
        return $this;
    }

    /**
     * Get horaTime
     *
     * @return \DateTime 
     */
    public function getHoraTime()
    {
        return $this->horaTime;
    }

    /**
     * Set periodo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Periodo $periodo
     * @return HoraPeriodo
     */
    public function setPeriodo(\ADEPSOFT\Planeacion\AdminBundle\Entity\Periodo $periodo = null)
    {
        $this->periodo = $periodo;
    
        return $this;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return HoraPeriodo
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
}