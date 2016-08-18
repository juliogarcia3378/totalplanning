<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;
use Core\ComunBundle\Util\Util;
use Core\Planeacion\AdminBundle\Entity\Prueba;
use Core\Planeacion\AdminBundle\Form\HoraType;

class HoraController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\HoraType';
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
