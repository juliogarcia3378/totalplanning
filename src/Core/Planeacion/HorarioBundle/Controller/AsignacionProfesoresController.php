<?php

namespace Core\Planeacion\HorarioBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;
use Core\ComunBundle\Enums\EEstado;
use Core\Planeacion\HorarioBundle\Exceptions\AnteProyectoException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AsignacionProfesoresController extends MyCRUDController
{

    public function renderMainAction()
    {
        $profesores = $this->getRepo("PlaneacionAdminBundle:Profesor")->findAll();
        $categorias = $this->getRepo("PlaneacionAdminBundle:Categoria")->findAll();
        $materias_sincarrera = $this->getRepo("PlaneacionAdminBundle:Materia")->findAll();
        $materias = array();
        foreach ($materias_sincarrera as $key => $m) {
            $carrera = "D";
            $materia = array();
            $plan_id = $m->getPlanEstudio();
            if ($plan_id != null) {
                if ($this->getRepo("PlaneacionAdminBundle:PlanEstudio")->find($plan_id)->getLicenciatura()->getId() == 2) {
                    $carrera = "C";
                }
                $materia['id'] = $m->getId();
                $materia['clave'] = $m->getClave();
                $materia['nombre'] = $m->getNombre();
                $materia['carrera'] = $carrera;
                $materias[] = $materia;
            }
        }
        $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
        if (count($periodo) > 0)
            $periodo = $periodo[0];
        return $this->render('HorarioBundle:AsignacionProfesores:asignacion.html.twig', array('periodo' => $periodo, 'profesores' => $profesores, 'categorias' => $categorias, 'materias' => $materias));
    }

    public function detallesAction()
    {
        $idP = $this->getParameter('id');
        $periodo = $this->getParameter('periodo');
        $detalles = array();
        $profesor = $this->getRepo("PlaneacionAdminBundle:Profesor")->find($idP);
        $detalles["preferenciaHoras"] = $this->getRepo("PlaneacionAdminBundle:PreferenciaProfeHora")->getPreferenciasByProfe($idP);
        $detalles["preferenciaMaterias"] = $this->getRepo("PlaneacionAdminBundle:Materia")->getByProfePreferencia($idP);
        if (count($periodo) > 0)
            $periodo = $periodo[0];
        return $this->render('HorarioBundle:AsignacionProfesores:detail_profe.html.twig', array('periodo' => $periodo, 'datosC' => $detalles));
    }

    public function HorarioByGroupAction()
    {
        $id = $this->getParameter('id');
        $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
        if (count($periodo) > 0)
            $periodo = $periodo[0];
        $horarios_grupos = array();
        $response = array();
        $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($id);
        $response[$grupo->getId()] = $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->
        getHorarioByGrupo(array("periodo" => $periodo, "grupo" => $grupo->getId()));


//ldd($response);
        //    return $this->render("HorarioBundle:AsignacionMaterias:tabla_hora_horario.html.twig",
        //       $response);
        $script = $this->getParameter('disableScripts');
        return $this->render('HorarioBundle:AsignacionProfesores:tabla_hora_horario.html.twig', array("grupo_id" => $id, "room" => $grupo->getAula()->getId(), 'disableScripts' => $script, 'periodo' => $periodo, "response" => $response));
    }

    public function gruposByMateriaAction()
    {
        $id = $this->getParameter('id');
        $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
        if (count($periodo) > 0)
            $periodo = $periodo[0];
        $materia = $this->getRepo("PlaneacionAdminBundle:Materia")->find($id);
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->getByMaterias(array("materia" => $id, "periodo" => $periodo));
        $horarios_grupos = array();
        $response = array();
        foreach ($grupos as $grupo) {

            $response[$grupo->getId()] = $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->
            getHorarioByGrupo(array("periodo" => $periodo, "grupo" => $grupo->getId()));



            //    return $this->render("HorarioBundle:AsignacionMaterias:tabla_hora_horario.html.twig",
            //       $response);
        }
        $script = $this->getParameter('disableScripts');
        return $this->render('HorarioBundle:AsignacionProfesores:tabla_hora_horario.html.twig', array('disableScripts' => $script, 'periodo' => $periodo, "response" => $response));
    }

    public function asignarProfesorAction()
    {
        try {
            $data = $this->getParameter('data');
            $profesor = $this->getParameter('profesor');
            // $data[]=$profesor;
            //   ldd($data);
            $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
            if (count($periodo) > 0)
                $periodo = $periodo[0];
            //  $data[]=$periodo;
            $flag = $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->asignarProfesorAMateria($data, $profesor, $periodo);
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
        if ($flag)
            return new JsonResponse(array("success" => true, "reload" => false, "sMessage" => "El profesor ya tiene esa frecuencia ocupada."));
        return new JsonResponse(array("success" => true, "reload" => false, "sMessage" => "Elemento asignado satisfactoriamente"));
    }

    public function eliminarProfesorAction()
    {
        try {
            $data = $this->getParameter('data');
            $profesor = $this->getParameter('profesor');
            $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
            if (count($periodo) > 0)
                $periodo = $periodo[0];
            $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->eliminarProfesorAMateria($data, $profesor, $periodo);
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }

        return new JsonResponse(array("success" => true, "reload" => false, "sMessage" => "Elemento eliminado satisfactoriamente"));
    }

    public function listarProfesoresAction()
    {
        try {
            $categoria = $this->getParameter('id');
            return new JsonResponse(array("success" => true, "profesores" =>
                $this->getRepo("PlaneacionAdminBundle:Profesor")->byCategory(array("categoria" => $categoria))));
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
    }

    public function listarGruposCandidatosByMateriaAction()
    {
        try {
            $materia = $this->getParameter('id');
            $gruposR = array();
            // ldd($grupos);
            $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
            $materia = $this->getRepo("PlaneacionAdminBundle:Materia")->find($materia);

            if (count($periodo) > 0)
                $periodo = $periodo[0];

            $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->bySemestreYMateria(
                $materia->getSemestre()->getId(), $periodo->getId(), $materia->getId());

            if (count($grupos) > 0)
                foreach ($grupos as $grupo) {
                    if ($grupo->getBilingue() == true) {
                        $array["nombre"] = $grupo->getNombreCompletoAula() . " - " . $grupo->getTurno()->getNombre() . " - Bilingue ";
                    } else {
                        $array["nombre"] = $grupo->getNombreCompletoAula() . " - " . $grupo->getTurno()->getNombre();
                    }
                    //   $array["nombre"]=$grupo->getNombre();
                    $array["id"] = $grupo->getId();
                    $gruposR[] = $array;
                }
            return new JsonResponse(array("success" => true, "grupos" => $gruposR));
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
    }

    public function listarMateriasByProfesorAction()
    {
        try {
            $profesor = $this->getParameter('id');
            $preferenciaMaterias = $this->getRepo("PlaneacionAdminBundle:Profesor")->find($profesor)->getPreferenciaMateria();
            $materias = array();
            if (count($preferenciaMaterias) > 0)
                foreach ($preferenciaMaterias as $preferencia) {
                    $array["nombre"] = $preferencia->getMateria()->getNombre();
                    $array["clave"] = $preferencia->getMateria()->getClave();
                    $array["id"] = $preferencia->getMateria()->getId();
                    $materias[$preferencia->getOrdenPreferencia()] = $array;
                }
            $response = array();
            foreach ($materias as $m)
                $response[] = $m;
            return new JsonResponse(array("success" => true, "materias" => $response));
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
    }

    public function horarioProfesorAction()
    {
        $periodo = $this->getParameter('periodo');
        $id = $this->getParameter('id');


        //ldd($estado);
        $dias = $this->getRepo("PlaneacionAdminBundle:Dia")->getEntreSemana();
        $horas = $this->getEm()->getRepository("PlaneacionAdminBundle:HoraPeriodo")->getOrderedByPeriodo($periodo);
        // ld($periodo);
        //  ldd($id);
        $horarios = array();
        if ($id != '' && $periodo != '') {

            $obj = $this->getRepo("PlaneacionAdminBundle:ProfePeriodo")->findBy(array("profesor" => $id, "periodo" => $periodo));
            if (count($obj) > 0)
                $obj = $obj[0];
            else {
                die;
            }
            // $obj = $this->getRepo("PlaneacionAdminBundle:ProfePeriodo")->find($id);
        }


        foreach ($obj->getGrupoHorarioAnteproyecto() as $horario) {
            if (count($horario->getAula()) > 0)
                $horarios[] = array(
                    $horario->getHora()->getId(),
                    $horario->getDia()->getId(), $horario->getGrupo()->getId(),
                    $horario->getMateria()->getId(),
                    $horario->getGrupo()->getNombreCompleto(),
                    $horario->getMateria()->getClave(),
                    $horario->getAula()->getNombre());
            else
                $horarios[] = array(
                    $horario->getHora()->getId(),
                    $horario->getDia()->getId(), $horario->getGrupo()->getId(),
                    $horario->getMateria()->getId(),
                    $horario->getGrupo()->getNombreCompleto(),
                    $horario->getMateria()->getClave(),
                    $horario->getGrupo()->getAula()->getNombre());
        }

//ldd($horarios);
        $script = $this->getParameter('disableScripts');
//        ldd($script);
        return $this->render("@PlaneacionAdmin/ProfesorHorario/tabla_hora_horario.html.twig", array("horarios" => $horarios, "horas" => $horas, 'dias' => $dias, 'disableScripts' => $script));
    }

}
