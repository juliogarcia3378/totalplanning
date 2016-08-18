<?php
namespace Core\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Turno
 *
 * @ORM\Table(name="turno")
 * @DocAssert\UniqueEntity(fields={"nombre"}, message="Ya existe un turno con ese nombre.")
 * @ORM\Entity(repositoryClass="Core\Planeacion\AdminBundle\Repository\TurnoRepository")
 */
class Turno
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="turno_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    public function __toString(){
        return $this->getNombre();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="activa", type="boolean", nullable=true, options={"defaults"=1})
     */
    private $activo;
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
     * @return Turno
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
     * Set activo
     *
     * @param boolean $activo
     * @return Turno
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
}