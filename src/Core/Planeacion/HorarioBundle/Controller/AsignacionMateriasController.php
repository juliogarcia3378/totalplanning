<?php

namespace Core\Planeacion\HorarioBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;
use Core\ComunBundle\Enums\EEstado;
use Core\Planeacion\HorarioBundle\Exceptions\AnteProyectoException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AsignacionMateriasController extends MyCRUDController
{

    public function renderMainAction()
    {

        $materias = $this->getRepo("PlaneacionAdminBundle:Materia")->findAll();
        $criteria = new \Doctrine\Common\Collections\Criteria();
        $criteria->orWhere($criteria->expr()->eq('enlinea', true))
            ->orWhere($criteria->expr()->eq('capacidad', 0));
        $aulas = $this->getRepo("PlaneacionAdminBundle:Aula")->matching($criteria);
        $licenciaturas = $this->getRepo("PlaneacionAdminBundle:Licenciatura")->findAll();
        $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));

        if (count($periodo) > 0)
            $periodo = $periodo[0];

        $gruposs = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array('periodo' => $periodo->getId()), array('nombre' => 'desc'));
        $grupos = array();
        foreach ($gruposs as $key => $value) {
            $response["id"] = $value->getId();
            if ($value->getBilingue() == true) {
                $response["nombreCompleto"] = $value->getNombreCompletoAula() . " - " . $value->getTurno()->getNombre() . " - Bilingue ";
            } else {
                $response["nombreCompleto"] = $value->getNombreCompletoAula() . " - " . $value->getTurno()->getNombre();
            }
            $grupos[] = $response;
        }

        return $this->render('HorarioBundle:AsignacionMaterias:horario.html.twig', array('periodo' => $periodo, 'aulas' => $aulas, 'grupos' => $grupos, 'materias' => $materias, 'licenciaturas' => $licenciaturas));
    }

    public function horasPeriodoAction()
    {
        $periodo = $this->getParameter('periodo');
        $id = $this->getParameter('id');
        $response = $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->getHorarioByGrupo(array("periodo" => $periodo, "grupo" => $id));
        $script = $this->getParameter('disableScripts');
        $response['disableScripts'] = $script;
        $response['periodo'] = $periodo;
        //ldd($response);
        return $this->render("HorarioBundle:AsignacionMaterias:tabla_hora_horario.html.twig", $response);
    }

    public function generarPropuestaBaseAction()
    {
        try {
            $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->duplicarHorarios();
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }

        return new JsonResponse(array("success" => true));
    }

    public function asignacionesAction()
    {
        $grupos = array();
        try {
            $grupo = $this->getParameter('id');
            $periodo = $this->getParameter('periodo');
            $anteproyecto = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('periodo' => $periodo));
            $actual = $anteproyecto[0]->getPeriodo();
            $anterior = $anteproyecto[0]->getPeriodoAnterior();
            $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($grupo);
            $materias = $this->getRepo("PlaneacionAdminBundle:Materia")->byGroup($grupo);
            foreach ($materias as $key => $materia) {
                $re = $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->findFrecuenciaMateria(array("periodo" => $periodo, "materia" => $materia["id"], "grupo" => $grupo));
                $materias[$key]["asignaciones"] = count($this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findFrecuenciaMateria(array("periodo" => $periodo,
                    "materia" => $materia["id"], "grupo" => $grupo)));
            }
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }

        return new JsonResponse(array("success" => true, "materias" => $materias));
    }

    public function MateriasByGroupAction()
    {
        $grupos = array();
        try {
            $grupo = $this->getParameter('id');
            $periodo = $this->getParameter('periodo');
            $anteproyecto = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('periodo' => $periodo));
            $actual = $anteproyecto[0]->getPeriodo();
            $anterior = $anteproyecto[0]->getPeriodoAnterior();
            // $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->duplicarHorarios();

            $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($grupo);
            //   $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->duplicarHorariosGrupo($grupo);
            $materias = $this->getRepo("PlaneacionAdminBundle:Materia")->byGroup($grupo);
//ldd($materias);
            foreach ($materias as $key => $materia) {
                $re = $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->
                findFrecuenciaMateria(array("periodo" => $periodo,
                        "materia" => $materia["id"],
                        "grupo" => $grupo));
                foreach ($re as $r) {
                    //   ld($r->getMateria()->getNombre());
                    //   ld($r->getId());
                }
                //  ld( $materias[$key]["frecuenciaSemanal"]);

                $materias[$key]["asignaciones"] = count($this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->
                findFrecuenciaMateria(array("periodo" => $periodo,
                        "materia" => $materia["id"],
                        "grupo" => $grupo)));
            }
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }

        return new JsonResponse(array("success" => true, "materias" => $materias));
    }

    public function gruposByLicenciaturaAction()
    {

        $response = array();

        try {
            $licenciatura = $this->getParameter('id');
            $periodo = $this->getParameter('periodo');
            //  ld($periodo);
            $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array("licenciatura" => $licenciatura, "periodo" => $periodo), array('nombre' => 'desc'));
            foreach ($grupos as $key => $value) {
                $response[$key]["id"] = $value->getId();


                if ($value->getBilingue() == true) {
                    $response[$key]["nombreCompleto"] = $value->getNombreCompletoAula() . " - " . $value->getTurno()->getNombre() . " - Bilingue ";
                } else {
                    $response[$key]["nombreCompleto"] = $value->getNombreCompletoAula() . " - " . $value->getTurno()->getNombre();
                }
            }
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }

        return new JsonResponse(array("success" => true, "grupos" => $response));
    }

    public function asignarMateriaAction()
    {
        try {
            $data = $this->getParameter('data');
            $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->asignarMateria($data);
            $grupo = $this->getParameter('id');
            $periodo = $this->getParameter('periodo');
            $anteproyecto = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('periodo' => $periodo));
            $actual = $anteproyecto[0]->getPeriodo();
            $anterior = $anteproyecto[0]->getPeriodoAnterior();
            $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($grupo);
            $materias = $this->getRepo("PlaneacionAdminBundle:Materia")->byGroup($grupo);
            foreach ($materias as $key => $materia) {
                $re = $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->findFrecuenciaMateria(array("periodo" => $periodo, "materia" => $materia["id"], "grupo" => $grupo));
                $materias[$key]["asignaciones"] = count($this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findFrecuenciaMateria(array("periodo" => $periodo,
                    "materia" => $materia["id"], "grupo" => $grupo)));
            }
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }

        return new JsonResponse(array("materias" => $materias, "success" => true, "reload" => false, "sMessage" => "Elemento asignado satisfactoriamente"));
    }

    public function eliminarMateriaAction()
    {
        try {
            $data = $this->getParameter('data');
            $grupo = $this->getParameter('id');
            $periodo = $this->getParameter('periodo');
            $anteproyecto = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('periodo' => $periodo));
            $actual = $anteproyecto[0]->getPeriodo();
            $anterior = $anteproyecto[0]->getPeriodoAnterior();
            $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($grupo);
            $materias = $this->getRepo("PlaneacionAdminBundle:Materia")->byGroup($grupo);
            $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->eliminarMateria($data);
            foreach ($materias as $key => $materia) {
                $re = $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->findFrecuenciaMateria(array("periodo" => $periodo, "materia" => $materia["id"], "grupo" => $grupo));
                $materias[$key]["asignaciones"] = count($this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findFrecuenciaMateria(array("periodo" => $periodo,
                    "materia" => $materia["id"], "grupo" => $grupo)));
            }
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
        return new JsonResponse(array("materias" => $materias, "success" => true, "reload" => false, "sMessage" => "Elemento eliminado satisfactoriamente"));
    }

    public function asociarAulaAction()
    {
        try {
            $grupo = $this->getParameter('grupo');
            $aula = $this->getParameter('aula');
            $periodo = $this->getParameter('periodo');

            $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->asociarAula($grupo, $aula, $periodo);
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
        return new JsonResponse(array("success" => true, "reload" => false, "sMessage" => ""));
    }

    public function asignacionDirectaAction()
    {
        try {
            $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->asignacionDirecta();
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
        return new JsonResponse(array("success" => true, "reload" => false, "sMessage" => "La asignación se llevó a cabo satisfactoriamente."));
    }
}
