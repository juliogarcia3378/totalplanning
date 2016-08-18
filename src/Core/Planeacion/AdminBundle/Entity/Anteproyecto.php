<?php
namespace Core\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="anteproyecto")
 * @ORM\Entity(repositoryClass="Core\Planeacion\AdminBundle\Repository\AnteproyectoRepository")
 */
class Anteproyecto
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="anteproyecto_id_seq", allocationSize=1, initialValue=15)
     */
    private $id;


    /**
     * @var \Peridio
     *
     * @ORM\OneToOne(targetEntity="Periodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="periodo", referencedColumnName="id",nullable=false)
     * })
     */
    private $periodo;

    /**
     * @var \Peridio
     *
     * @ORM\ManyToOne(targetEntity="Periodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="periodo_anterior", referencedColumnName="id",nullable=true)
     * })
     */
    private $periodo_anterior;

    /**
     * @var \Estado
     *
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado", referencedColumnName="id", nullable=false)
     * })
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="cambios", type="text", nullable=true, unique=false)
     */
    private $cambios;

    /**
     * Set periodo
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Periodo $periodo
     * @return ProfePeriodo
     */
    public function setPeriodo(\Core\Planeacion\AdminBundle\Entity\Periodo $periodo = null)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Periodo
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }/**
 * Set periodo
 *
 * @param \Core\Planeacion\AdminBundle\Entity\Periodo $periodo
 * @return ProfePeriodo
 */
    public function setPeriodoAnterior(\Core\Planeacion\AdminBundle\Entity\Periodo $periodo = null)
    {
        $this->periodo_anterior = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Periodo
     */
    public function getPeriodoAnterior()
    {
        return $this->periodo_anterior;
    }
    /**
     * Set periodo
     *
     * @param \Core\Planeacion\AdminBundle\Entity\Estado $periodo
     * @return ProfePeriodo
     */
    public function setEstado(\Core\Planeacion\AdminBundle\Entity\Estado $estado= null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cambios
     *
     * @param text $cambios
     * @return Anteproyecto
     */
    public function setCambios($cambios)
    {
        $this->cambios = $cambios;

        return $this;
    }

    /**
     * Get cambios
     *
     * @return text
     */
    public function getCambios()
    {
        return $this->cambios;
    }
}