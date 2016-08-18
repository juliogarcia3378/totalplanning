<?php
namespace Core\Planeacion\AdminBundle\EP;

use Core\Planeacion\AdminBundle\Entity\Materia;
use Doctrine\ORM\Mapping as ORM;

class EPMateriaHistorica
{
    protected $borrable;

    /**
     * @var Materia
     */
    protected $materia;

    /**
     * @return mixed
     */
    public function getBorrable()
    {
        return $this->borrable;
    }

    /**
     * @param mixed $borrable
     */
    public function setBorrable($borrable)
    {
        $this->borrable = $borrable;
    }


    /**
     * @return Materia
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * @param Materia $materia
     */
    public function setMateria($materia)
    {
        $this->materia = $materia;
    }

}