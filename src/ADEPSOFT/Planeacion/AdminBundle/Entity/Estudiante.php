<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dia
 *
 * @ORM\Table(name="estudiante")
 * @ORM\HasLifecycleCallbacks()

 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\EstudianteRepository")
 */
class Estudiante
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="estudiante_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;


    /**
     * @var boolean
     *
     * @ORM\Column(name="genero", type="integer", nullable=false)
     */
    private $genero;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=50, nullable=false)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=50, nullable=true)
     */
    private $apellidos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;


    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="text", nullable=true)
     */
    private $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=250, nullable=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_celular", type="string", length=50, nullable=true)
     */
    private $telCelular;

    /**
     * @return boolean
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param boolean $genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

    /**
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * @param \DateTime $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    /**
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param string $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param string $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getTelCelular()
    {
        return $this->telCelular;
    }

    /**
     * @param string $telCelular
     */
    public function setTelCelular($telCelular)
    {
        $this->telCelular = $telCelular;
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

}
