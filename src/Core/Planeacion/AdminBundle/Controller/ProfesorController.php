<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;
use Core\ComunBundle\Util\ResultType;
use Core\ComunBundle\Util\Util;
use Core\MySecurityBundle\Entity\Usuario;
use Core\Planeacion\AdminBundle\Entity\GradoAcademico;
use Core\Planeacion\AdminBundle\Entity\IdiomaProfe;
use Core\Planeacion\AdminBundle\Entity\MaestriaDoctorado;
use Core\Planeacion\AdminBundle\Entity\Materia;
use Core\Planeacion\AdminBundle\Entity\Periodo;
use Core\Planeacion\AdminBundle\Entity\PreferenciaProfeHora;
use Core\Planeacion\AdminBundle\Entity\PreferenciaProfeMateria;
use Core\Planeacion\AdminBundle\Entity\ProfePeriodo;
use Core\Planeacion\AdminBundle\Entity\Profesor;
use Core\Planeacion\AdminBundle\Enums\EDia;
use Core\Planeacion\AdminBundle\Enums\ECarrera;
use Core\Planeacion\AdminBundle\Enums\ETipoMaestriaDoctorado;
use Core\Planeacion\AdminBundle\Enums\ETipoMateria;
use Core\Planeacion\AdminBundle\EP\EPCarrera;
use Core\Planeacion\AdminBundle\EP\EPMateriaHistorica;
use Core\Planeacion\AdminBundle\EP\EPPeriodoMateriaHistorico;
use Core\Planeacion\AdminBundle\EP\EPPlanEstudio;
use Core\Planeacion\AdminBundle\Exceptions\OrdenMateriaException;
use Core\Planeacion\AdminBundle\Form\ProfesorType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfesorController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\ProfesorType';
    protected $textProperty = 'nombre';
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.profesor.tm';

    protected $view = '@PlaneacionAdmin/Profesor/profe_crud.html.twig';
    protected $createView = '@PlaneacionAdmin/Profesor/new.html.twig';
    protected $editView = '@PlaneacionAdmin/Profesor/edit.html.twig';
//    protected $editView='@PlaneacionAdmin/Profesor/Exportar/hoja_datos.html.twig';
    protected $registroMateriasView = '@PlaneacionAdmin/Profesor/registroMaterias.html.twig';
    protected $exportFileName = 'Profesores';
    protected $exportEmail=true;
    protected $exportTwigExcel = '@Comun/architecture/components/CRUD/export_xls/export.html.twig';
    protected $exportURL='planeacion_admin_crud_profesor_export';



    /**
     * @return Response
     */
    public function exportCorreoAction()
    {

        try {
        $model = $this->get($this->tableModelService);

        $data = $model->getExportData();
        $profesores = $data["data"];
        $lista = "";
        foreach ($profesores as $profesor) {
            if ($profesor->getCorreo()!=""){
            $lista .= $profesor->getCorreo();
                $lista .= ";";

        }
        }
        $lista = str_replace(",", ";",$lista);

        /*header ("Content-Disposition: attachment; filename=\"listacorreo.txt\"" );
        header("Content-Type: application/force-download");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".strlen($lista));
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $lista;*/
      /*  $response = new Response();
        $response->setContent($lista);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="teams.txt"');
        $response->headers->set("Content-Transfer-Encoding"," binary");*/

        } catch (\Exception $e) {
            return new JsonResponse(array("success" => false, "reload" => false, 'sMessage' => $e->getMessage()));
        }

        return new JsonResponse(array("success" => true, "reload" => false, 'lista' => $lista));
    }


    public function jsonReadAction()
    {
        return $this->jsonRead2('PlaneacionAdminBundle:GrupoEstudiantes', array('select' => 'nombre'), true);
    }

    /**
     * @return Response
     */
    public function newAction()
    {
        $obj = new Profesor();
        $type = new ProfesorType();
        return $this->createUpdate($type, $obj, array(), 'create');
    }

    public function filtroAvanzadoAction()
    {

        $materiasDerecho = $this->getRepo("PlaneacionAdminBundle:Materia")->getActivasByCarrera(ECarrera::Derecho);
        $materiasCrimi = $this->getRepo("PlaneacionAdminBundle:Materia")->getActivasByCarrera(ECarrera::Criminologia);
        $periodos = $this->getRepo("PlaneacionAdminBundle:Periodo")->getOrdered();
        $turnos = $this->getRepo("PlaneacionAdminBundle:Turno")->getOrdered();

        $dias = $this->getRepo("PlaneacionAdminBundle:Dia")->getEntreSemana();
//        $horasAct = $this->getRepo("PlaneacionAdminBundle:Hora")->filterObjects(array('activo'=>true),array('nombre'=>'asc'));
        $horas = $this->getRepo("PlaneacionAdminBundle:Hora")->filterObjects(array(), array('nombre' => 'asc'));
        $aulas = $this->getRepo("PlaneacionAdminBundle:Aula")->filterObjects(array('activo' => true), array('nombre' => 'asc'));
        $tipoDescarga = $this->getRepo("PlaneacionAdminBundle:TipoDescargaAdministrativa")->filterObjects(array(), array('nombre' => 'asc'));

        return $this->render("@PlaneacionAdmin/Profesor/filtro_avanzado.html.twig",
            array(
                'materiasDerecho' => $materiasDerecho,
                'materiasCriminologia' => $materiasCrimi,
                'dias' => $dias,
                'horas' => $horas,
                'aulas' => $aulas,
                'turnos' => $turnos,
                'tipoDescargas'=>$tipoDescarga,
//                'horasAct'=>$horasAct,
                'periodos' => $periodos
            ));
    }

    public function eliminarMateriaHistoricoAction()
    {
        try {
            $idPeriodo = $this->getParameter('periodo');
            $idProfe = $this->getParameter('idProfe');

            $idMateria = $this->getParameter('idMateria');
            $obj = $this->getEm()->getRepository("PlaneacionAdminBundle:ProfePeriodo")->getByPeriodoMateriaProfe($idPeriodo, $idMateria, $idProfe);
            $this->getEm()->remove($obj);
            $this->getEm()->flush();
        } catch (\Exception $e) {
            return new JsonReexsponse(array("success" => false, "reload" => false, 'sMessage' => $e->getMessage()));
        }
        return $this->viewHistoricoMaterias($idProfe, true);
    }

    protected function viewHistoricoMaterias($idProfe, $json = false)
    {
        $profe = $this->getEm()->getRepository("PlaneacionAdminBundle:Profesor")->find($idProfe);
//        $materias = $this->getEm()->getRepository("PlaneacionAdminBundle:Materia")->getHistoricoByProfeHorario($idProfe);
//        ld($materias);
        $periodos = $this->getEm()->getRepository("PlaneacionAdminBundle:Periodo")->findAll();
        $allMaterias = $this->getEm()->getRepository("PlaneacionAdminBundle:Materia")->filterObjects();

        $periodosOrdenados = $this->getRepo("PlaneacionAdminBundle:Periodo")->getByProfeConMateria($idProfe);
        $r = array();
        $hayBorrable = false;
        $divisionTabla = count($periodosOrdenados);
//        ld($idProfe);
        foreach ($periodosOrdenados as $periodo) {
            /**
             * @var $periodo Periodo
             */
            $temps = $this->getEm()->getRepository("PlaneacionAdminBundle:Materia")->getByProfeYPeriodo($idProfe, $periodo->getId());
//            ld($periodo->getId());
//            ld(count($temps['auto']));
//            ld(count($temps['manual']));
            $p = new EPPeriodoMateriaHistorico();
            $p->setPeriodo($periodo);
            foreach ($temps['auto'] as $autoM) {
                $am = new EPMateriaHistorica();
                $am->setBorrable(false);
                $am->setMateria($autoM);
                $p->addMateria($am);
            }
            foreach ($temps['manual'] as $manualM) {
                $mm = new EPMateriaHistorica();
                $mm->setBorrable(true);
                $mm->setMateria($manualM);
                $p->addMateria($mm);

                $hayBorrable = true;
            }
//            foreach($p->getMateria() as $mat)
//                ld($mat->getBorrable());
            $r[] = $p;
        }
//        foreach($r as $hist)
//        {
//            foreach($hist->getMateria() as $mat)
//                ld($mat->getBorrable());
//        }
        if ($json) {//Si creando devolver JSON
            return new JsonResponse(
                array(
                    "html" => $this->renderView($this->registroMateriasView, array('historial' => $r, 'hayBorrable' => $hayBorrable, 'profe' => $profe, 'periodos' => $periodos, 'allMaterias' => $allMaterias, 'periodo_selected' => $this->getParameter('periodo'),
                        'periodo_new_selected' => $this->getParameter('periodo_new'))),
                    'success' => true,
                    'reload' => false,//no recargue el Grid, peusto que el modal no afecta los datos mostrados

                ));
        }

        return $this->render($this->registroMateriasView, array('historial' => $r, 'hayBorrable' => $hayBorrable, 'profe' => $profe, 'periodos' => $periodos, 'allMaterias' => $allMaterias,
            'periodo_selected' => $this->getParameter('periodo'),
            'periodo_new_selected' => $this->getParameter('periodo_new')));
    }

    /**
     * @return Response
     */
    public function registroMateriasAction()
    {
        $idProfe = $this->getParameter('id');
        if ('POST' === $this->getRequest()->getMethod()) {
            try {
                $idMateria = $this->getParameter('materia');
                $idPeriodo = $this->getParameter('periodo');

                if ($this->getParameter('materia_new_indicator') == 'true') {

                    $materiaNombre = $this->getParameter('materia_new');
                    $idPeriodo = $this->getParameter('periodo_new');
                    $clave = $this->getParameter('clave');
                    if ($materiaNombre == null || $idPeriodo == null || $idProfe == null)
                        return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => "Existen campos con valores no válidos."));
//                    UtilRepository2Config::$defaultStringComparer ='=';
                    $materia = $this->getEm()->getRepository("PlaneacionAdminBundle:Materia")->filter(array('materia.clave' => $clave, 'materia.nombre' => array('like', $materiaNombre)), null, ResultType::FirsResult);
//                    UtilRepository2Config::$defaultStringComparer ='like';

                    if ($materia != null) {
//                        ldd($materia);
                        $idMateria = $materia->getId();
                        goto opcion2;
                    }
                    $materia = new Materia();
                    $materia->setClave($clave);
                    $materia->setNombre($materiaNombre);
                    $materia->setTipoMateria($this->getEm()->find("PlaneacionAdminBundle:TipoMateria", ETipoMateria::Basica));
                    $materia->setActivo(false);


                    $profe = $this->getEm()->getRepository("PlaneacionAdminBundle:Profesor")->find($idProfe);
                    $periodo = $this->getEm()->getRepository("PlaneacionAdminBundle:Periodo")->find($idPeriodo);

                    $periodoP = new ProfePeriodo();
                    $periodoP->setProfesor($profe);
                    $periodoP->setPeriodo($periodo);
                    $periodoP->addHistoricoMateriaManual($materia);

                    $this->getEm()->persist($periodoP);
//                    $this->getEm()->persist($materia);
                    $this->getEm()->flush();
//                    $this->getEm()->flush();
//                    $idMateria=$materia->getId();
//                    ldd($materia->getId());

                } else {
                    if (($idMateria == null || count($idMateria) == 0) || $idPeriodo == null || $idProfe == null)
                        return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => "Existen campos con valores no válidos."));
                    opcion2:
                    $obj = $this->getEm()->getRepository("PlaneacionAdminBundle:ProfePeriodo")->getByPeriodoMateriaProfe($idPeriodo, $idMateria, $idProfe);
                    if ($obj != false)
                        return new JsonResponse(array("success" => false, "reload" => false, 'sMessage' => 'Está intentando insetar un elemento duplicado.'));

                    $obj = $this->getEm()->getRepository("PlaneacionAdminBundle:ProfePeriodo")->getByPeriodoMateriaProfeAuto($idPeriodo, $idMateria, $idProfe);
                    if ($obj != false)
                        return new JsonResponse(array("success" => false, "reload" => false, 'sMessage' => 'Está intentando insetar un elemento duplicado.'));

                    $profe = $this->getEm()->getRepository("PlaneacionAdminBundle:Profesor")->find($idProfe);
                    $periodo = $this->getEm()->getRepository("PlaneacionAdminBundle:Periodo")->find($idPeriodo);
                    if (!is_array($idMateria))
                        $idMateria = Array($idMateria);
                    foreach ($idMateria as $idM) {
                        $materia = $this->getEm()->getRepository("PlaneacionAdminBundle:Materia")->find($idM);
                        $periodoP = new ProfePeriodo();
                        $periodoP->setProfesor($profe);
                        $periodoP->setPeriodo($periodo);
                        $periodoP->addHistoricoMateriaManual($materia);
                        $this->getEm()->persist($periodoP);
                    }

                    $this->getEm()->flush();
                }
            } catch (\Exception $e) {
                throw $e;
                return new JsonResponse(array("success" => false, "reload" => false));
            }
        }
        return $this->viewHistoricoMaterias($idProfe, 'POST' === $this->getRequest()->getMethod());
    }

    /**
     * @return Response
     */
    public function editAction()
    {
        /**
         * @var $user Usuario
         */
        $user = $this->getUser();

        $type = new ProfesorType();
        $extraParams = array();
        if ($user->onlyProfe()) {
            $obj = $user->getProfesor();
        } else {
            $id = $this->getParameter('id');
            $obj = $this->getEm()->find("PlaneacionAdminBundle:Profesor", $id);
        }
        if ('GET' === $this->getRequest()->getMethod()) {
            /*$list = $this->getParameter('list',-1);
            if ($list != -1) {
                $extraParams['list'] = $list;
            }
            $back = true;
            $next = true;
            $ids = explode(".", $list);
            for ($i = 0 ; $i < count($ids) ; $i++) {
                if ($id == $ids[$i]){
                    if ($i == 0) {
                        $back = false;
                    }
                    if ($i == count($ids)-1) {
                        $next = false;
                    }
                }
            }
            $extraParams['back'] = $back;
            $extraParams['next'] = $next;*/
            $this->setDatosToObj($extraParams, $obj);
        }

        return $this->createUpdate($type, $obj, $extraParams, 'update');
    }

    /**
     * @param $extraParams
     * @param $obj Profesor
     */
    protected function setDatosToObj(&$extraParams, $obj)
    {
        $pref_hora = $this->getEm()->getRepository('PlaneacionAdminBundle:PreferenciaProfeHora')->filterObjects(array('profe' => $obj->getId()));
        $pref_materia = $this->getEm()->getRepository('PlaneacionAdminBundle:PreferenciaProfeMateria')->filterObjects(array('profe' => $obj->getId()));

        $horas = array();
        $horasValor = array();
        foreach ($pref_hora as $horaPref) {
            /**
             * @var PreferenciaProfeHora $horaPref
             */
            $horas[] = ($horaPref->getDia()->getId() == EDia::Lunes_Viernes ? "lunes_viernes_" : "sabado_") . "hora_" . $horaPref->getHora()->getId();
            $horasValor[] = $horaPref->getOrdenPreferencia();
        }
        $extraParams['horasPref'] = $horas;
        $extraParams['horasPrefValor'] = $horasValor;

        $materias = array();
        $materiasValor = array();
        foreach ($pref_materia as $materiaPref) {
            /**
             * @var PreferenciaProfeMateria $materiaPref
             */
            $materias[] = $materiaPref->getMateria()->getId();
            $materiasValor[] = $materiaPref->getOrdenPreferencia();
        }
        $extraParams['materiasPref'] = $materias;
        $extraParams['materiasPrefValor'] = $materiasValor;
        $extraParams['foto'] = $obj->getFoto();
    }

    /**
     * @param $type
     * @param $obj
     * @param $extra_params Parámetros con valores del edit
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Form\Exception\AlreadyBoundException
     */
    protected function createUpdate($type, Profesor $obj, $extra_params = array(), $action = 'create')
    {
        $form = $this->createForm($type, $obj);
        $em = $this->getEm();
        try {
            if ('POST' === $this->getRequest()->getMethod()) {

                $form->bind($this->getRequest());
                $ingfacdyc = $this->getRequest()->get($type->getName())['fechaIngresoFac'];
                if (Util::convertStringToDate($ingfacdyc) != false) {
                    $obj->setFechaIngresoFac(Util::convertStringToDate($ingfacdyc));
                }

                $inguanl = $this->getRequest()->get($type->getName())['fechaIngresoUanl'];

                if (Util::convertStringToDate($inguanl) != false) {
                    $obj->setFechaIngresoUanl(Util::convertStringToDate($inguanl));
                }
//                $obj->setCarrera($em->find("PlaneacionAdminBundle:Carrera",$this->getParameter('lic_radios')));
                $fechaNac = $this->getRequest()->get($type->getName())['fechaNacimiento'];
                if (Util::convertStringToDate($fechaNac) != false) {
                    $obj->setFechaNacimiento(Util::convertStringToDate($fechaNac));
                }
                $foto = $this->getRequest()->get("avatar_planilla_profesor");
                $obj->setFoto($foto);

                $idioma1 = $this->getRequest()->get($type->getName())['idioma1'];
                $this->addIdiomaToProfe($obj, $idioma1, 1);

                $idioma2 = $this->getRequest()->get($type->getName())['idioma2'];
                $this->addIdiomaToProfe($obj, $idioma2, 2);

                foreach ($obj->getGradoAcademico() as $delete) {
                    $obj->removeGradoAcademico($delete);
                    $em->remove($delete);
                }

                $maestriaEn = $this->getRequest()->get($type->getName())['maestriaEn'];
                $this->addGradoAcademicoToProfe($obj, $maestriaEn);

                $doctoradoEn = $this->getRequest()->get($type->getName())['doctoradoEn'];
                $this->addGradoAcademicoToProfe($obj, $doctoradoEn, ETipoMaestriaDoctorado::Doctorado);

                $this->addMateriasPrefToProfe($obj);
                $this->addHorasPrefToProfe($obj);

                if ($form->isValid()) {
                    //cambio de string a date

                    //insertar la foto

                    $em->persist($obj);
                    if ($obj->getUsuario()) {
                        $obj->getUsuario()->setNombre($obj->getNombre());
                        $obj->getUsuario()->setCedula($obj->getNumeroEmpleado());
                        $obj->getUsuario()->setEmail($obj->getCorreo());
                        $em->persist($obj->getUsuario());
                    }

                    $em->flush();
                    if (!$this->getUser()->onlyProfe()) {
                        $html = $this->getMainViewHtml();
                        return new JsonResponse(array("success" => true, "sStatus" => "OK", "html" => $html));
                    }

                } else {
//                    $this->setDatosToObj($extra_params,$obj);
//                    $form->get('numeroEmpleado')->getErrors()[0]->getMessage();
//                    $form = $this->createForm($type, $obj);
                    return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => "Existen campos con valores no válidos.", 'errors' => array('input[name*=numeroEmpleado]' => $form->get('numeroEmpleado')->getErrors()[0]->getMessage())));
                }
//            return $this->render($this->createView,  array('form' => $form->createview(),'model'=>$this->get($this->tableModelService)));
            }
        } catch (OrdenMateriaException $e) {
            return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => $e->getMessage()));
        }

//        $periodo = $this->getEm()->getRepository("PlaneacionAdminBundle:Periodo")->getOrdered(array(),ResultType::FirsResult);
//        ldd($periodo);
        $horasLV = $this->getEm()->getRepository("PlaneacionAdminBundle:Hora")->getLunesViernes(array('activo' => true));
        $horasS = $this->getEm()->getRepository("PlaneacionAdminBundle:Hora")->getSabado(array('activo' => true));

        $carreras = $this->getRepo('PlaneacionAdminBundle:Carrera')->filterObjects(array(), array('id' => 'asc'));

        $array = array();
        foreach ($carreras as $carrera) {
            $tmp = new EPCarrera();
            $tmp->setCarrera($carrera);
            $planEstudio = array();

            if ($this->exportHoja)
                $planEstudio = $this->getRepo('PlaneacionAdminBundle:PlanEstudio')->obtenerPorPreferenciaProfesor($obj->getId(), $carrera->getId());
            else
                $planEstudio = $this->getRepo('PlaneacionAdminBundle:PlanEstudio')->filterObjects(array('activo' => true, 'carrera' => $carrera->getId()));
            $planArray = array();
            foreach ($planEstudio as $plan) {
                $mats = $this->getRepo('PlaneacionAdminBundle:Materia')->getObligatoriasByPlanEstudio($plan->getId());
                $matsOptativas = $this->getRepo('PlaneacionAdminBundle:Materia')->obtenerOptativasConSemestrePorPlan($plan->getId(), array('activo' => true), array('materia.semestre' => 'asc', 'materia.clave' => 'asc'));
                $matsOptativasNoM = $this->getRepo('PlaneacionAdminBundle:Materia')->obtenerOptativasSinSemestrePorPlan($plan->getId(), array('activo' => true), array('materia.clave' => 'asc'));
                if (count($mats) > 0) {
                    $tmpPlan = new EPPlanEstudio();
                    $tmpPlan->setCarrera($carrera);
                    $tmpPlan->setMaterias($mats);
                    $tmpPlan->setOptativasSinSemestre($matsOptativasNoM);
                    $tmpPlan->setMateriasOpt($matsOptativas);
                    $tmpPlan->setPlan($plan);
                    $planArray[] = $tmpPlan;
                }
            }
            $tmp->setPlanEstudio($planArray);
            $array[] = $tmp;
        }
        $params = array('form' => $form->createview(), 'model' => $this->get($this->tableModelService), 'horasLV' => $horasLV, 'horasS' => $horasS,
            'array' => $array, 'obj' => $obj);
        if ($action != 'create') {
//            ldd($obj->getCarrera())//->getNombre();
            $extra_params['obj'] = $obj;
        }

        if (count($extra_params) > 0)
            $params = array_merge($params, $extra_params);

        if (!$this->getUser()->onlyProfe() || 'GET' === $this->getRequest()->getMethod()) {
            if ($action == 'create')
                return $this->render($this->createView, $params);
            else
                return $this->render($this->editView, $params);
        } else {
            return new JsonResponse(array("success" => true, "sStatus" => "OK", "html" => $this->renderView('@PlaneacionAdmin/Profesor/hoja_propia_content.html.twig', $params)));
        }
    }

    private function addIdiomaToProfe(Profesor $profe, $idiomaArray, $numero)
    {
        $em = $this->getEm();
        foreach ($profe->getIdiomaProfe() as $delete) {
            $profe->removeIdiomaProfe($delete);
            $em->remove($delete);
        }

        if (array_key_exists('idioma', $idiomaArray) && $idiomaArray['idioma'] != '') {
            $idiomaProfe = new IdiomaProfe();
            $idiomaProfe->setNumero($numero);
            $idiomaProfe->setIdioma($this->getEm()->find("PlaneacionAdminBundle:Idioma", $idiomaArray['idioma']));
            if (array_key_exists('porciento', $idiomaArray) && $idiomaArray['porciento'] != '')
                $idiomaProfe->setPorciento($idiomaArray['porciento']);
            $idiomaProfe->setProfesor($profe);
            $em->persist($idiomaProfe);
        }
    }

    private function addGradoAcademicoToProfe(Profesor $profe, $grado, $tipo = ETipoMaestriaDoctorado::Maestria)
    {
        if (array_key_exists('nombre', $grado) && $grado['nombre'] != '' && $grado['nombre']) {
            $gradoNew = new MaestriaDoctorado();
            $gradoNew->setNombre($grado['nombre']);
            if (array_key_exists('tipo', $grado) && $grado['tipo'] != '' && $grado['tipo']) {
                if ($grado['tipo'] == 1) {
                    $gradoNew->setPasante(true);
                    $gradoNew->setTitulado(false);
                } else {
                    $gradoNew->setTitulado(true);
                    $gradoNew->setPasante(false);
                }
                $gradoNew->setTipo($tipo);
                $profe->addGradoAcademico($gradoNew);
                $this->getEm()->persist($profe);
            }
        }
    }

    private function addMateriasPrefToProfe(Profesor $obj)
    {
        $orden = array();
        $em = $this->getEm();
        $derecho = false;
        $crimi = false;
        foreach ($obj->getPreferenciaMateria() as $delete) {
            $obj->removePreferenciaMateria($delete);
            $em->remove($delete);
        }

//        $lic = $this->getParameter('Carrera');
//        $plan = $this->getParameter('planEstudio');
        $materias = $this->getRepo('PlaneacionAdminBundle:Materia')->filterObjects();

        foreach ($materias as $materia) {
            $ordenPref = $this->getParameter($materia->getId());
            if ($ordenPref && $ordenPref != '') {

                if (array_key_exists($ordenPref, $orden))
                    throw new OrdenMateriaException("No pueden existir 2 materias con el mismo orden de preferencia.");
                $orden[$ordenPref] = 1;
                $prefM = new PreferenciaProfeMateria();
                $prefM->setMateria($this->getEm()->find('PlaneacionAdminBundle:Materia', $materia->getId()));
                $prefM->setOrdenPreferencia($ordenPref);
                $prefM->setProfe($obj);
                $this->getEm()->persist($prefM);
            }
        }
//        $obj->setDerecho($derecho);
//        $obj->setCriminologia($crimi);
    }

    private function addHorasPrefToProfe(Profesor $obj)
    {
        $em = $this->getEm();
        foreach ($obj->getPreferenciaHora() as $delete) {
            $obj->removePreferenciaHora($delete);
            $em->remove($delete);
        }

        $horas = $this->getRepo('PlaneacionAdminBundle:Hora')->filterObjects();
        $LV = $this->getRepo('PlaneacionAdminBundle:Dia')->find(EDia::Lunes_Viernes);
        $S = $this->getRepo('PlaneacionAdminBundle:Dia')->find(EDia::Sabado);
        foreach ($horas as $hora) {
            $prefLV = $this->getParameter("lunes_viernes_hora_" . $hora->getId());
            $prefS = $this->getParameter("sabado_hora_" . $hora->getId());
//            ld($prefLV.'----'.$prefS);
            if ($prefLV) {
//                ld($prefLV);
                $prefH = new PreferenciaProfeHora();
                $prefH->setOrdenPreferencia($prefLV);
                $prefH->setHora($hora);
                $prefH->setProfe($obj);
                $prefH->setDia($LV);
                $em->persist($prefH);
            }
            if ($prefS) {
//                ld($prefS);
                $prefH = new PreferenciaProfeHora();
                $prefH->setOrdenPreferencia($prefS);
                $prefH->setHora($hora);
                $prefH->setProfe($obj);
                $prefH->setDia($S);
                $em->persist($prefH);
            }
        }
    }

    protected $exportHoja = false;

    public function exportarHojasDeDatosAction()
    {
        $id = $this->getParameter('id');
//        $extraParams=array();
        $obj = $this->getRepo("PlaneacionAdminBundle:Profesor")->find($id);
//        $this->setDatosToObj($extraParams,$obj);
        $carrera = 1;
        if ($obj->getCriminologia()){
            $carrera = 2;
        }
        $serial = 'FO-FDC-PL-0'.$carrera.' REV00 2015-04-16';

//        $html= $this->createUpdate(new ProfesorType(), $obj,$extraParams,'export');
        $this->editView = '@PlaneacionAdmin/Profesor/Exportar/hoja_datos.html.twig';
        $this->exportHoja = true;
        $html = $this->editAction();
        $this->exportHoja = false;
        $content = $html->getContent();
//        ldd($content);
//        return new Response(
//            $content
//        );
        return new \Symfony\Component\HttpFoundation\Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($content, array('lowquality' => false, 'viewport-size' => "1600x900", 'footer-left'=>'Hoja [page] de [topage]', 'footer-right' => $serial, 'margin-top' => 5, 'page-size' => 'A4', 'footer-font-size'=>8)),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $obj->getNombreNumEmpleado() . '.pdf"'
            )
        );
//        ldd($content);

    }

}
