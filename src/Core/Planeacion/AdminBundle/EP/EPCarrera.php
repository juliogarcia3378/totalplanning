<?php
namespace Core\Planeacion\AdminBundle\EP;

use Core\Planeacion\AdminBundle\Entity\Carrera;
use Doctrine\ORM\Mapping as ORM;

class EPCarrera
{
    /**
     * @var Carrera
     */
    public $carrera;
    public $planEstudio;

    /**
     * @return Carrera
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * @param Carrera $Carrera
     */
    public function setCarrera($Carrera)
    {
        $this->carrera = $Carrera;
    }

    public function getPlanEstudio()
    {
        return $this->planEstudio;
    }

    public function setPlanEstudio($planEstudio)
    {
        $this->planEstudio = $planEstudio;
    }
}