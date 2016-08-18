<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;

class TurnoController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\TurnoType';
    protected $textProperty = 'nombre';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.turno.tm';
}
