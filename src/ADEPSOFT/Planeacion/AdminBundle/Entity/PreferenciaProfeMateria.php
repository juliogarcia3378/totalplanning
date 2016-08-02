<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PreferenciaProfeMateria
 *
 * @ORM\Table(name="preferencia_profe_materia")
 * @ORM\Entity(repositoryClass="ADEPSOFT\ComunBundle\Util\NomencladoresRepository")
 */
class PreferenciaProfeMateria
{
    /**
     * @var float
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="preferencia_profe_materia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden_preferencia", type="integer", nullable=true)
     */
    private $ordenPreferencia;

    /**
     * @var \Materia
     *
     * @ORM\ManyToOne(targetEntity="Materia",inversedBy="preferenciaProfeMateria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="materia", referencedColumnName="id")
     * })
     */
    private $materia;

    /**
     * @var \Profesor
     *
     * @ORM\ManyToOne(targetEntity="Profesor", inversedBy="preferenciaMateria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profe", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $profe;


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
     * Set ordenPreferencia
     *
     * @param integer $ordenPreferencia
     * @return PreferenciaProfeMateria
     */
    public function setOrdenPreferencia($ordenPreferencia)
    {
        $this->ordenPreferencia = $ordenPreferencia;
    
        return $this;
    }

    /**
     * Get ordenPreferencia
     *
     * @return integer 
     */
    public function getOrdenPreferencia()
    {
        return $this->ordenPreferencia;
    }

    /**
     * Set materia
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materia
     * @return PreferenciaProfeMateria
     */
    public function setMateria(\ADEPSOFT\Planeacion\AdminBundle\Entity\Materia $materia = null)
    {
        $this->materia = $materia;
    
        return $this;
    }

    /**
     * Get materia
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Materia 
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * Set profe
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor $profe
     * @return PreferenciaProfeMateria
     */
    public function setProfe(\ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor $profe = null)
    {
        $this->profe = $profe;
    
        return $this;
    }

    /**
     * Get profe
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor 
     */
    public function getProfe()
    {
        return $this->profe;
    }
}