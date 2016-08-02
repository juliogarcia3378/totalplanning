<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;

class IdiomaController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\Planeacion\AdminBundle\Form\IdiomaType';
    protected $textProperty = 'nombre';    
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.idioma.tm';
}
