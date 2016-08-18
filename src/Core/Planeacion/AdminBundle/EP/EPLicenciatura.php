<?php
namespace Core\Planeacion\AdminBundle\EP;

use Core\Planeacion\AdminBundle\Entity\Licenciatura;
use Doctrine\ORM\Mapping as ORM;

class EPLicenciatura
{
    /**
     * @var Licenciatura
     */
    public $licenciatura;
    public $planEstudio;

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

    public function getPlanEstudio()
    {
        return $this->planEstudio;
    }

    public function setPlanEstudio($planEstudio)
    {
        $this->planEstudio = $planEstudio;
    }
}