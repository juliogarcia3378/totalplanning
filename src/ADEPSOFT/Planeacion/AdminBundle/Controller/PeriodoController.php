<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;

class PeriodoController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\Planeacion\AdminBundle\Form\PeriodoType';
    protected $textProperty = 'nombre';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.periodo.tm';
}
