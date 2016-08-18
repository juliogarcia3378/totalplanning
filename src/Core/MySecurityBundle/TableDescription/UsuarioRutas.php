<?php
/**
 * Created by PhpStorm.
 * User: MATRIX
 * Date: 20/02/2015
 * Time: 14:50
 */

namespace Core\MySecurityBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\RutasGrid;

class UsuarioRutas extends RutasGrid {
    protected  $permisos;
    protected $roles;
    protected $instancias;
    protected $establecerPass;

    /**
     * @return mixed
     */
    public function getEstablecerPass()
    {
        return $this->establecerPass;
    }

    /**
     * @param mixed $establecerPass
     */
    public function setEstablecerPass($establecerPass)
    {
        $this->establecerPass = $establecerPass;
    }

    /**
     * @return mixed
     */
    public function getInstancias()
    {
        return $this->instancias;
    }

    /**
     * @param mixed $instancias
     */
    public function setInstancias($instancias)
    {
        $this->instancias = $instancias;
    }



    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

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