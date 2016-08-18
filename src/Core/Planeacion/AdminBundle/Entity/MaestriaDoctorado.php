<?php
namespace Core\Planeacion\AdminBundle\Entity;

use Core\Planeacion\AdminBundle\Enums\ETipoMaestriaDoctorado;
use Doctrine\ORM\Mapping as ORM;

/**
 * MaestriaDoctorado
 *
 * @ORM\Table(name="maestria_doctorado")
 * @ORM\Entity(repositoryClass="Core\ComunBundle\Util\NomencladoresRepository")
 */
class MaestriaDoctorado
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="maestria_doctorado_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pasante", type="boolean", nullable=true)
     */
    private $pasante;

    /**
     * @var boolean
     *
     * @ORM\Column(name="titulado", type="boolean", nullable=true)
     */
    private $titulado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=150, nullable=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer", nullable=false)
     */
    private $tipo;

    /**
     * @var \Profesor
     *
     * @ORM\ManyToOne(targetEntity="Profesor", inversedBy="gradoAcademico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profesor", referencedColumnName="id",onDelete="cascade")
     * })
     */
    private $profesor;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    public function getDetailArray()
    {
        $str = '';
        $key = '';
//        ld($this->getTipo());
        if($this->getTipo() == ETipoMaestriaDoctorado::Maestria)
            $key = "Maestría";
        else
            $key = "Doctorado";
        if($this->getPasante())
            $str.='Pasante en ';
        else
            $str.="Titulado en ";

        $str.=$this->getNombre();
        return array('key'=>$key,'value'=>$str);
    }
    /**
     * Set pasante
     *
     * @param boolean $pasante
     * @return MaestriaDoctorado
     */
    public function setPasante($pasante)
    {
        $this->pasante = $pasante;
    
        return $this;
    }

    /**
     * Get pasante
     *
     * @return boolean 
     */
    public function getPasante()
    {
        return $this->pasante;
    }

    /**
     * Set titulado
     *
     * @param boolean $titulado
     * @return MaestriaDoctorado
     */
    public function setTitulado($titulado)
    {
        $this->titulado = $titulado;
    
        return $this;
    }

    /**
     * Get titulado
     *
     * @return boolean 
     */
    public function getTitulado()
    {
        return $this->titulado;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return MaestriaDoctorado
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
     * Set tipo
     *
     * @param integer $tipo
     * @return MaestriaDoctorado
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set profesor
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Profesor $profesor
     * @return MaestriaDoctorado
     */
    public function setProfesor(\Core\Planeacion\AdminBundle\Entity\Profesor $profesor = null)
    {
        $this->profesor = $profesor;
    
        return $this;
    }

    /**
     * Get profesor
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }
}