<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="descarga_administrativa")
 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\DescargaAdministrativaRepository")
 */
class DescargaAdministrativa
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="descarga_administrativa_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    /**
     * @var text
     *
     * @ORM\Column(name="comentario", type="text", nullable=true)
     */
    private $comentario;
    /**
     * @var \TipoDescargaAdministrativa
     *
     * @ORM\ManyToOne(targetEntity="TipoDescargaAdministrativa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoDescarga", referencedColumnName="id",nullable=true)
     * })
     */
    private $tipoDescarga;
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
     * @var \Profesor
     *
     * @ORM\ManyToOne(targetEntity="Profesor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profesor", referencedColumnName="id",nullable=false)
     * })
     */
    private $profesor;
    /**
     * @var \ProfePeriodoHorario
     *
     * @ORM\OneToMany(targetEntity="ProfePeriodoHorario",mappedBy="profePeriodo", cascade={"persist","remove"})
     */
    private $profePeriodoHorario;
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
     * Constructor
     */
    public function __construct()
    {
    }
    

    public function setTipoDescarga(\ADEPSOFT\Planeacion\AdminBundle\Entity\TipoDescargaAdministrativa $descarga= null)
    {
        $this->tipoDescarga = $descarga;

        return $this;
    }

    public function getComentario()
    {
        return $this->comentario;
    }
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getTipoDescarga()
    {
        return $this->tipoDescarga;
    }

    public function getNombre(){
        return $this->getProfesor()->getNombre();
    }
}