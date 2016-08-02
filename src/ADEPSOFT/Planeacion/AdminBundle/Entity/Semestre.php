<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Semestre
 *
 * @ORM\Table(name="semestre")
 * @ORM\Entity(repositoryClass="ADEPSOFT\ComunBundle\Util\NomencladoresRepository")
 */
class Semestre
{
    /**
     * @var float
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="semestre_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;
    /**
     * @var string
     *
     * @ORM\Column(name="ordinal", type="string", length=50, nullable=false)
     */
    private $ordinal;
    public function __toString(){
        return $this->getNombre();
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
     * @return Semestre
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
     * Get nombre
     *
     * @return string
     */
    public function getNombre2Digitos()
    {
        if($this->nombre != "10")
            return "0".$this->nombre;
        return $this->nombre;
    }
    /**
     * Set ordinal
     *
     * @param string $ordinal
     * @return Semestre
     */
    public function setOrdinal($ordinal)
    {
        $this->ordinal = $ordinal;
    
        return $this;
    }

    /**
     * Get ordinal
     *
     * @return string 
     */
    public function getOrdinal()
    {
        return $this->ordinal;
    }
}