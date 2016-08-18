<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;

class PeriodoController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\PeriodoType';
    protected $textProperty = 'nombre';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.periodo.tm';
}
