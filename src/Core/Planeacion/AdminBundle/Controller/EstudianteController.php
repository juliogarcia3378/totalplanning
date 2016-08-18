<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;

class EstudianteController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\EstudianteType';
    protected $textProperty = 'nombres';
    protected $view = "PlaneacionAdminBundle:Estudiante:estudiante_crud.html.twig";
    protected $tableModelService = 'planeacion.admin.estudiante.tm';

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

}
