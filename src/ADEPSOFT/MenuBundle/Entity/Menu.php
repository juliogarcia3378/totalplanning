<?php

namespace ADEPSOFT\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="ADEPSOFT\MenuBundle\Entity\MenuRepository")
 */
class Menu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="menu.menu_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="denominacion", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Campo obligatorio")
     */
    private $denominacion;
    /**
     * @var string
     *
     * @ORM\Column(name="permiso", type="string", length=50, nullable=true)
     */
    private $permiso;
    /**
     * @var string
     *
     * @ORM\Column(name="ruta", type="string", length=50, nullable=true)
     */
    private $ruta;

     /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=50, nullable=true)
     */
    private $icon;
    
    /**
     * @var \Menu
     *
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="hijos",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_padre", referencedColumnName="id")
     * })
     */
    private $padre;

    /**
     * @var \Menu
     *
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="padre",cascade={"persist","remove"})
     * })
     */
    private $hijos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hijos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->permiso = "IS_AUTHENTICATED_ANONYMOUSLY";
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
     * Set denominacion
     *
     * @param string $denominacion
     * @return Menu
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
     * Set padre
     *
     * @param \ADEPSOFT\MenuBundle\Entity\Menu $padre
     * @return Menu
     */
    public function setPadre(\ADEPSOFT\MenuBundle\Entity\Menu $padre = null)
    {
        $this->padre = $padre;
    
        return $this;
    }

    /**
     * Get padre
     *
     * @return \ADEPSOFT\MenuBundle\Entity\Menu 
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Add hijos
     *
     * @param \ADEPSOFT\MenuBundle\Entity\Menu $hijos
     * @return Menu
     */
    public function addHijo(\ADEPSOFT\MenuBundle\Entity\Menu $hijos)
    {
        $this->hijos[] = $hijos;
    
        return $this;
    }

    /**
     * Remove hijos
     *
     * @param \ADEPSOFT\MenuBundle\Entity\Menu $hijos
     */
    public function removeHijo(\ADEPSOFT\MenuBundle\Entity\Menu $hijos)
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
     * Set ruta
     *
     * @param string $ruta
     * @return Menu
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;
    
        return $this;
    }

    /**
     * Get ruta
     *
     * @return string 
     */
    public function getRuta()
    {
        return $this->ruta;
    }
    
    
        /**
     * Set ruta
     *
     * @param string $ruta
     * @return Menu
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    
        return $this;
    }

    /**
     * Get ruta
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set permiso
     *
     * @param string $permiso
     * @return Menu
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
}