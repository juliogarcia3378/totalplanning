<?php
/**
 * Created by PhpStorm.
 * User: MATRIX
 * Date: 20/02/2015
 * Time: 14:50
 */

namespace Core\MySecurityBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\RutasGrid;

class GroupRutas extends RutasGrid {
    protected  $permisos;

    /**
     * @return mixed
     */
    public function getPermisos()
    {
        return $this->permisos;
    }

    /**
     * @param mixed $permisos
     */
    public function setPermisos($permisos)
    {
        $this->permisos = $permisos;
    }

} 