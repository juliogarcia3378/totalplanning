<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;
use ADEPSOFT\ComunBundle\Util\FechaUtil;
use ADEPSOFT\Planeacion\AdminBundle\Enums\EGenero;
use ADEPSOFT\Planeacion\AdminBundle\Enums\EPerfilAcademico;
use ADEPSOFT\Planeacion\AdminBundle\Enums\ETipoMaestriaDoctorado;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Profesor
 *
 * @ORM\Table(name="profesor")
 * @ORM\HasLifecycleCallbacks()
 * @DocAssert\UniqueEntity(fields={"numeroEmpleado"}, message="Ya existe un profesor con ese número de empleado.")
 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\ProfesorRepository")
 */
class Profesor
{
    /**
     * @var float
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="profesor_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_lugar_labora", type="string", length=250, nullable=true)
     */
    private $telLugarLabora;

    /**
     * @var string
     *
     * @ORM\Column(name="dir_labora", type="string", length=250, nullable=true)
     */
    private $dirLabora;
    /**
     * @var boolean
     *
     * @ORM\Column(name="genero", type="integer", nullable=false)
     */
    private $genero;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_conyugue", type="string", length=250, nullable=true)
     */
    private $nombreConyugue;

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
     * @var string
     *
     * @ORM\Column(name="numero_empleado", type="string", nullable=true)
     */
    private $numeroEmpleado;

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
     * @var \DateTime
     *
     * @ORM\Column(name="fehca_ingreso_fac", type="date", nullable=true)
     */
    private $fechaIngresoFac;

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
     * @var \PerfilAcademico
     *
     * @ORM\ManyToOne(targetEntity="PerfilAcademico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="carrera", referencedColumnName="id")
     * })
     */
    private $carrera;

    /**
     * @var boolean
     *
     * @ORM\Column(name="linares", type="boolean", nullable=true)
     */
    private $linares;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sabina", type="boolean", nullable=true)
     */
    private $sabina;

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
     * @ORM\Column(name="lugar_labora", type="string", length=250, nullable=true)
     */
    private $lugarLabora;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso_uanl", type="date", nullable=true)
     */
    private $fechaIngresoUanl;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=250, nullable=true)
     */
    private $domicilio;
    /**
     * @var string
     *
     * @ORM\Column(name="perfil", type="text", nullable=true)
     * * @Assert\Length(
     *      max = 2500,
     *      maxMessage = "Inserte hasta {{ limit }} caracteres"
     * )
     */
    private $perfil;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_particular", type="string", length=50, nullable=true)
     */
    private $telParticular;

   
    /**
     * @var string
     *
     * @ORM\Column(name="tel_celular", type="string", length=50, nullable=true)
     */
    private $telCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_nextel", type="string", length=50, nullable=true)
     */
    private $telNextel;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria", referencedColumnName="id")
     * })
     */
    private $categoria;

    /**
     *
     * @ORM\OneToMany(targetEntity="MaestriaDoctorado", mappedBy="profesor", cascade={"persist","remove"})
     */
    private $gradoAcademico;

    /**
     * @var \EstadoCivil
     *
     * @ORM\ManyToOne(targetEntity="EstadoCivil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_civil", referencedColumnName="id")
     * })
     */
    private $estadoCivil;

    /**
     * @var \ProfePeriodo
     *
     * @ORM\OneToMany(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo", mappedBy="profesor", cascade={"persist","remove"})
     */
    private $profePeriodo;

    /**
     * @var \DescargaAdministrativa
     *
     * @ORM\OneToMany(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\DescargaAdministrativa", mappedBy="profesor", cascade={"persist","remove"})
     */
    private $descarga;
    /**
     * @var \IdiomaProfe
     *
     * @ORM\OneToMany(targetEntity="IdiomaProfe", mappedBy="profesor", cascade={"persist","remove"})
     */
    private $idiomaProfe;
    /**
     * @var \PreferenciaProfeMateria
     *
     * @ORM\OneToMany(targetEntity="PreferenciaProfeMateria", mappedBy="profe", cascade={"persist","remove"})
     */
    private $preferenciaMateria;
    /**
     * @var \PreferenciaProfeHora
     *
     * @ORM\OneToMany(targetEntity="PreferenciaProfeHora", mappedBy="profe", cascade={"persist","remove"})
     */
    private $preferenciaHora;
    /**
     * @var \ADEPSOFT\MySecurityBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="ADEPSOFT\MySecurityBundle\Entity\Usuario", inversedBy="profesor",cascade={"persist","remove"})
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
    public function getMaestria(){
        foreach($this->gradoAcademico as $grado)
        {
            /**
             * @var $grado MaestriaDoctorado
             */
            if($grado->getTipo() == ETipoMaestriaDoctorado::Maestria)
                return $grado;
        }
    }
    public function getDoctorado(){
        foreach($this->gradoAcademico as $grado)
        {
            /**
             * @var $grado MaestriaDoctorado
             */
            if($grado->getTipo() == ETipoMaestriaDoctorado::Doctorado)
                return $grado;
        }
    }
    public function getIdiomasString()
    {
        $str='';
        $c=0;
        foreach($this->getIdiomaProfe() as $idioma)
        {
            if($c++ != 0)
                $str.= ', '.$idioma->getString();
            else
                $str.= $idioma->getString();
        }
        return $str;
    }
    public function getGeneroString()
    {
        $a = array(EGenero::Femenino=>"Femenino",EGenero::Masculino=>"Masculino");
//        ld($this->getGenero());
        return $a[$this->getGenero()];
    }
    public function getTipoDescarga()
    {
        return 1;
    }

    public function getLiceImparteString()
    {
        return $this->carrera->getNombre();
    }

    public function  getHorasPreferidasArray()
    {
        $o1= array();
        $o2=array();
        foreach($this->getPreferenciaHora() as $prefHora)
        {
            /**
             * @var $prefHora PreferenciaProfeHora
             */
            if($prefHora->getOrdenPreferencia() == 1)
                $o1[]=$prefHora->getHora()->getNombre();
            if($prefHora->getOrdenPreferencia() == 2)
                $o2[]=$prefHora->getHora()->getNombre();
        }
        return array('1'=>$o1,'2'=>$o2);
    }
    public function getCampusString()
    {
        $str ='';
        if($this->getLinares())
            $str.="Linares";
        if($this->getSabina())
            if($str != '')
                $str.=', Sabina';
            else
                $str.="Sabina";
        return $str;

    }
    public function getNombreNumEmpleado()
    {
        return $this->getNombre()."-".$this->getNumeroEmpleado();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setFechaActualizacion(new \DateTime());
        $this->gradoAcademico = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profePeriodo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->descarga = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idiomaProfe  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preferenciaMateria  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preferenciaHora  = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function fechaUanlString(){
        if($this->fechaIngresoUanl != null)
            return $this->fechaIngresoUanl->format("d-m-Y");
        return '';
    }
    public function fechaNacimientoString(){
        if($this->fechaNacimiento != null)
            return $this->fechaNacimiento->format("d-m-Y");
        return '';
    }
    public function fechaFACDYCString(){
        if($this->fechaIngresoFac != null)
         return $this->fechaIngresoFac->format("d-m-Y");
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
     * Set telLugarLabora
     *
     * @param string $telLugarLabora
     * @return Profesor
     */
    public function setTelLugarLabora($telLugarLabora)
    {
        $this->telLugarLabora = $telLugarLabora;
    
        return $this;
    }

    /**
     * Get telLugarLabora
     *
     * @return string 
     */
    public function getTelLugarLabora()
    {
        return $this->telLugarLabora;
    }

    /**
     * Set dirLabora
     *
     * @param string $dirLabora
     * @return Profesor
     */
    public function setDirLabora($dirLabora)
    {
        $this->dirLabora = $dirLabora;
    
        return $this;
    }

    /**
     * Get dirLabora
     *
     * @return string 
     */
    public function getDirLabora()
    {
        return $this->dirLabora;
    }

    /**
     * Set nombreConyugue
     *
     * @param string $nombreConyugue
     * @return Profesor
     */
    public function setNombreConyugue($nombreConyugue)
    {
        $this->nombreConyugue = mb_convert_case($nombreConyugue, MB_CASE_TITLE, 'UTF-8');
    
        return $this;
    }

    /**
     * Get nombreConyugue
     *
     * @return string 
     */
    public function getNombreConyugue()
    {
        return $this->nombreConyugue;
    }

    /**
     * Set nombres
     *
     * @param string $nombre
     * @return Profesor
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
     * @return Profesor
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
     * Set numeroEmpleado
     *
     * @param string $numeroEmpleado
     * @return Profesor
     */
    public function setNumeroEmpleado($numeroEmpleado)
    {
        $this->numeroEmpleado = $numeroEmpleado;
    
        return $this;
    }

    /**
     * Get numeroEmpleado
     *
     * @return string 
     */
    public function getNumeroEmpleado()
    {
        return $this->numeroEmpleado;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Profesor
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
     * Set fehcaIngresoFac
     *
     * @param \DateTime $fehcaIngresoFac
     * @return Profesor
     */
    public function setFechaIngresoFac($fehcaIngresoFac)
    {
        $this->fechaIngresoFac = $fehcaIngresoFac;
    
        return $this;
    }

    /**
     * Get fehcaIngresoFac
     *
     * @return \DateTime 
     */
    public function getFechaIngresoFac()
    {
        return $this->fechaIngresoFac;
    }

    /**
     * Set foto
     *
     * @param string $foto
     * @return Profesor
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
     * Set linares
     *
     * @param boolean $linares
     * @return Profesor
     */
    public function setLinares($linares)
    {
        $this->linares = $linares;
    
        return $this;
    }

    /**
     * Get linares
     *
     * @return boolean 
     */
    public function getLinares()
    {
        return $this->linares;
    }

    /**
     * Set sabina
     *
     * @param boolean $sabina
     * @return Profesor
     */
    public function setSabina($sabina)
    {
        $this->sabina = $sabina;
    
        return $this;
    }

    /**
     * Get sabina
     *
     * @return boolean 
     */
    public function getSabina()
    {
        return $this->sabina;
    }

    /**
     * Set inactivo
     *
     * @param boolean $inactivo
     * @return Profesor
     */
    public function setInactivo($inactivo)
    {
        $this->inactivo = $inactivo;

        return $this;
    }

    /**
     * Get inactivo
     *
     * @return boolean
     */
    public function getInactivo()
    {
        return $this->inactivo;
    }

    /**
     * Get inactivo
     *
     * @return String
     */
    public function getInactivoText()
    {
        if($this->inactivo) {
            return "Sí";
        }
        else {
            return "No";
        }
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Profesor
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
     * @return Profesor
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
     * Set lugarLabora
     *
     * @param string $lugarLabora
     * @return Profesor
     */
    public function setLugarLabora($lugarLabora)
    {
        $this->lugarLabora = $lugarLabora;
    
        return $this;
    }

    /**
     * Get lugarLabora
     *
     * @return string 
     */
    public function getLugarLabora()
    {
        return $this->lugarLabora;
    }

    /**
     * Set fechaIngresoUanl
     *
     * @param \DateTime $fechaIngresoUanl
     * @return Profesor
     */
    public function setFechaIngresoUanl($fechaIngresoUanl)
    {
        $this->fechaIngresoUanl = $fechaIngresoUanl;
    
        return $this;
    }

    /**
     * Get fechaIngresoUanl
     *
     * @return \DateTime 
     */
    public function getFechaIngresoUanl()
    {
        return $this->fechaIngresoUanl;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     * @return Profesor
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
     * @return Profesor
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
     * @return Profesor
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
     * Set telNextel
     *
     * @param string $telNextel
     * @return Profesor
     */
    public function setTelNextel($telNextel)
    {
        $this->telNextel = $telNextel;
    
        return $this;
    }

    /**
     * Get telNextel
     *
     * @return string 
     */
    public function getTelNextel()
    {
        return $this->telNextel;
    }

    /**
     * Set categoria
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Categoria $categoria
     * @return Profesor
     */
    public function setCategoria(\ADEPSOFT\Planeacion\AdminBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Categoria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Get carrera
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\PerfilAcademico
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * Set carrera
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\PerfilAcademico $carrera
     * @return Profesor
     */
    public function setCarrera(\ADEPSOFT\Planeacion\AdminBundle\Entity\PerfilAcademico $carrera = null)
    {
        $this->carrera = $carrera;

        return $this;
    }

    /**
     * Add gradoAcademico
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\MaestriaDoctorado $gradoAcademico
     * @return Profesor
     */
    public function addGradoAcademico(\ADEPSOFT\Planeacion\AdminBundle\Entity\MaestriaDoctorado $gradoAcademico)
    {
        $gradoAcademico->setProfesor($this);
        $this->gradoAcademico[] = $gradoAcademico;
    
        return $this;
    }

    /**
     * Remove gradoAcademico
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\MaestriaDoctorado $gradoAcademico
     */
    public function removeGradoAcademico(\ADEPSOFT\Planeacion\AdminBundle\Entity\MaestriaDoctorado $gradoAcademico)
    {
        $this->gradoAcademico->removeElement($gradoAcademico);
    }

    /**
     * Get gradoAcademico
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGradoAcademico()
    {
        return $this->gradoAcademico;
    }

    /**
     * Set estadoCivil
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\EstadoCivil $estadoCivil
     * @return Profesor
     */
    public function setEstadoCivil(\ADEPSOFT\Planeacion\AdminBundle\Entity\EstadoCivil $estadoCivil = null)
    {
        $this->estadoCivil = $estadoCivil;
    
        return $this;
    }

    /**
     * Get estadoCivil
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\EstadoCivil 
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }


    /**
     * Add idiomaProfe
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\IdiomaProfe $idiomaProfe
     * @return Profesor
     */
    public function addIdiomaProfe(\ADEPSOFT\Planeacion\AdminBundle\Entity\IdiomaProfe $idiomaProfe)
    {
        $idiomaProfe->setProfesor($this);
        $this->idiomaProfe[] = $idiomaProfe;
    
        return $this;
    }

    /**
     * Remove idiomaProfe
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\IdiomaProfe $idiomaProfe
     */
    public function removeIdiomaProfe(\ADEPSOFT\Planeacion\AdminBundle\Entity\IdiomaProfe $idiomaProfe)
    {
        $this->idiomaProfe->removeElement($idiomaProfe);
    }
    public function getIdioma1()
    {
        if(count($this->idiomaProfe) > 0)
            return $this->idiomaProfe[0];
        return null;
    }
    public function getIdioma2()
    {
        if(count($this->idiomaProfe) > 1)
            return $this->idiomaProfe[1];
        return null;
    }
    /**
     * Get idiomaProfe
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdiomaProfe()
    {
        return $this->idiomaProfe;
    }

    /**
     * Add preferenciaMateria
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\PreferenciaProfeMateria $preferenciaMateria
     * @return Profesor
     */
    public function addPreferenciaMateria(\ADEPSOFT\Planeacion\AdminBundle\Entity\PreferenciaProfeMateria $preferenciaMateria)
    {
        $preferenciaMateria->setProfe($this);
        $this->preferenciaMateria[] = $preferenciaMateria;
    
        return $this;
    }

    /**
     * Remove preferenciaMateria
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\PreferenciaProfeMateria $preferenciaMateria
     */
    public function removePreferenciaMateria(\ADEPSOFT\Planeacion\AdminBundle\Entity\PreferenciaProfeMateria $preferenciaMateria)
    {
        $this->preferenciaMateria->removeElement($preferenciaMateria);
    }

    /**
     * Get preferenciaMateria
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreferenciaMateria()
    {
        return $this->preferenciaMateria;
    }

    /**
     * Add preferenciaHora
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\PreferenciaProfeHora $preferenciaHora
     * @return Profesor
     */
    public function addPreferenciaHora(\ADEPSOFT\Planeacion\AdminBundle\Entity\PreferenciaProfeHora $preferenciaHora)
    {
        $preferenciaHora->setProfe($this);
        $this->preferenciaHora[] = $preferenciaHora;
    
        return $this;
    }

    /**
     * Remove preferenciaHora
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\PreferenciaProfeHora $preferenciaHora
     */
    public function removePreferenciaHora(\ADEPSOFT\Planeacion\AdminBundle\Entity\PreferenciaProfeHora $preferenciaHora)
    {
        $this->preferenciaHora->removeElement($preferenciaHora);
    }

    /**
     * Get preferenciaHora
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreferenciaHora()
    {
        return $this->preferenciaHora;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     * @return Profesor
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;
    
        return $this;
    }

    /**
     * Get fechaActualizacion
     *
     * @return \DateTime 
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }
    /**
     * Get fechaActualizacion
     *
     * @return \DateTime
     */
    public function getFechaActualizacionString()
    {
        return FechaUtil::toString($this->fechaActualizacion);
    }

    /**
     * Set perfil
     *
     * @param string $perfil
     * @return Profesor
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
     * @return Profesor
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
     * Get derecho
     *
     * @return boolean 
     */
    public function getDerecho()
    {
        return ($this->carrera && EPerfilAcademico::Derecho);
    }

    /**
     * Get criminologia
     *
     * @return boolean 
     */
    public function getCriminologia()
    {
        return ($this->carrera && EPerfilAcademico::Criminologia);
    }

    /**
     * Set usuario
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Usuario $usuario
     * @return Profesor
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

    /**
     * Add profePeriodo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodo
     * @return Profesor
     */
    public function addProfePeriodo(\ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodo)
    {
        $this->profePeriodo[] = $profePeriodo;
    
        return $this;
    }

    /**
     * Remove profePeriodo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodo
     */
    public function removeProfePeriodo(\ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodo)
    {
        $this->profePeriodo->removeElement($profePeriodo);
    }

    /**
     * Get profePeriodo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfePeriodo()
    {
        return $this->profePeriodo;
    }
    /**
     * Add descarga
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\DescargaAdministrativa $descarga
     * @return DescargaAdministrativa
     */
    public function addDescarga(\ADEPSOFT\Planeacion\AdminBundle\Entity\DescargaAdministrativa $descarga)
    {
        $this->descarga[] = $descarga;

        return $this;
    }

    /**
     * Remove Descarga
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\DescargaAdministrativa $descarga
     */
    public function removeDescarga(\ADEPSOFT\Planeacion\AdminBundle\Entity\DescargaAdministrativa $descarga)
    {
        $this->descarga->removeElement($descarga);
    }

    /**
     * Get descarga
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDescarga()
    {
        return $this->descarga;
    }

    public function __toString(){
        return $this->getNombre();
    }


}