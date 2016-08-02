<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;

class PlanEstudioController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\Planeacion\AdminBundle\Form\PlanEstudioType';
    protected $textProperty = 'nombre';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.planEstudio.tm';
}
