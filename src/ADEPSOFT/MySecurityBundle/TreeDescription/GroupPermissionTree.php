<?php

namespace ADEPSOFT\MySecurityBundle\TreeDescription;


use ADEPSOFT\ComunBundle\tableDescription\architecture\TreeModel;
use Doctrine\ORM\Mapping as ORM;

class GroupPermissionTree extends TreeModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'ADEPSOFT\MySecurityBundle\Entity\Permission';
        $this->name="Permiso";
        $this->rootNode = "Todos los permisos";
        $this->setCheck(true);
        $this->setPortlet(false);
    }
}