<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PerfilAcademico
 *
 * @ORM\Table(name="perfilacademico")
 * @ORM\Entity(repositoryClass="ADEPSOFT\ComunBundle\Util\NomencladoresRepository")
 */
class PerfilAcademico
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="PerfilAcademico_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="perfil", type="string", length=50, nullable=false)
     */
    private $perfil;

  
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    public function __toString(){
        return $this->getPerfil();
    }
    /**
     * Set perfil
     *
     * @param string $perfil
     * @return PerfilAcademico
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
  


}