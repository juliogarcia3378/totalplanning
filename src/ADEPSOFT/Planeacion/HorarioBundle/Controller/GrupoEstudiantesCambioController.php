<?php

namespace ADEPSOFT\Planeacion\HorarioBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;
use ADEPSOFT\ComunBundle\Enums\EEstado;
use ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GrupoEstudiantesCambioController extends MyCRUDController {
    protected $type = 'ADEPSOFT\Planeacion\HorarioBundle\Form\GrupoCambioType';
    protected $createView = '@Horario/DistribucionCambio/new.html.twig';
    protected $editView = '@Horario/DistribucionCambio/edit.html.twig';
//    protected $view = '@PlaneacionAdmin/Hora/hora_crud.html.twig';
    protected $textProperty = 'periodo';
    protected $daughter = __CLASS__;

//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.horario.grupoestudiantescambio.tm';
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

    public function renderMainAction()
    {
        
        $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
        if (count($periodo) > 0) {
            $periodo = $periodo[0];
            $estado = $this->getRepo("PlaneacionAdminBundle:Estado")->find(EEstado::Elaboracion)->getNombre();
            $aulas = $this->getRepo("PlaneacionAdminBundle:Aula")->findBy(array(), array('id' => 'ASC'));;

            $aulasygrupos = array();
            $aula_index = 0;
            foreach($aulas as $room)
            { if ($room->getCapacidad()>0 && $room->getActivo()){
                $online = 'false';
                if ($room->getEnLinea()) {
                    $online = 'true';
                }
                $room_data = array(
                    'id'        => $room->getId(),
                    'nombre'    => $room->getNombre(),
                    'capacidad' => $room->getCapacidad(),
                    'online' => $online);
                $aulasygrupos[$aula_index] = $room_data;
                $data = $this->getRepo("PlaneacionAdminBundle:Aula")->getGroupsInClassRoom($periodo->getId(), $room->getId());
                foreach($data as $group)
                {
                    $group_data = array(
                        'id'        => $group['grupo_id'],
                        'nombre'    => $group['nombre_completo'],
                        'plan'      => $group['plan_estudio'],
                        'nivel'     => $group['nivel'],
                        'semestre'  => $group['semestre'],
                        'tercero'   => 'false',
                        'bilingue'  => 'false',
                        'horas'     => $group['frecuencia'],
                        'carrera'   => $group['carrera'],
                        'enlinea'   => $group['enlinea']);
                    if ($group['terceros'])
                    {
                        $group_data['tercero'] = 'true';
                    }
                    if ($group['bilingue'])
                    {
                        $group_data['bilingue'] = 'true';
                    }
                    $aulasygrupos[$aula_index]['t'.$group['turno']] = $group_data;
                }
                $aula_index++;
            }}
            $anteproyecto =$this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('estado'=>EEstado::Elaboracion));
            $anteproyecto = $anteproyecto[0];
            $anterior=$anteproyecto->getPeriodoAnterior()->getNombre();
            $actual=$anteproyecto->getPeriodo()->getNombre();
            $cambios = json_decode($anteproyecto->getCambios(), true);
            $cambios = $cambios["nueva_matricula"];
            $carreras = $this->getRepo("PlaneacionAdminBundle:Licenciatura")->findAll();
            $planesEstudio = $this->getRepo("PlaneacionAdminBundle:PlanEstudio")->findAll();

            $turnos = $this->getRepo("PlaneacionAdminBundle:Turno")->findAll();

            return $this->render('HorarioBundle:DistribucionCambio:index.html.twig', array('periodo' => $periodo,
                'estado' => $estado,
                'aulasygrupos' => $aulasygrupos,
                'turnos' => $turnos,
                'cambios' => $cambios,
                'planes' => $planesEstudio,
                'carreras' => $carreras,
                'anterior' => $anterior, 'actual' => $actual));
        }
    }

    public function listComponentAjaxAction(){
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantesCambio")->findAll();
        $arrayR = Array();
        //aula_turno
        ldd($grupos);
        foreach ($grupos as $grupo)
        {
            if ($grupo->getActual()->getNivel()!=0)
            {
            $array["grupoId"]=$grupo->getActual()->getId();
            $array["grupoNombre"]=$grupo->getAnterior()->getNombre();

            //  $array["grupoNombre"]=$grupo->getAnterior()->getSemestre().$grupo->getAnterior()->getLicenciatura()->getNombre()[0];
            $array["licenciatura"]=$grupo->getActual()->getLicenciatura()->getId();
            $array["nivel"]=$grupo->getActual()->getNivel();
            $array["horas"]=$grupo->getActual()->getNivel();
            $array["turno"]=$grupo->getActual()->getTurno()->getId();
            $array["bilingue"]=$grupo->getActual()->getBilingue();
            $array["terceros"]=$grupo->getActual()->getTerceros();
            $array["aula"]=$grupo->getActual()->getAula()->getId();
            $arrayR[]=$array;
            }
        }

        return new JsonResponse($arrayR);
    }

    public function exportarDistribucionAction()
    {
        $anteproyecto =$this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('estado'=>EEstado::Elaboracion));
        $anteproyecto = $anteproyecto[0];
        $semestresGrupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->getDistribucionCambios($anteproyecto);
      // ldd($semestresGrupos);
        $anterior=$anteproyecto->getPeriodoAnterior()->getNombre();
        $actual=$anteproyecto->getPeriodo()->getNombre();

        $turnos = $this->getRepo("PlaneacionAdminBundle:Turno")->findAll();
        $content = $this->renderView('HorarioBundle:DistribucionCambio/Exportar:distribucion.html.twig', array(
                'licenciaturas' => $semestresGrupos, 'turnos' => $turnos,
                'anterior' => $anterior, 'actual' => $actual,
                'disableScripts' => true)
        );
         /*$headerTwig = '@Comun/architecture/components/CRUD/export_header.html.twig';
         $footerTwigt='HorarioBundle:DistribucionCambio/Exportar:export_footer.html.twig';
        $headerHtml = $this->renderView($headerTwig);
        $footerHtml = $this->renderView($footerTwigt);*/
        //ldd($footerHtml);
      /* $result=$content.$footerHtml;
    return new Response(
            $result
        );*/
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($content,array('lowquality'=>false,'encoding'=>'UTF-8',
                'footer-left' => utf8_decode('Revisión:01'), 'footer-center' => 'Hoja [page] de [topage]', 'footer-right' => 'FO-FDC-PL-05',
                'header-spacing'=>5,'margin-top'=>10,'footer-spacing'=>5, 'footer-font-size'=>8)),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename=Distribucion.pdf'
            )
        );
//       ldd($content);

      /* return new Response(
            $content
        );*/


    }

    public function desAsociarAulaAction(){
        $aula = $this->getParameter('aula');
        $grupo = $this->getParameter('grupo');
        $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->desAsociarAula($grupo,$aula);


    }

    public function gruposSinAulaAction(){
        $periodo = $this->getParameter('periodo');
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->gruposSinAula($periodo);
    }

    public function removeGrupoAction(){
        try {
            $id = $this->getParameter('grupo');
            $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($id);
            $horarios = $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findBy(array('grupo' => $id));
            $em = $this->getDoctrine()->getManager();
            foreach($horarios as $h){
                $em->remove($h);
            }
            $em->remove($grupo);
            $em->flush();
        } catch (\Exception $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
        return new JsonResponse(array('sMessage' => "El grupo ha sido eliminado"));
    }

    public function updateGrupoAction(){
        try {
            $id = $this->getParameter('grupo');
            $nivel = $this->getParameter('nivel');
            $bilingue = $this->getParameter('bilingue');
            $aulaid = $this->getParameter('aula');
            $turnoid = $this->getParameter('turno');
            $online = $this->getParameter('online');

            $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($id);
            $grupo->setNivel($nivel);
            $grupo->setBilingue($bilingue);
            $aula = $this->getRepo("PlaneacionAdminBundle:Aula")->find($aulaid);
            $grupo->setAula($aula);
            $turno = $this->getRepo("PlaneacionAdminBundle:Turno")->find($turnoid);
            $grupo->setTurno($turno);
            $grupo->setEnLinea($online);

            $em = $this->getDoctrine()->getManager();
            $em->persist($grupo);
            $em->flush();
        } catch (\Exception $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
        return new JsonResponse(array('sMessage' => "El grupo ha sido actualizado"));
    }

    public function createGrupoAction(){
        $g_id = 0;
        $g_horas = 0;
        try {
            $nombre = $this->getParameter('nombre');
            $nivel = $this->getParameter('nivel');
            $bilingue = $this->getParameter('bil');
            $aulaid = $this->getParameter('aula');
            $semestreid = $this->getParameter('semestre');
            $periodoid = $this->getParameter('periodo');
            $turnoid = $this->getParameter('turno');
            $planid = $this->getParameter('plan');
            $carreraid = $this->getParameter('carrera');
            $campusid = $this->getParameter('campus');

            $grupo = new GrupoEstudiantes();
            $grupo->setNombre($nombre);
            $grupo->setBilingue($bilingue);
            $aula = $this->getRepo("PlaneacionAdminBundle:Aula")->find($aulaid);
            $grupo->setAula($aula);
            $turno = $this->getRepo("PlaneacionAdminBundle:Turno")->find($turnoid);
            $grupo->setTurno($turno);
            $carrera = $this->getRepo("PlaneacionAdminBundle:Licenciatura")->find($carreraid);
            $grupo->setLicenciatura($carrera);
            $grupo->setPaquete(false);
            $grupo->setTerceros(false);
            $campus = $this->getRepo("PlaneacionAdminBundle:Campus")->find($campusid);
            $grupo->setCampus($campus);
            $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->find($periodoid);
            $grupo->setPeriodo($periodo);
            $plan = $this->getRepo("PlaneacionAdminBundle:PlanEstudio")->find($planid);
            $grupo->setPlanEstudio($plan);
            $semestre = $this->getRepo("PlaneacionAdminBundle:Semestre")->find($semestreid);
            $grupo->setSemestre($semestre);
            $grupo->setNivel($nivel);

            $em = $this->getDoctrine()->getManager();
            $em->persist($grupo);
            $em->flush();
            $g_id = $grupo->getId();
            $g_horas = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->getHorasPeriodo($periodoid, $g_id);

            //echo('Bili: '.$grupo->getBilingue());

            //Dirty hack to be quick. It must be putted on view later
            $html = '<div class="group label label-default t'.$turnoid.'" id="'.$g_id.'" nivel="'.$nivel.'" semestre="'.$semestre->getNombre().'" plan="'.$plan->getNombre().'" carrera="'.$carreraid.'" fusion="false" lock="false" bilingue="'.$grupo->getBilingue().'" terceros="false" horas="'.$g_horas[0]['frecuencia'].'" draggable="true" ondragstart="dragstart(event)" ondrag="drag(event)" ondragend="dragend(event)">'
                    .'<div class="group-label">'
                    .'<span class="group-menu fa fa-chevron-circle-right fa-lg" style="cursor:pointer;" onclick="group_context_menu(event);"></span>'
                    .'<span class="group-name" ondrop="swap_drop(event)" ondragover="target_dragover(event)"> '.$grupo->getNombre().'<sup>';
            if ($grupo->getBilingue() == 'true'){
                $html.='<b>B</b>';
            }
            $html.='</sup></span><span class="group-close fa fa-times fa-lg" style="cursor:pointer;" onclick="group_close('.$g_id.');"></span></div></div>';

        } catch (\Exception $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }

        return new JsonResponse(array('sMessage' => "El grupo ha sido creado", 'turno'=>$turnoid, 'aula_id'=>$aulaid, 'grupo_node' => $html));
    }
}
