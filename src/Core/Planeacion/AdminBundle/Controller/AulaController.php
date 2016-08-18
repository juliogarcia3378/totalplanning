<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;

class AulaController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\AulaType';
//    protected $view = '@PlaneacionAdmin/Hora/hora_crud.html.twig';
    protected $textProperty = 'nombre';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.aula.tm';
    protected $exportFileName ='Aulas';
    protected $exportURL = 'planeacion_admin_crud_aula_export';
    protected $exportTwigExcel = '@Comun/architecture/components/CRUD/export_xls/export.html.twig';

    public function filtroAvanzadoAction(){

        $periodos = $this->getRepo("PlaneacionAdminBundle:Periodo")->getOrdered();

        $dias = $this->getRepo("PlaneacionAdminBundle:Dia")->getEntreSemana();
//        $horasAct = $this->getRepo("PlaneacionAdminBundle:Hora")->filterObjects(array('activo'=>true),array('nombre'=>'asc'));
        $horas = $this->getRepo("PlaneacionAdminBundle:Hora")->filterObjects(array(),array('nombre'=>'asc'));

        return $this->render("@PlaneacionAdmin/Aula/filtro_avanzado.html.twig",
            array(
                'dias'=>$dias,
                'horas'=>$horas,
//                'horasAct'=>$horasAct,
                'periodos'=>$periodos
            ));
    }

    public function asignacionesAction()
    {
        return true;
    }
}
