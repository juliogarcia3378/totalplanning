<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;

class PlanEstudioController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\PlanEstudioType';
    protected $textProperty = 'nombre';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.planEstudio.tm';
}
