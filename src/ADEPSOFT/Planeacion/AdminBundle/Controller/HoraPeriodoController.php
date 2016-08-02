<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;
use ADEPSOFT\ComunBundle\Util\Util;
use ADEPSOFT\Planeacion\AdminBundle\Form\HoraPeriodoType;

class HoraPeriodoController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\Planeacion\AdminBundle\Form\HoraPeriodoType';
    protected $textProperty = 'nombre';
    protected $view = '@PlaneacionAdmin/Hora/hora_crud.html.twig';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.hora_periodo.tm';

    public function extraData($obj)
    {
        $type = new HoraPeriodoType();
        $hora = $this->getRequest()->get($type->getName())['horaTime'];
        $obj->setHoraTime(Util::convertStringToTime($hora));
    }
}
