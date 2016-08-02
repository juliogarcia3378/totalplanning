<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IdiomaProfe
 *
 * @ORM\Table(name="idioma_profe")
 * @ORM\Entity(repositoryClass="ADEPSOFT\ComunBundle\Util\NomencladoresRepository")
 */
class IdiomaProfe
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="idioma_profe_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="porciento", type="integer", nullable=true)
     */
    private $porciento;
    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero;

    /**
     * @var \Idioma
     *
     * @ORM\ManyToOne(targetEntity="Idioma")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idioma", referencedColumnName="id")
     * })
     */
    private $idioma;

    /**
     * @var \Profesor
     *
     * @ORM\ManyToOne(targetEntity="Profesor", inversedBy="idiomaProfe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profesor", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $profesor;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    public function getString()
    {
        $str = '';
        $str.=$this->getIdioma()->getNombre();
        if($this->getPorciento() != '' && $this->getPorciento() != 0)
            $str.=' al '.$this->getPorciento()."%";
        return $str;
    }

    /**
     * Set porciento
     *
     * @param integer $porciento
     * @return IdiomaProfe
     */
    public function setPorciento($porciento)
    {
        $this->porciento = $porciento;
    
        return $this;
    }

    /**
     * Get porciento
     *
     * @return integer 
     */
    public function getPorciento()
    {
        return $this->porciento;
    }

    /**
     * Set idioma
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Idioma $idioma
     * @return IdiomaProfe
     */
    public function setIdioma(\ADEPSOFT\Planeacion\AdminBundle\Entity\Idioma $idioma = null)
    {
        $this->idioma = $idioma;
    
        return $this;
    }

    /**
     * Get idioma
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Idioma 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Set profesor
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor $profesor
     * @return IdiomaProfe
     */
    public function setProfesor(\ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor $profesor = null)
    {
        $this->profesor = $profesor;
    
        return $this;
    }

    /**
     * Get profesor
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     * @return IdiomaProfe
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    
        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }
}