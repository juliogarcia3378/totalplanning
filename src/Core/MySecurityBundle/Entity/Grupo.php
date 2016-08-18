<?php

namespace Core\MySecurityBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\Group;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rol
 *
 * @ORM\Table(name="security_grupo")
 * @ORM\HasLifecycleCallbacks()
 * @DocAssert\UniqueEntity(fields={"name"}, message="Ya existe un rol con ese nombre.")
 * @ORM\Entity(repositoryClass="Core\MySecurityBundle\Repository\GrupoRepository")
 */
class Grupo extends Group
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="security_grupo_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Permission", inversedBy="grupos")
     * @ORM\JoinTable(name="grupo_permiso",
     *   joinColumns={
     *     @ORM\JoinColumn(name="grupo", referencedColumnName="id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="permiso", referencedColumnName="id", onDelete="cascade")
     *   }
     * )
     */
    private $permisos;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="groups")
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

    public function getPermisionListString()
    {
        $string = '';
        $i=0;
        foreach($this->permiso as $permiso)
        {
            if($i == 0)
                $string.=$permiso->getDenominacion();
            else
                $string .= ", ".$permiso->getDenominacion();
            $i++;
        }
        return $string;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function resetRoles()
    {
        $this->roles = array();
        foreach($this->getPermisos() as $permiso){
            $this->addRole($permiso->getPermiso());
        }
    }

    /**
     * Add permiso
     *
     * @param \Core\MySecurityBundle\Entity\Permission $permiso
     * @return Grupo
     */
    public function addPermiso(\Core\MySecurityBundle\Entity\Permission $permiso)
    {
        $this->permisos[] = $permiso;
    
        return $this;
    }

    /**
     * Remove permiso
     *
     * @param \Core\MySecurityBundle\Entity\Permission $permiso
     */
    public function removePermiso(\Core\MySecurityBundle\Entity\Permission $permiso)
    {
        $this->permisos->removeElement($permiso);
    }

    /**
     * Get permiso
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermisos()
    {
        return $this->permisos;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permisos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add usuarios
     *
     * @param \Core\MySecurityBundle\Entity\Usuario $usuarios
     * @return Grupo
     */
    public function addUsuario(\Core\MySecurityBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;
    
        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \Core\MySecurityBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(\Core\MySecurityBundle\Entity\Usuario $usuarios)
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