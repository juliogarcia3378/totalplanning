<?php

namespace Core\MySecurityBundle\Entity;

use Core\ComunBundle\Util\Util;
use Core\MySecurityBundle\Enums\EGroup;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\HasLifecycleCallbacks()
 * @DocAssert\UniqueEntity(fields={"usernameCanonical"},errorPath="username", message="Ya existe un usuario con ese nombre de usuario.")
 * @DocAssert\UniqueEntity(fields={"emailCanonical"}, errorPath="email",message="Ya existe un usuario con ese correo electrónico.")
 * @ORM\Entity(repositoryClass="Core\MySecurityBundle\Repository\UsuarioRepository")
 */
class Usuario extends User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="usuario_id_seq", allocationSize=1, initialValue=1)
     */
    protected  $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=100, nullable=true)
     */
    private $token;
    /**
     * @var string
     *
     * @ORM\Column(name="canonic_name", type="string", length=50, nullable=true)
     */
    private $canonic_name;
    /**
     * @var string
     *
     * @ORM\Column(name="cedula", type="string", length=15, nullable=true)
     */
    private $cedula;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Permission", inversedBy="usuarios")
     * @ORM\JoinTable(name="usuario_permiso",
     *   joinColumns={
     *     @ORM\JoinColumn(name="usuario", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="permiso", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    private $permisos;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Grupo", inversedBy="usuarios")
     * @ORM\JoinTable(name="usuario_grupo",
     *   joinColumns={
     *     @ORM\JoinColumn(name="usuario", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="grupo", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    protected $groups;
    /**
     * @var \Core\Planeacion\AdminBundle\Entity\Profesor
     *
     * @ORM\OneToMany(targetEntity="Core\Planeacion\AdminBundle\Entity\Profesor",mappedBy="usuario")
     */
    private $profesor;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sessionid", type="string", nullable=true)
     */
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getGroupsId(){
        $grupos = $this->getGroups();
        $ids = array();
        foreach ($grupos as $group) {
            $ids[] = $group->getId();
        }

        return $ids;
    }
    public function onlyProfe()
    {
        $user = $this;
        if(in_array(EGroup::Profesor,$user->getGroupsId()) &&
            count($user->getGroupNames()) == 1)
            return true;
        return false;
    }
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function resetRoles()
    {
        $this->roles = array();
        $groupsRoles = $this->getRoles();
        foreach($this->getPermisos() as $permiso){
            if(!in_array($permiso->getPermiso(),$groupsRoles))
                $this->addRole($permiso->getPermiso());
        }
        if($this->getProfesor() == null)
        {
            if($this->getNombre() == null || $this->getEmail() == null )
                throw new Exception("Existen campos con valores o válidos.");
        }
        else
        {
            $this->setNombre($this->getProfesor()->getNombre());
            $this->setEmail($this->getProfesor()->getCorreo());
            $this->setCedula($this->getProfesor()->getNumeroEmpleado());
        }
    }

    /**
     * Returns the user roles
     *
     * @return array The roles
     */
    public function getRoles()
    {
        $roles = $this->roles;

        foreach ($this->getGroups() as $group) {
            $roles = array_merge($roles, $group->getRoles());
        }
//        ldd('paco');
        // we need to make sure to have at least one role
        $roles[] = 'IS_AUTHENTICATED_FULLY';

        return array_unique($roles);
    }
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
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
     * Set cedula
     *
     * @param string $cedula
     * @return Usuario
     */
    public function setToken($cedula)
    {
        $this->token = $cedula;
    
        return $this;
    }

    /**
     * Get cedula
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set cedula
     *
     * @param string $cedula
     * @return Usuario
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
    
        return $this;
    }

    /**
     * Get cedula
     *
     * @return string 
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set canonic_name
     *
     * @param string $canonicName
     * @return Usuario
     */
    public function setCanonicName($canonicName)
    {
        $this->canonic_name = $canonicName;
    
        return $this;
    }

    /**
     * Get canonic_name
     *
     * @return string 
     */
    public function getCanonicName()
    {
        return $this->canonic_name;
    }


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function canonicalization()
    {
        if($this->nombre != null && strlen($this->nombre) > 0)
            $this->canonic_name = Util::makeCanonic($this->nombre);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enabled=true;
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->locked = false;
        $this->expired = false;
        $this->roles = array();
        $this->credentialsExpired = false;

        $this->profesor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->permisos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add permisos
     *
     * @param \Core\MySecurityBundle\Entity\Permission $permisos
     * @return Usuario
     */
    public function addPermiso(\Core\MySecurityBundle\Entity\Permission $permisos)
    {
        $this->permisos[] = $permisos;
    
        return $this;
    }

    /**
     * Remove permisos
     *
     * @param \Core\MySecurityBundle\Entity\Permission $permisos
     */
    public function removePermiso(\Core\MySecurityBundle\Entity\Permission $permisos)
    {
        $this->permisos->removeElement($permisos);
    }

    /**
     * Get permisos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermisos()
    {
        return $this->permisos;
    }


    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }


    /**
     * Set profesor
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Profesor $profesor
     * @return Usuario
     */
    public function setProfesor(\Core\Planeacion\AdminBundle\Entity\Profesor $profesor = null)
    {
        $profesor->setUsuario($this);
        $this->profesor[0] = $profesor;
    
        return $this;
    }

    /**
     * Get profesor
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor[0];
    }
}
