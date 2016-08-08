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
     * @var float
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
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=50, nullable=true)
     */
    private $apellidos;
    
    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=50, nullable=true)
     */
    private $fullname;
    


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_actualizacion", type="date", nullable=true)
     */
    private $fechaActualizacion;

   

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="text", nullable=true)
     */
    private $foto;

    /**
     * @var boolean
     *
     * @ORM\Column(name="inactivo", type="boolean", nullable=true)
     */
    private $inactivo;


 
    /**
     * @var \Carrera
     *
     * @ORM\ManyToOne(targetEntity="Carrera")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="carrera", referencedColumnName="id")
     * })
     */
    private $carrera;

   

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
     * @ORM\Column(name="domicilio", type="string", length=250, nullable=true)
     */
    private $domicilio;


    
   
    /**
     * @var \ADEPSOFT\MySecurityBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="ADEPSOFT\MySecurityBundle\Entity\Usuario", inversedBy="estudiante",cascade={"persist","remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id",onDelete="SET NULL")
     * })
     */
    private $usuario;
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preEvents()
    {
        if(substr($this->foto,0,4) =='http')
            $this->foto=null;
        $this->setFechaActualizacion(new \DateTime());
    }
   
    public function getGeneroString()
    {
        $a = array(EGenero::Femenino=>"Femenino",EGenero::Masculino=>"Masculino");
//        ld($this->getGenero());
        return $a[$this->getGenero()];
    }
   
 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setFechaActualizacion(new \DateTime());
       
    }
    
    public function fechaNacimientoString(){
        if($this->fechaNacimiento != null)
            return $this->fechaNacimiento->format("d-m-Y");
        return '';
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
     * Set nombres
     *
     * @param string $nombre
     * @return Persona
     */
    public function setNombres($nombre)
    {
        $this->nombres = mb_convert_case($nombre, MB_CASE_TITLE, 'UTF-8');

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Persona
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = mb_convert_case($apellidos, MB_CASE_TITLE, 'UTF-8');
    
        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }
    
    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->apellidos." ".$this->nombres;
    }
    
    /**
     * Get fullname
     *
     * @return string 
     */
    public function getFullName()
    {
        return $this->fullname;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function events()
    {
        $this->fullname = $this->nombres.' '.$this->apellidos;
    }
    
   
    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Persona
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    
        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    
    /**
     * Set foto
     *
     * @param string $foto
     * @return Persona
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string 
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFotoPic()
    {
        $pic = $this->foto;
        if ($pic != null) {
            return "<img src='".$pic."'>";
        }
        else {
            return $pic;
        }
    }

    
    /**
     * Set correo
     *
     * @param string $correo
     * @return Persona
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    
        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Persona
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    
        return $this;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    

    /**
     * Set domicilio
     *
     * @param string $domicilio
     * @return Persona
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    
        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string 
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set telParticular
     *
     * @param string $telParticular
     * @return Persona
     */
    public function setTelParticular($telParticular)
    {
        $this->telParticular = $telParticular;
    
        return $this;
    }

    /**
     * Get telParticular
     *
     * @return string 
     */
    public function getTelParticular()
    {
        return $this->telParticular;
    }

   

    /**
     * Set telCelular
     *
     * @param string $telCelular
     * @return Persona
     */
    public function setTelCelular($telCelular)
    {
        $this->telCelular = $telCelular;
    
        return $this;
    }

    /**
     * Get telCelular
     *
     * @return string 
     */
    public function getTelCelular()
    {
        return $this->telCelular;
    }

  
   

    /**
     * Get carrera
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Carrera
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * Set carrera
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Carrera $carrera
     * @return Persona
     */
    public function setCarrera(\ADEPSOFT\Planeacion\AdminBundle\Entity\Carrera $carrera = null)
    {
        $this->carrera = $carrera;

        return $this;
    }

   
    /**
     * Set perfil
     *
     * @param string $perfil
     * @return Persona
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    
        return $this;
    }

    /**
     * Get perfil
     *
     * @return string 
     */
    public function getPerfil()
    {
        return $this->perfil;
    }


    /**
     * Set genero
     *
     * @param integer $genero
     * @return Persona
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    
        return $this;
    }

    /**
     * Get genero
     *
     * @return integer 
     */
    public function getGenero()
    {
        return $this->genero;
    }

    
    /**
     * Set usuario
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Usuario $usuario
     * @return Persona
     */
    public function setUsuario(\ADEPSOFT\MySecurityBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return \ADEPSOFT\MySecurityBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }


    public function __toString(){
        return $this->getNombre();
    }
}