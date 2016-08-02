<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;

class AutoasignacionAulaController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\Planeacion\AdminBundle\Form\AutoasignacionAulaType';
    protected $textProperty = 'nombre';
    protected $tableModelService = 'planeacion.admin.autoasignacionaula.tm';
    protected $exportFileName = 'Aulas de asignacion directa';
    protected $exportTwigExcel = '@Comun/architecture/components/CRUD/export_xls/export.html.twig';
    protected $exportTwig = '@Comun/architecture/components/CRUD/export.html.twig';
    protected $exportURL = 'planeacion_admin_crud_autoasignacion_export';
}