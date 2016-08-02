<?php

namespace ADEPSOFT\Planeacion\AdminBundle\TableDescription\Rutas;


use ADEPSOFT\ComunBundle\tableDescription\architecture\RutasGrid;
use Doctrine\ORM\Mapping as ORM;

class RutasProfesor extends RutasGrid
{
    protected $registroMaterias='planeacion_admin_crud_profesor_registro_materias' ;

    /**
     * @return string
     */
    public function getRegistroMaterias()
    {
        return $this->registroMaterias;
    }

    /**
     * @param string $registroMaterias
     */
    public function setRegistroMaterias($registroMaterias)
    {
        $this->registroMaterias = $registroMaterias;
    }

}