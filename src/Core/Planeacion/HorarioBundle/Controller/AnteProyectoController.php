<?php
namespace Core\Planeacion\HorarioBundle\Controller;
use Core\ComunBundle\Controller\ADEPCRUDController__JMSInjector;
use Core\ComunBundle\Controller\MyCRUDController;
use Core\ComunBundle\Enums\EEstado;
use Core\Planeacion\AdminBundle\Entity\Anteproyecto;
use Core\Planeacion\AdminBundle\Entity\GrupoEstudiantes;
use Core\Planeacion\HorarioBundle\Exceptions\AnteProyectoException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AnteproyectoController extends MyCRUDController
{
    public function renderMainAction()
    {
        $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
        if (count($periodo) > 0) {
            $periodo = $periodo[0];
            $estado = 'En Elaboración';
            $anteproyecto = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('estado'=>EEstado::Elaboracion));
            $anteproyecto = $anteproyecto[0];
            $cambios = json_decode($anteproyecto->getCambios(), true);

            return $this->render('HorarioBundle:Anteproyecto:edit.html.twig', array('cambios' => $cambios,'periodo' => $periodo, 'estado' => $estado));
        }
        $periodosAnteriores = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Terminado));
        $periodosCandidatos = $this->getRepo("PlaneacionAdminBundle:Periodo")->getAnteproyectos(array());
        $planesEstudio = $this->getRepo("PlaneacionAdminBundle:PlanEstudio")->findAll();
        $tipoperiodos = $this->getRepo("PlaneacionAdminBundle:TipoPeriodo")->findAll();
        return $this->render('HorarioBundle:Anteproyecto:new.html.twig', array('periodosAnteriores' => $periodosAnteriores,
            'periodoCandidatos' => $periodosCandidatos,
            'tipoperiodos' => $tipoperiodos,
            'planesEstudio' => $planesEstudio));
    }
    public function deleteAction()
    {
        try {
            $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->eliminarAnteproyecto();
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
        return new JsonResponse(array("success" => true, "reload" => false, "sMessage" => "Elemento eliminado satisfactoriamente"));
    }
    public function publicarAnteproyectoAction(){
      try {
            $periodo = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->publicarAnteproyecto();
        } catch (AnteProyectoException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
        return new JsonResponse(array("success" => true, "reload" => false, "sMessage" => "Anteproyecto publicado satisfactoriamente"));
       
        //  $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findBy(array('estado' => EEstado::Elaboracion));
        
        
     /*   if (count($periodo) > 0) {
            $periodo = $periodo[0];
            $estado = $this->getRepo("PlaneacionAdminBundle:Estado")->find(EEstado::Aprobado);
            $periodo->setEstado($estado);
            $em = $this->getDoctrine()->getManager();
            $em->persist($periodo);
            $em->flush();
        }*/
        return new JsonResponse(array('msg' => "Anteproyecto Publicado Satisfactoriamente"));
    }
    public function newAction()
    {
        $actual = $this->getParameter('periodoActual');
        $referencia = $this->getParameter('referencia');
        $anteproyecto = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('periodo' => $actual));
        try {
            if (count($anteproyecto) == 0) {
                $anteproyecto = new Anteproyecto();
                $actual = $this->getRepo("PlaneacionAdminBundle:Periodo")->find($actual);
                $anteproyecto->setPeriodo($actual);
                $anteproyecto->setEstado($this->getRepo("PlaneacionAdminBundle:Estado")->find(EEstado::Elaboracion));
              
                if($referencia == "true")
                {
                    $p_anterior = $this->getParameter('periodoAnterior');
                    $anterior = $this->getRepo("PlaneacionAdminBundle:Periodo")->find($p_anterior);
                    $anteproyecto->setPeriodoAnterior($anterior);
                    
                    // Utilizar el fichero de cambios de Escolar.
                    $fichero_cambios = $this->getParameter('fichero_cambios');
                    // Crear nuevos grupos si hay disponibilidad de aula y turnos
                    $abrirGrupos = $this->getParameter('abrirGrupos');
                    // Generar grupos tomando en cuenta los cambios solicitados
                    $respuesta = $this->generarGruposConCambios($actual, $anterior, $fichero_cambios, $abrirGrupos);
                    // Guardar los cambios del análisis
                    $anteproyecto->setCambios(json_encode($respuesta));
                    // Replicar los horarios de los grupos con igual denominacion en el periodo anterior
                }
                  try {
                 $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->duplicarHoras($anterior, $actual);
                  // $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->duplicarHorarios($anterior, $actual);
                      $em = $this->getDoctrine()->getManager();
                      $em->persist($anteproyecto);
                      $em->flush();
                      return new JsonResponse(array('sMessage' => "El Anteproyecto ha sido creado satisfactoriamente"));
                  } catch (\Exception $e) {
         
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
                //$this->getRepo("PlaneacionAdminBundle:Anteproyecto")->crearNuevosGrupos($anterior->getId(), $actual->getId(), $anteproyecto);
              
            }
        } catch (\Exception $e) {
           
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }
        return new JsonResponse(array('sMessage' => "El Anteproyecto ha sido creado satisfactoriamente"));
    }

    private function generarGruposConCambios($actual, $anterior, $fichero_cambios, $abrirGrupos)
    {
        $respuesta = array();
        // Arreglo para el control de matrículas
        $matriculas = array();
        // Control de diferencias entre la capacidad y la matrícula.
        $disponibilidad = array();
        // Contexto ideal: promover los grupos sin ningún cambio al siguiente semestre.
        $nuevos_grupos = array();
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->getByPeriodo(array("periodo" => $anterior->getId()));
        //
        // Instanciar los grupos del nuevo periodo
        //
        foreach($grupos as $index=>$g)
        {
            // Crear una nueva instancia de grupo
            $ng = new GrupoEstudiantes();
            // Desechar los grupos del último semestre
            if ($g->getSemestre()->getNombre() != "10") {
                // Licenciatura del grupo que se analiza
                $lic = $g->getLicenciatura()->getId();
                // Turno del grupo que se analiza
                $tur = $g->getTurno()->getId();
                // Para cada grupo que no sea de décimo semestre, incrementar semestre...
                $ng->setSemestre($this->getRepo("PlaneacionAdminBundle:Semestre")->find($g->getSemestre()->getId() + 1));
                // ... y actualizar periodo
                $ng->setPeriodo($actual);
                // Actualizar los nombres, que serán la referencia con el periodo anterior
                $sem = "0".$ng->getSemestre()->getNombre();
                if ($sem == "010"){
                    $sem = "10";
                }
                $nuevo_nombre = str_replace(substr($g->getNombre(),0,2), $sem, $g->getNombre());
                $ng->setNombre($nuevo_nombre);
                $ng->setEnLinea(false);
                $ref = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->byPeriodoAndName($anterior->getId(), $nuevo_nombre);
                if ($ref != null){
                    $l = $ref[0]->getEnLinea();
                    if ( $l == true){
                        $ng->setEnLinea(true);
                    }
                }
                $sem = $ng->getSemestre()->getNombre();
                // LLevar el control de las cantidades por semestre y turno
                if (!isset($matriculas["matriculados"][$lic][$sem][$tur])){
                    $matriculas["matriculados"][$lic][$sem][$tur] = 0;
                }
                if (!isset($matriculas["capacidad"][$lic][$sem][$tur])){
                    $matriculas["capacidad"][$lic][$sem][$tur] = 0;
                }
                $matriculas["matriculados"][$lic][$sem][$tur] = $matriculas["matriculados"][$lic][$sem][$tur] + $g->getNivel();
                $matriculas["capacidad"][$lic][$sem][$tur] = $matriculas["capacidad"][$lic][$sem][$tur] + $g->getAula()->getCapacidad();
                // Control de las diferencias entre capacidad de las aulas y matrículas en cada semestre y turno
                $disponibilidad[$lic][$sem][$tur] = $matriculas["capacidad"][$lic][$sem][$tur] - $matriculas["matriculados"][$lic][$sem][$tur];
                // Copiar los demás parámetros
                $ng->setNivel($g->getNivel());
                $ng->setAula($g->getAula());
                $ng->setAulaString($g->getAulaString());
                $ng->setBilingue($g->getBilingue());
                $ng->setCampus($g->getCampus());
                $ng->setPaquete(false);
                $ng->setTerceros(false);
                $ng->setLicenciatura($g->getLicenciatura());
                $ng->setPlanEstudio($g->getPlanEstudio());
                $ng->setTurno($g->getTurno());
                // Añadir cada nuevo grupo al arreglo de los grupos puros de estudiantes en el periodo del anteproyecto
                $nuevos_grupos[] = $ng;
            }
        }
        //
        // Utilizar el fichero de cambios de Escolar
        //
        // Procesar los cambios del Departamento Escolar
        // Analizar la cadena con los parámetros de cambios
        $fichero_cambios = str_replace("\r\n","\n",$fichero_cambios);
        $fichero_cambios = str_replace("matutino","1",$fichero_cambios);
        $fichero_cambios = str_replace("piloto","2",$fichero_cambios);
        $fichero_cambios = str_replace("vespertino","3",$fichero_cambios);
        $fichero_cambios = str_replace("nocturno","4",$fichero_cambios);
        $fichero_cambios = str_replace("der","1",$fichero_cambios);
        $fichero_cambios = str_replace("cri","2",$fichero_cambios);
        $lineas = explode("\n", $fichero_cambios);
        // LLevar el control de los cambios totales
        $registro_cambios = array();
        $cambios_totales = array();
        $mat_especialidad = array();
        if ($lineas[0] == "carrera,semestre,cantidad,turno_a,turno_s"){
            unset($lineas[0]);
            foreach($lineas as $i=>$l) {
                $params = explode(",", $l);

                if ($params[0] == "mat_especialidad") {
                    if (count($params) != 7) {
                        throw new \Exception('El formato de los cambios de matrícula por especialidad es incorrecto. Asegúrese de haber definido una fila por cada carrera con el encabezado "mat_especialidad". Luego la carrera, el semestre del cambio y las matrículas de cada turno.');
                    } else {
                        $car = $params[1];
                        $car_sem = $params[2];
                        $mat_especialidad[$car][$car_sem]['1'] = (int)$params[3];
                        $mat_especialidad[$car][$car_sem]['2'] = (int)$params[4];
                        $mat_especialidad[$car][$car_sem]['3'] = (int)$params[5];
                        $mat_especialidad[$car][$car_sem]['4'] = (int)$params[6];
                    }
                    //unset($lineas[$i]);
                } else {

                    if (count($params) != 5) {
                        throw new \Exception('El formato del fichero es incorrecto. Asegúrese de haber definido un fichero con el encabezado: "carrera, semestre, cantidad, turno_a, turno_s" y de seleccionar correctamente el fichero a subir.');
                    }
                    // Formato de filas
                    $lic = $params[0];
                    $sem = $params[1];
                    $cant = $params[2];
                    $turno_a = $params[3];
                    $turno_s = $params[4];
                    $registro_cambios[$lic][$sem][$turno_s][$turno_a] = $cant;
                    if (!isset($cambios_totales[$lic][$sem][$turno_a])) {
                        $cambios_totales[$lic][$sem][$turno_a] = 0;
                    }
                    if (!isset($cambios_totales[$lic][$sem][$turno_s])) {
                        $cambios_totales[$lic][$sem][$turno_s] = 0;
                    }
                    $cambios_totales[$lic][$sem][$turno_a] -= $cant;
                    $cambios_totales[$lic][$sem][$turno_s] += $cant;
                }
            }
        }
        else {
            // Indicar que se deshaga el caso de uso.
            throw new \Exception('El formato del fichero es incorrecto. Asegúrese de haber definido un fichero con el encabezado: "carrera; semestre; cantidad; turno_a; turno_s" y de seleccionar correctamente el fichero a subir.');
        }

        //
        // Examinar las capacidades que dejan los grupos de décimo
        //
        $data = $this->getRepo("PlaneacionAdminBundle:Aula")->getAvailableClassRooms($anterior->getId());
        // Registro de "huecos" disponibles que podrían ser utilizados para facilitar los cambios de turno
        $holes = array();
        foreach($data as $aula) {
            $holes[] = $aula['capacidad'];
        }

        //
        // Actualizar las matrículas con los cambios que implica el semestre de la especialidad.
        //
        // Alterar el registro de matrículas con los cambios leidos del fichero de cambios
        foreach($mat_especialidad as $cambios_carrera => $cambios_registro) {
            foreach($cambios_registro as $cambios_semestre => $cambios_turnos) {
                foreach($cambios_turnos as $cambios_turno => $cambios_matricula) {
                    $matriculas["matriculados"][$cambios_carrera][$cambios_semestre][$cambios_turno] = $cambios_matricula;
                    $disponibilidad[$cambios_carrera][$cambios_semestre][$cambios_turno] = $matriculas["capacidad"][$cambios_carrera][$cambios_semestre][$cambios_turno] - $cambios_matricula;
                }
            }
        }

        //
        // Asimilar los cambios posibles y descartar el resto.
        //
        // Comparar la disponibilidad en la matrícula con los cambios que se proponen
        $cambios_rechazados = array();
        $posible_creacion = array();
        foreach($cambios_totales as $i=>$carrera) {
            foreach($carrera as $j=>$semestre) {
                foreach($semestre as $turno=>$cant) {
                    // Verificar que existan grupos asignados en el turno
                    if (isset($disponibilidad[$i][$j][$turno])) {
                        // Asegurar que exista alguna capacidad en el turno
                        if ($disponibilidad[$i][$j][$turno] > 0) {
                            // Detectar las incidencias: total solicitado en el turno es menor que la capacidad del turno
                            if ($disponibilidad[$i][$j][$turno] < $cambios_totales[$i][$j][$turno]) {
                                //echo "Incidencia: " . $i . ":" . $j . ":" . $turno . ":" . $cant . "[". $disponibilidad[$i][$j][$turno] ."/". $cambios_totales[$i][$j][$turno] ."]" . "<br/>";
                                // Intentar con cambios específicos dentro del lote que solicita el turno
                                if (isset($registro_cambios[$i][$j][$turno])) {
                                    // La política para aceptar las solicitudes se basa en el mejor ajuste
                                    $seleccionados = array();
                                    $candidates = $registro_cambios[$i][$j][$turno];
                                    $max = $disponibilidad[$i][$j][$turno];
                                    for( $x = 0; $x < count($candidates); $x++ ) {
                                        $best = 0;
                                        $pos = 0;
                                        foreach ($candidates as $index => $solicitud) {
                                            if ($solicitud <= $max) {
                                                if ($solicitud > $best) {
                                                    $best = $solicitud;
                                                    $pos = $index;
                                                }
                                            }
                                        }
                                        // Actualiza el techo de búsqueda en la siguiente iteración
                                        // Y el acumulado para el control de la capacidad
                                        if ($pos != 0) {
                                            $seleccionados[$pos] = $best;
                                            $max -= $best;
                                        }
                                    }
                                    //echo "Seleccionados: ";
                                    //ld($seleccionados);
                                    $todelete = array_diff_key($candidates,$seleccionados);
                                    //ld($todelete);
                                    // Rechazar las solicitudes no seleccionadas
                                    foreach($todelete as $index => $solicitudes) {
                                        $cambios_rechazados[$i][$j][$turno][$index] = $registro_cambios[$i][$j][$turno][$index];
                                        unset($registro_cambios[$i][$j][$turno][$index]);
                                    }
                                }
                            }
                        } else {
                            // No hay capacidad, es imposible cubrir la demanda
                            // Descartar las solicitudes
                            if(isset($registro_cambios[$i][$j][$turno])) {
                                $candidates = $registro_cambios[$i][$j][$turno];
                                foreach ($candidates as $index => $solicitud) {
                                    $cambios_rechazados[$i][$j][$turno][$index] = $registro_cambios[$i][$j][$turno][$index];
                                    unset($registro_cambios[$i][$j][$turno][$index]);
                                }
                            }
                            //echo "Rechazado: " . $i . ":" . $j . ":" . $turno . ":" . $cant . "[". $disponibilidad[$i][$j][$turno] ."/". $cambios_totales[$i][$j][$turno] ."]<br/>";
                        }
                    } else {
                        // Reporte de posible creación de grupos
                        if(isset($registro_cambios[$i][$j][$turno])) {
                            $candidates = $registro_cambios[$i][$j][$turno];
                            foreach ($candidates as $index => $solicitud) {
                                $posible_creacion[$i][$j][$turno][$index] = $registro_cambios[$i][$j][$turno][$index];
                            }
                        }
                        //echo "Posible creación: " . $i . ":" . $j . ":" . $turno . ":" . $cant . "[/" . $cambios_totales[$i][$j][$turno] ."]<br/>";
                    }
                }
            }
        }
        //
        // Procesar los nuevos datos para conformar la matrícula final.
        //
        // Actualizar los cambios totales con los movimientos aceptados
        foreach($cambios_totales as $i=>$carrera) {
            foreach($carrera as $j=>$semestre) {
                foreach($semestre as $turno=>$cant) {
                    $candidates = $cambios_totales[$i][$j];
                    foreach($candidates as $index => $solicitud) {
                        if (isset($cambios_totales[$i][$j][$turno])) {
                            if (isset($cambios_rechazados[$i][$j][$index][$turno]) && isset($cambios_rechazados[$i][$j][$turno][$index])) {
                                $cambios_totales[$i][$j][$turno] -= $cambios_rechazados[$i][$j][$index][$turno];
                                $cambios_totales[$i][$j][$turno] += $cambios_rechazados[$i][$j][$turno][$index];
                            }
                        }
                    }
                }
            }
        }
        //ldd($cambios_totales);
        // Y ahora calcular las matrículas finales después de cambios
        $matriculafinal= array();
        foreach($matriculas["matriculados"] as $i=>$carrera) {
            foreach($carrera as $j=>$semestre) {
                foreach($semestre as $turno=>$cant) {
                    if (isset($cambios_totales[$i][$j][$turno])) {
                        $dif = $matriculas["matriculados"][$i][$j][$turno] + $cambios_totales[$i][$j][$turno];
                        if ($dif < 0) {
                            $matriculafinal[$i][$j][$turno] = 0;
                            foreach($nuevos_grupos as $index => $ng) {
                                if ($ng->getLicenciatura()->getId() == $i) {
                                    if ($ng->getSemestre()->getId() == $j) {
                                        if ($ng->getTurno()->getId() == $turno) {
                                            unset($nuevos_grupos[$index]);
                                        }
                                    }
                                }
                            }
                        } else {
                            $matriculafinal[$i][$j][$turno] = $dif;
                        }
                    }
                }
            }
        }
        // Guardar las instancias de los nuevos grupos en la base de datos
        $em = $this->getDoctrine()->getManager();
        foreach($nuevos_grupos as $ng) {
            if (!$ng->getBilingue()) {
                $ng->setNivel($ng->getAula()->getCapacidad() - 2);
            }
            $em->persist($ng);
        }
        $em->flush();
        $respuesta["rechazados"] = $cambios_rechazados;
        $respuesta["creacion"] = $posible_creacion;
        $respuesta["nueva_matricula"] = $matriculafinal;
        return $respuesta;
        //echo json_encode($respuesta);
        /*echo "Rechazados:<br/>";
        ld($cambios_rechazados);
        echo "Aprobados:<br/>";
        ld($registro_cambios);
        echo "Creación:<br/>";
        ld($posible_creacion);
        echo "Solicitudes:<br/>";
        ld($cambios_totales);
        echo "Disponibilidad:<br/>";
        ldd($disponibilidad);*/
        //die();
    }
    public function horarioSemestreMateriaPdfAction()
    {
        $anteproyecto =$this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('estado'=>EEstado::Elaboracion));
        $anteproyecto = $anteproyecto[0];
        $materias = $this->getRepo("PlaneacionAdminBundle:Materia")->findAll();
        
        $response =Array();
        $i=0;
        foreach($materias as $materia)
        {
            $arr =Array();
            $arr["nombre"]=$materia->getNombre();
            $arr["clave"]=$materia->getClave();
          //  $response[$i]["materia"]=$arr;
            $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array('periodo' => $anteproyecto->getPeriodo()->getId()));
            foreach ($grupos as $key => $grupo) {
                 $arr["grupos"][$grupo->getId()]["grupo"]=$this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array('periodo'=>$anteproyecto->getPeriodo()->getId()));
            $arr["grupos"][$grupo->getId()]["horario"]=$this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->findByCriteria(array('periodo'=>$anteproyecto->getPeriodo()->getId(),"grupo"=>$grupo->getId()));
                 $response[$i++]=$arr;
            }
        }
        //ldd($response);
        $content = $this->renderView('HorarioBundle:Anteproyecto/Exportar:horarioXSemestre.html.twig', array(
                'response' => $response,
                'disableScripts' => true)
        );
        $headerTwig = '@Comun/architecture/components/CRUD/export_header.html.twig';
        $footerTwigt='@Comun/architecture/components/CRUD/export_footer.html.twig';
        $headerHtml = $this->renderView($headerTwig);
        $footerHtml = $this->renderView($footerTwigt);
        $result=$headerHtml.$content.$footerHtml;
           return new Response(
               $result
           );
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($content,array('lowquality'=>false,'encoding'=>'UTF-8',
                'header-html'=>$headerHtml,'footer-html'=>$footerHtml,'header-spacing'=>5,'margin-top'=>40,'footer-spacing'=>5)),
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
    public function gruposSinAsignacionPdfAction()
    {
         $licenciatura = $this->getParameter('licenciatura');
        $anteproyecto =$this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('estado'=>EEstado::Elaboracion));
        $anteproyecto = $anteproyecto[0];
        $materias = $this->getRepo("PlaneacionAdminBundle:Materia")->getActivasByLicenciatura($licenciatura);
        $response =Array();
        $i=0;$j=0;
        $periodo = $anteproyecto->getPeriodo()->getId();
        foreach($materias as $materia)
        {
            $arr =Array();
            $arr["nombre"]=$materia->getNombre();
            $arr["clave"]=$materia->getClave();
            $arr["frecuencia"]=$materia->getFrecuenciaSemanal();
           $grupos=$this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->bySemestre($materia->getSemestre(),$periodo);
            foreach ($grupos as $grupo)
            {
               $arr1 =Array();
           
                $horarios = $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteProyecto")->
                buscarTurnosMateria(array('materia'=>$materia->getId(),'grupo'=>$grupo->getId(),'asignada'=>false));
                      // if es 0 es sin Asignar
                $arr1["nombreCompleto"]=$grupo->getNombre();
                $arr1["aula"]=$grupo->getAula()->getNombre();
                $arr1["horarios"]=Array();
                if (!count($horarios)>0){
                   // unset($response[$i]);
                   // continue;
                }
                else
                    $response[$i]["materia"]=$arr;
                  foreach ($horarios as $horario){
                       if (array_key_exists("".$horario->getDia()->getId(),$arr1["horarios"]))
                      $arr1["horarios"][$horario->getDia()->getId()]=$arr1["horarios"][$horario->getDia()->getId()]. ", ".$horario->getHora()->getNombre();
                      else
                          $arr1["horarios"][$horario->getDia()->getId()]=$horario->getHora()->getNombre();
                      $response[$i]["grupo"][$grupo->getId()]=$arr1;
                  }
                $j=$j+1;
            }
            $i=$i+1;
        }
       // ldd($response);
        $content = $this->renderView('HorarioBundle:Anteproyecto/Exportar:gruposSinAsignacion.html.twig', array(
                'response' => $response,
                'periodo'=>$anteproyecto->getPeriodo()->getNombre(),
                'licenciatura'=>$this->getRepo("PlaneacionAdminBundle:Licenciatura")->find($licenciatura),
                'disableScripts' => true)
        );
        $headerTwig = '@Comun/architecture/components/CRUD/export_header.html.twig';
        $footerTwigt='@Comun/architecture/components/CRUD/export_footer.html.twig';
        $headerHtml = $this->renderView($headerTwig);
        $footerHtml = $this->renderView($footerTwigt);
        $result=$headerHtml.$content.$footerHtml;
      /*  return new Response(
            $result
        );*/
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($content,array('lowquality'=>false,'encoding'=>'UTF-8',
                'header-html'=>$headerHtml,'footer-html'=>$footerHtml,'header-spacing'=>5,'margin-top'=>40,'footer-spacing'=>5)),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename=GruposSinAsignacion.pdf'
            )
        );
    }
    public function exportarAulasYGruposAction()
    {
        $periodo = $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
        $periodo = $periodo[0];
        $aulas = $this->getRepo("PlaneacionAdminBundle:Aula")->findAll();
        $aulasygrupos = array();
        $aula_index = 0;
        foreach($aulas as $room)
        { if ($room->getCapacidad()>0 && $room->getActivo()){
            $room_data = array(
                'id'        => $room->getId(),
                'nombre'    => $room->getNombre(),
                'capacidad' => $room->getCapacidad());
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
                    'horas'     => $group['frecuencia']);
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
        $content = $this->renderView('HorarioBundle:DistribucionCambio/Exportar:aulasygrupos.html.twig', array(
                'aulasygrupos' => $aulasygrupos));
        $headerTwig = '@Comun/architecture/components/CRUD/export_header.html.twig';
        $footerTwigt= '@Comun/architecture/components/CRUD/export_footer.html.twig';
        $headerHtml = $this->renderView($headerTwig);
        //$footerHtml = $this->renderView($footerTwigt);
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($content,array('orientation'=>'Landscape', 'lowquality'=>false,'encoding'=>'utf-8',
                'header-html'=>$headerHtml, 'footer-left' => utf8_decode('Revisión: 01'), 'footer-center' => 'Hoja [page] de [topage]', 'footer-right' => 'FO-FDC-PL-03', 'header-spacing'=>5,'margin-top'=>40,'footer-spacing'=>5)),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename=Grupos_y_Aulas.pdf'
            )
        );
    }

    public function horarioSIASEPdfAction(){
        $anteproyecto = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('estado'=>EEstado::Elaboracion));
        $anteproyecto = $anteproyecto[0];
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->getByPeriodo(array("periodo" => $anteproyecto->getPeriodo()));

        $data = array();
        $index = 0;
        foreach($grupos as $g) {
            $horario = array();
            $horarios = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->getSIASEInput($g->getId());
            if (count($horarios) > 0) {
                $e = array();
                foreach ($horarios as $h) {
                    $e['hora'] = $h['hora'];
                    $e['dia'] = $h['dia'];
                    $e['profe'] = $h['profe'];
                    $e['materia'] = $h['materia'];
                    $e['aula'] = $h['aula'];
                    $horario[] = $e;
                }
                $entry = array(
                    'nombre' => $g->getNombreCompleto(),
                    'horario' => $horario);
                $data[$index] = $entry;
                ++$index;
            }
        }

        //ldd($data);

        $content = $this->renderView('HorarioBundle:Anteproyecto/Exportar:siase.html.twig', array(
            'data' => $data));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($content, array('lowquality'=>false,'encoding'=>'utf-8',
                'footer-center' => 'Hoja [page] de [topage]', 'header-spacing'=>5,'margin-top'=>5,'footer-spacing'=>1)),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename=Datos_SIASE.pdf'
            )
        );
    }
}
