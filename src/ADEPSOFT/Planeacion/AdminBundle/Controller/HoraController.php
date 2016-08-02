<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;
use ADEPSOFT\ComunBundle\Util\Util;
use ADEPSOFT\Planeacion\AdminBundle\Entity\Prueba;
use ADEPSOFT\Planeacion\AdminBundle\Form\HoraType;

class HoraController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\Planeacion\AdminBundle\Form\HoraType';
    protected $textProperty = 'nombre';
    protected $view = '@PlaneacionAdmin/Hora/hora_crud.html.twig';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.hora.tm';
    public function extraData($obj)
    {
        $type = new HoraType();
        $param = $type->getName();
        $hora = $this->getRequest()->get($param)['hora'];
        $obj->setHora(Util::convertStringToTime($hora));
    }
}
