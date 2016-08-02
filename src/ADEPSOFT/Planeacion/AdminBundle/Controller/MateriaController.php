<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;

class MateriaController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\Planeacion\AdminBundle\Form\MateriaType';
    protected $textProperty = 'nombre';
    protected $exportFileName = 'Materias';
    protected $exportURL = 'planeacion_admin_crud_materia_export';
    protected $exportTwigExcel = '@Comun/architecture/components/CRUD/export_xls/export.html.twig';
    protected $footerTwigt='@Comun/architecture/components/CRUD/export_footer.html.twig';

//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.materia.tm';

    public function filtroAvanzadoAction(){

        $periodos = $this->getRepo("PlaneacionAdminBundle:Periodo")->getOrdered();

       // $materia = $this->getRepo("PlaneacionAdminBundle:Materia")->findAll();

        return $this->render("@PlaneacionAdmin/Materia/filtro_avanzado.html.twig",
            array(
           //     'materias'=>$materia,
                'periodos'=>$periodos
            ));
    }
}
