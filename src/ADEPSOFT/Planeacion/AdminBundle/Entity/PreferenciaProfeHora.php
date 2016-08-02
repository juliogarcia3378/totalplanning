<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PreferenciaProfeHora
 *
 * @ORM\Table(name="preferencia_profe_hora")
 * @ORM\Entity(repositoryClass="ADEPSOFT\Planeacion\AdminBundle\Repository\PreferenciaProfeHoraRepository")
 */
class PreferenciaProfeHora
{
    /**
     * @var float
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="preferencia_profe_hora_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden_preferencia", type="integer", nullable=true)
     */
    private $ordenPreferencia;

    /**
     * @var \Profesor
     *
     * @ORM\ManyToOne(targetEntity="Profesor", inversedBy="preferenciaHora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profe", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $profe;

    /**
     * @var \Hora
     *
     * @ORM\ManyToOne(targetEntity="Hora",inversedBy="preferenciaProfehora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hora", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $hora;
    /**
     * @var \Dia
     *
     * @ORM\ManyToOne(targetEntity="Dia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dia", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $dia;


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
     * @return PreferenciaProfeHora
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
     * Set profe
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor $profe
     * @return PreferenciaProfeHora
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

    /**
     * Set hora
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Hora $hora
     * @return PreferenciaProfeHora
     */
    public function setHora(\ADEPSOFT\Planeacion\AdminBundle\Entity\Hora $hora = null)
    {
        $this->hora = $hora;
    
        return $this;
    }

    /**
     * Get hora
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Hora 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set dia
     *
     * @param \ADEPSOFT\Planeacion\AdminBundle\Entity\Dia $dia
     * @return PreferenciaProfeHora
     */
    public function setDia(\ADEPSOFT\Planeacion\AdminBundle\Entity\Dia $dia = null)
    {
        $this->dia = $dia;
    
        return $this;
    }

    /**
     * Get dia
     *
     * @return \ADEPSOFT\Planeacion\AdminBundle\Entity\Dia 
     */
    public function getDia()
    {
        return $this->dia;
    }
}