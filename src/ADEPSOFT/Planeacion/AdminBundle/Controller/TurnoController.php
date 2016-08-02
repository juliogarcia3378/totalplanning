<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;

class TurnoController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\Planeacion\AdminBundle\Form\TurnoType';
    protected $textProperty = 'nombre';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.turno.tm';
}
