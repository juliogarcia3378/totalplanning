<?php
namespace ADEPSOFT\Planeacion\AdminBundle\EP;

use Doctrine\ORM\Mapping as ORM;

class EPSeleccionMaterias
{
    public $materia;

    /**
     * @return mixed
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * @param mixed $materia
     */
    public function setMateria($materia)
    {
        $this->materia = $materia;
    }
}