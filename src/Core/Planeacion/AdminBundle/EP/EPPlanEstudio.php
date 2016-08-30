<?php
namespace Core\Planeacion\AdminBundle\EP;

use Core\Planeacion\AdminBundle\Entity\Carrera;
use Core\Planeacion\AdminBundle\Entity\Materia;
use Core\Planeacion\AdminBundle\Entity\PlanEstudio;
use Doctrine\ORM\Mapping as ORM;

class EPPlanEstudio
{
    /**
     * @var Carrera
     */
    protected $Carrera;
    /**
     * @var PlanEstudio
     */
    protected $plan;

    /**
     * @var Materia
     */
    public $materias;

    public $optativasSinSemestre;

    /**
     * @var Materia
     */
    public $materiasOpt;

    /**
     * @return Carrera
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * @param Carrera $carrera
     */
    public function setCarrera($carrera)
    {
        $this->carrera = $carrera;
    }


    /**
     * @return mixed
     */
    public function getOptativasSinSemestre()
    {
        return $this->optativasSinSemestre;
    }

    /**
     * @param mixed $optativasSinSemestre
     */
    public function setOptativasSinSemestre($optativasSinSemestre)
    {
        $this->optativasSinSemestre = $optativasSinSemestre;
    }


    /**
     * @return Materia
     */
    public function getMaterias()
    {
        return $this->materias;
    }

    /**
     * @param Materia $materias
     */
    public function setMaterias($materias)
    {
        $this->materias = $materias;
    }

    /**
     * @return Materia
     */
    public function getMateriasOpt()
    {
        return $this->materiasOpt;
    }

    /**
     * @param Materia $materiasOpt
     */
    public function setMateriasOpt($materiasOpt)
    {
        $this->materiasOpt = $materiasOpt;
    }

    /**
     * @return PlanEstudio
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param PlanEstudio $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }


}