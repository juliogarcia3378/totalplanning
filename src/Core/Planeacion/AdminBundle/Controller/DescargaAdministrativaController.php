<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;

class DescargaAdministrativaController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\DescargaAdministrativaType';
    protected $textProperty = 'nombre';
    protected $tableModelService = 'planeacion.admin.descargaadministrativa.tm';
    protected $exportFileName = 'Descargas de Profesores';
    protected $exportTwigExcel = '@Comun/architecture/components/CRUD/export_xls/export.html.twig';
    protected $exportTwig = '@Comun/architecture/components/CRUD/export.html.twig';
    protected $exportURL='planeacion_admin_crud_descargas_export';
}
