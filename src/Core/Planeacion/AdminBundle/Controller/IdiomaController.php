<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;

class IdiomaController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\IdiomaType';
    protected $textProperty = 'nombre';    
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.idioma.tm';
}
