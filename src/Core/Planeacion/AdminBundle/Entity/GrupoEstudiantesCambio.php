<?php
namespace Core\Planeacion\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DocAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dia
 *
 * @ORM\Table(name="grupo_estudiantes_cambio")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Core\Planeacion\AdminBundle\Repository\GrupoEstudiantesCambioRepository")
 */
class GrupoEstudiantesCambio
{
    /**
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="grupo_estudiante_cambio_id_seq", allocationSize=1, initialValue=20)
     */
    private $id;
    /**
     * @ORM\OneToOne(targetEntity="GrupoEstudiantes")
     * @ORM\JoinColumn(name="anterior", referencedColumnName="id",nullable=true)
     */
    protected $grupoAnterior;


    /**
     * @ORM\OneToOne(targetEntity="GrupoEstudiantes")
     * @ORM\JoinColumn(name="actual", referencedColumnName="id")
     */
    private $grupoActual;

    /**
     * @var \Anteproyecto
     *
     * @ORM\ManyToOne(targetEntity="Anteproyecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="anteproyecto", referencedColumnName="id", nullable=false)
     * })
     */
    private $anteproyecto;

    public function getId(){
        return $this->id;
    }
    public function setActual($actual){
        $this->grupoActual=$actual;
    }
    public function setAnterior($anterior = null){
        $this->grupoAnterior=$anterior;
    }

    public function getActual(){
        return $this->grupoActual;
    }
    public function getAnterior(){
        return $this->grupoAnterior;
    }


    public function setAnteproyecto(\Core\Planeacion\AdminBundle\Entity\Anteproyecto $periodo = null)
    {
        $this->anteproyecto = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return \Core\Planeacion\AdminBundle\Entity\Anteproyecto
     */
    public function getAnteproyecto()
    {
        return $this->anteproyecto;
    }

}
