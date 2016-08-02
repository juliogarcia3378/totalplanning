<?php

namespace ADEPSOFT\MySecurityBundle\TreeDescription;


use ADEPSOFT\ComunBundle\tableDescription\architecture\TreeModel;
use Doctrine\ORM\Mapping as ORM;

class PermissionTree extends TreeModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'ADEPSOFT\MySecurityBundle\Entity\Permission';
        $this->name="Permiso";
        $this->rootNode = "Todos los permisos";
    }
}