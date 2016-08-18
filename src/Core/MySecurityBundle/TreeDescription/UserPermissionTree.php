<?php

namespace Core\MySecurityBundle\TreeDescription;


use Core\ComunBundle\tableDescription\architecture\TreeModel;
use Doctrine\ORM\Mapping as ORM;

class UserPermissionTree extends TreeModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\MySecurityBundle\Entity\Permission';
        $this->name="Permiso";
        $this->rootNode = "Todos los permisos";
        $this->setCheck(true);
        $this->setPortlet(false);
    }
}