<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Aula
 *
 * @ORM\Table(name="aula")
 * @DocAssert\UniqueEntity(fields={"nombre"}, message="Ya existe un aula con ese nombre.")
 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\AulaRepository")

 */
class Aula
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="aula_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=10, nullable=false, unique=true)
     */
    private $nombre;
    /**
     * @var string
     *
     * @ORM\Column(name="capacidad", type="integer", nullable=true)
     */
    private $capacidad;

    /**
     * @var string
     *
     * @ORM\Column(name="activa", type="boolean", nullable=true, options={"defaults"=1})
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="enlinea", type="boolean", nullable=true, options={"defaults"=0})
     */
    private $enlinea;

    /**
     * @var \GrupoEstudiantes
     *
     * @ORM\OneToMany(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes",mappedBy="aula")
     */
    private $grupo;

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
     *
     * @ORM\OneToMany(targetEntity="ProfePeriodoHorario", mappedBy="aula")
     */
    private $profePeriodoHorario;

    /**
     * Set capacidad
     *
     * @param integer $capacidad
     * @return Aula
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;
    
        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer 
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set activa
     *
     * @param boolean $activa
     * @return Aula
     */
    public function setActivo($activa)
    {
        $this->activo = $activa;
    
        return $this;
    }

    /**
     * Get activa
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set activa
     *
     * @param boolean $enlinea
     * @return Aula
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
     * Get enlinea
     *
     * @return String
     */
    public function getDistancia()
    {
        if ($this->enlinea) {
            return "Sí";
        } else {
            return "No";
        }
    }

    /**
     * Get activo
     *
     * @return String
     */
    public function getDisponible()
    {
        if ($this->activo) {
            return "Sí";
        } else {
            return "No";
        }
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grupo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profePeriodoHorario = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add grupo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $grupo
     * @return Aula
     */
    public function addGrupo(\ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $grupo)
    {
        $this->grupo[] = $grupo;

        return $this;
    }

    /**
     * Remove grupo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $grupo
     */
    public function removeGrupo(\ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes $grupo)
    {
        $this->grupo->removeElement($grupo);
    }

    /**
     * Get grupo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
    /**
     * Add grupo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $grupo
     * @return Aula
     */
    public function addProfePeriodoHorario(\ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $grupo)
    {
        $this->profePeriodoHorario[] = $grupo;

        return $this;
    }

    /**
     * Remove grupo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $grupo
     */
    public function removeProfePeriodoHorario(\ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario $profe)
    {
        $this->profePeriodoHorario->removeElement($profe);
    }

    /**
     * Get grupo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfePeriodoHorario()
    {
        return $this->profePeriodoHorario;
    }
}