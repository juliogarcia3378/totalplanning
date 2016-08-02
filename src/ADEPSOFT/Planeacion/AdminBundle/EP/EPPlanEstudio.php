<?php
namespace ADEPSOFT\Planeacion\AdminBundle\EP;

use ADEPSOFT\Planeacion\AdminBundle\Entity\Licenciatura;
use ADEPSOFT\Planeacion\AdminBundle\Entity\Materia;
use ADEPSOFT\Planeacion\AdminBundle\Entity\PlanEstudio;
use Doctrine\ORM\Mapping as ORM;

class EPPlanEstudio
{
    /**
     * @var Licenciatura
     */
    protected $licenciatura;
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
     * @return Licenciatura
     */
    public function getLicenciatura()
    {
        return $this->licenciatura;
    }

    /**
     * @param Licenciatura $licenciatura
     */
    public function setLicenciatura($licenciatura)
    {
        $this->licenciatura = $licenciatura;
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