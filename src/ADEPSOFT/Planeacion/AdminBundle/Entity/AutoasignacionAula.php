<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="autoasignacion_aula")
 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\AutoasignacionAulaRepository")
 */
class AutoasignacionAula
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="autoasignacion_aula_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    /**
     * @var text
     *
     * @ORM\Column(name="comentario", type="text", nullable=true)
     */
    private $comentario;

    /**
     * @var \Aula
     *
     * @ORM\ManyToOne(targetEntity="Aula")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aula", referencedColumnName="id",nullable=false)
     * })
     */
    private $aula;

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
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @return \Aula
     */
    public function getAula()
    {
        return $this->aula;
    }

    /**
     * @param \Aula $aula
     */
    public function setAula($aula)
    {
        $this->aula = $aula;
    }

    /**
     * @return text
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param text $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \Materia
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * @param \Materia $materia
     */
    public function setMateria($materia)
    {
        $this->materia = $materia;
    }

    public function getNombre()
    {
        return $this->getAula()->getNombre();
    }
}