<?php

namespace Core\MySecurityBundle\Controller;

use Core\ComunBundle\Controller\TreeCRUDController;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\RutasTree;

class PermissionController extends TreeCRUDController
{
    protected $type = 'Core\MySecurityBundle\Form\PermissionType';
    /**
     * @var string Servicio del table model
     */
    protected $treeModelService = 'security.permission.tm';
    /**
     * Metodo Obligatorio de sobreescribir
     * @return RutasGrid
     */
    protected function defineRutas()
    {
        $rutas =new RutasTree();
        $rutas->setNew('security_crud_permission_new');
        $rutas->setDelete('security_crud_permission_delete');
        $rutas->setDetails('security_crud_permission_details');
        $rutas->setEdit('security_crud_permission_edit');
        $rutas->setList('security_crud_permission_list');
        $rutas->setMove('security_crud_permission_move');
        return $rutas;
    }
}
