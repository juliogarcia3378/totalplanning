<?php

namespace ADEPSOFT\MySecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;

/**
 *
 * @ORM\Table(name="permiso")
 * @DocAssert\UniqueEntity(fields={"denominacion"}, message="Esta denominación ya se encuentra en uso.")
 * @DocAssert\UniqueEntity(fields={"permiso"}, message="Este permiso ya se encuentra en uso.")
 * @ORM\Entity(repositoryClass="ADEPSOFT\MySecurityBundle\Repository\PermissionRepository")
 */
class Permission
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="permiso_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="denominacion", type="string", length=50, nullable=false)
     */
    private $denominacion;
    /**
     * @var string
     *
     * @ORM\Column(name="permiso", type="string", length=50, nullable=false)
     */
    private $permiso;

    /**
     * @var string
     *
     * @ORM\Column(name="activo", type="boolean", length=50, nullable=true)
     */
    private $activo;
    /**
     * @var Permission
     *
     * @ORM\ManyToOne(targetEntity="Permission", inversedBy="hijos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="padre", referencedColumnName="id")
     * })
     */
    private $padre;

    /**
     *
     * @ORM\OneToMany(targetEntity="Permission",mappedBy="padre",cascade={"persist","remove"})
     */
    private $hijos;
    /**
     *
     * @ORM\ManyToMany(targetEntity="Grupo",mappedBy="permisos")
     */
    private $grupos;
    /**
     *
     * @ORM\ManyToMany(targetEntity="Usuario",mappedBy="permisos")
     */
    private $usuarios;
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
     * Set denominacion
     *
     * @param string $denominacion
     * @return Permiso
     */
    public function setDenominacion($denominacion)
    {
        $this->denominacion = $denominacion;
    
        return $this;
    }

    /**
     * Get denominacion
     *
     * @return string 
     */
    public function getDenominacion()
    {
        return $this->denominacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Permiso
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hijos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->activo=true;
    }
    
    /**
     * Set permission
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Permission $permission
     * @return Permission
     */
    public function setPermission(\ADEPSOFT\MySecurityBundle\Entity\Permission $permission = null)
    {
        $this->permission = $permission;
    
        return $this;
    }

    /**
     * Get permission
     *
     * @return \ADEPSOFT\MySecurityBundle\Entity\Permission 
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Add hijos
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Permission $hijos
     * @return Permission
     */
    public function addHijo(\ADEPSOFT\MySecurityBundle\Entity\Permission $hijos)
    {
        $this->hijos[] = $hijos;
    
        return $this;
    }

    /**
     * Remove hijos
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Permission $hijos
     */
    public function removeHijo(\ADEPSOFT\MySecurityBundle\Entity\Permission $hijos)
    {
        $this->hijos->removeElement($hijos);
    }

    /**
     * Get hijos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHijos()
    {
        return $this->hijos;
    }

    /**
     * Set permiso
     *
     * @param string $permiso
     * @return Permission
     */
    public function setPermiso($permiso)
    {
        $this->permiso = $permiso;
    
        return $this;
    }

    /**
     * Get permiso
     *
     * @return string 
     */
    public function getPermiso()
    {
        return $this->permiso;
    }

    /**
     * Set padre
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Permission $padre
     * @return Permission
     */
    public function setPadre(\ADEPSOFT\MySecurityBundle\Entity\Permission $padre = null)
    {
        $this->padre = $padre;
    
        return $this;
    }

    /**
     * Get padre
     *
     * @return \ADEPSOFT\MySecurityBundle\Entity\Permission 
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Add grupos
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Grupo $grupos
     * @return Permission
     */
    public function addGrupo(\ADEPSOFT\MySecurityBundle\Entity\Grupo $grupos)
    {
        $this->grupos[] = $grupos;
    
        return $this;
    }

    /**
     * Remove grupos
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Grupo $grupos
     */
    public function removeGrupo(\ADEPSOFT\MySecurityBundle\Entity\Grupo $grupos)
    {
        $this->grupos->removeElement($grupos);
    }

    /**
     * Get grupos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * Add usuarios
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Grupo $usuarios
     * @return Permission
     */
    public function addUsuario(\ADEPSOFT\MySecurityBundle\Entity\Grupo $usuarios)
    {
        $this->usuarios[] = $usuarios;
    
        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \ADEPSOFT\MySecurityBundle\Entity\Grupo $usuarios
     */
    public function removeUsuario(\ADEPSOFT\MySecurityBundle\Entity\Grupo $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
}