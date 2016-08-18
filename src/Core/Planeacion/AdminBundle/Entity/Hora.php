<?php
namespace Core\Planeacion\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hora
 *
 * @ORM\Table(name="hora")
 * @ORM\HasLifecycleCallbacks()
 * @DocAssert\UniqueEntity(fields={"nombre"}, message="La hora ya se encuentra registrada.",errorPath="hora")
 * @ORM\Entity(repositoryClass="Core\Planeacion\AdminBundle\Repository\HoraRepository")
 */
class Hora
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="hora_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false, unique=true)
     */
    private $nombre;

    /**
     * @var time
     *
     * @ORM\Column(name="hora", type="time",  nullable=false)
     */
    private $hora;
    /**
     * @var string
     *
     * @ORM\Column(name="activa", type="boolean", nullable=true, options={"defaults"=1})
     */
    private $activo;
    /**
     * @var \HoraPeriodo
     *
     * @ORM\OneToMany(targetEntity="HoraPeriodo", mappedBy="hora")
     */
    private $horaPeriodo;
    /**
     * @var \PreferenciaProfeHora
     *
     * @ORM\OneToMany(targetEntity="PreferenciaProfeHora", mappedBy="hora")
     */
    private $preferenciaProfehora;
        /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Dia")
     * @ORM\JoinTable(name="hora_dia",
     *   joinColumns={
     *     @ORM\JoinColumn(name="hora", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dia", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    protected $dia;
    /**
     * Get nombre
     *
     * @return string
     */
    public function getDiaStringList()
    {
        $r = '';
        $count = 0;
        foreach($this->dia as $dia)
        {
            /**
             * @var $materia Materia
             */
            if($count++ == 0)
                $r.= $dia->getNombre();
            else
                $r.= ', '.$dia->getNombre();
        }
        return $r;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activo=true;
        $this->horaPeriodo =new ArrayCollection();
        $this->dia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preferenciaProfehora= new \Doctrine\Common\Collections\ArrayCollection();
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
//    /**
//     * @ORM\PrePersist
//     * @ORM\PreUpdate
//     */
//    public function event()
//    {
//        $hora = $this->hora;
//        ld($hora);
//        if($hora instanceof \DateTime)
//            $this->nombre = $hora->format('H').":".$hora->format('i');
//    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Hora
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
     * Set hora
     *
     * @param \DateTime $hora
     * @return Hora
     */
    public function setHora($hora)
    {
        if($hora instanceof \DateTime) {
            $this->hora = $hora;
            $var = ($this->hora->format('H') . ":" . $this->hora->format('i'));
            $this->nombre = $var;
        }
//        elseif($hora != null) {
//            $this->hora = Util::convertStringToTime($hora);
//            $var = ($this->hora->format('H') . ":" . $this->hora->format('i'));
//            $this->nombre = $var;
//        }
        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Hora
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
     * Add horaPeriodo
     *
     * @param \Core\Planeacion\AdminBundle\Entity\HoraPeriodo $horaPeriodo
     * @return Hora
     */
    public function addHoraPeriodo(\Core\Planeacion\AdminBundle\Entity\HoraPeriodo $horaPeriodo)
    {
        $this->horaPeriodo[] = $horaPeriodo;
    
        return $this;
    }

    /**
     * Remove horaPeriodo
     *
     * @param \Core\Planeacion\AdminBundle\Entity\HoraPeriodo $horaPeriodo
     */
    public function removeHoraPeriodo(\Core\Planeacion\AdminBundle\Entity\HoraPeriodo $horaPeriodo)
    {
        $this->horaPeriodo->removeElement($horaPeriodo);
    }

    /**
     * Get horaPeriodo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHoraPeriodo()
    {
        return $this->horaPeriodo;
    }

    /**
     * Add dia
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Dia $dia
     * @return Hora
     */
    public function addDia(\Core\Planeacion\AdminBundle\Entity\Dia $dia)
    {
        $this->dia[] = $dia;
    
        return $this;
    }

    /**
     * Remove dia
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Dia $dia
     */
    public function removeDia(\Core\Planeacion\AdminBundle\Entity\Dia $dia)
    {
        $this->dia->removeElement($dia);
    }

    /**
     * Get dia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDia()
    {
        return $this->dia;
    }
}