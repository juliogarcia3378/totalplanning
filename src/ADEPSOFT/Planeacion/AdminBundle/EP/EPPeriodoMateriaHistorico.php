<?php
namespace ADEPSOFT\Planeacion\AdminBundle\EP;

use ADEPSOFT\Planeacion\AdminBundle\Entity\Periodo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class EPPeriodoMateriaHistorico
{
    /**
     * @var Periodo
     */
    protected $periodo;

    /**
     * @var EPMateriaHistorica
     */
    protected $materia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->materia=new ArrayCollection();
    }

    /**
     * @return Periodo
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @param Periodo $periodo
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }



    /**
     * @return EPMateriaHistorica
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * @param EPMateriaHistorica $materia
     */
    public function addMateria($materia)
    {
        $this->materia[] = $materia;
    }

}