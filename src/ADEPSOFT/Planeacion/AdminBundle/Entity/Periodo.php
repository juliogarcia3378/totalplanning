<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Periodo
 *
 * @ORM\Table(name="periodo")
 * @ORM\HasLifecycleCallbacks()
 * @DocAssert\UniqueEntity(fields={"anno","tipoPeriodo"}, message="Ya existe ese período en ese año.")
 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\PeriodoRepository")
 */
class Periodo
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="periodo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="anno", type="integer",  nullable=true)
     */
    private $anno;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @var \ProfePeriodo
     *
     * @ORM\OneToMany(targetEntity="ProfePeriodo",mappedBy="periodo")
     */
    private $profePeriodo;

    /**
     * @var \DescargaAdministrativa
     *
     * @ORM\OneToMany(targetEntity="DescargaAdministrativa",mappedBy="periodo")
     */
    private $descarga;
    /**
     * @var \TipoPeriodo
     *
     * @ORM\ManyToOne(targetEntity="TipoPeriodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_periodo", referencedColumnName="id")
     * })
     */
    private $tipoPeriodo;

    /**
     * @var \ProfePeriodoHorario
     *
     * @ORM\OneToOne(targetEntity="ADEPSOFT\Planeacion\AdminBundle\Entity\Anteproyecto",mappedBy="periodo")
     */
    private $anteproyecto;


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function events()
    {
        $this->nombre =  $this->getTipoPeriodo()->getNombre().'/'.$this->getAnno();
    }
    public function getAbreviado()
    {
        return $this->getTipoPeriodo()->getId().'/'.$this->getAnno();
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
     * Set anno
     *
     * @param string $anno
     * @return Periodo
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;
    
        return $this;
    }

    /**
     * Get anno
     *
     * @return string 
     */
    public function getAnno()
    {
        return $this->anno;
    }
    /**
     * Set tipoPeriodo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\TipoPeriodo $tipoPeriodo
     * @return Periodo
     */
    public function setTipoPeriodo(\ADEPSOFT\Planeacion\AdminBundle\Entity\TipoPeriodo $tipoPeriodo = null)
    {
        $this->tipoPeriodo = $tipoPeriodo;
    
        return $this;
    }

    /**
     * Get tipoPeriodo
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\TipoPeriodo 
     */
    public function getTipoPeriodo()
    {
        return $this->tipoPeriodo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Periodo
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
     * Constructor
     */
    public function __construct()
    {
      //  $em = new EntityManager();

        $this->profePeriodo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->descarga = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add profePeriodo
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo $profePeriodo
     * @return Periodo
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
        return $this->getAbreviado();
    }
}