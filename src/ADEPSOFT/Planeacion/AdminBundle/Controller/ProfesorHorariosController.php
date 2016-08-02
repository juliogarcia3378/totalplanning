<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;
use ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo;
use ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfesorHorariosController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\Planeacion\AdminBundle\Form\ProfePeriodoType';
    protected $textProperty = null;
    protected $view = "PlaneacionAdminBundle:ProfesorHorario:profesor_horario_crud.html.twig";
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.profesor_horarios.tm';
    protected $createView = 'PlaneacionAdminBundle:ProfesorHorario:new.html.twig';
    protected $editView = 'PlaneacionAdminBundle:ProfesorHorario:new.html.twig';

    public function jsonReadAction()
    {
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findAll();
        $array = Array();
        foreach ($grupos as $grupo)
        {
            $array[$grupo->getId()]=$grupo->getNombreCompletoAula();
        }

        return new JsonResponse($array);
        return $this->jsonRead('PlaneacionAdminBundle:GrupoEstudiantes', array('select' => 'nombre'), true);
    }

     public function horasPeriodoAction()
    {
        $periodo = $this->getParameter('periodo');
        $id = $this->getParameter('id');
        $dias = $this->getRepo("PlaneacionAdminBundle:Dia")->getEntreSemana();
        $horas = $this->getEm()->getRepository("PlaneacionAdminBundle:HoraPeriodo")->getOrderedByPeriodo($periodo);
//        ld($periodo);
//        ldd($horas);
        $horarios = array();
        if ($id != '') {
            $obj = $this->getEm()->find("PlaneacionAdminBundle:ProfePeriodo", $id);
            foreach ($obj->getProfePeriodoHorario() as $horario) {
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
        }
        $script = $this->getParameter('disableScripts');
//        ldd($script);
        return $this->render("@PlaneacionAdmin/ProfesorHorario/tabla_hora_horario.html.twig", array("horarios" => $horarios, "horas" => $horas, 'dias' => $dias, 'disableScripts' => $script));
    }
    /**
     * @return Response
     */
    public function renderMain()
    {
        $model = $this->get($this->tableModelService);
        $model->setExtraParams(array(array('name' => 'idProfe', 'value' => $this->getParameter('id'))));

        $id = $this->getParameter('id');
        $profe = $this->getRepo('PlaneacionAdminBundle:Profesor')->find($id);
        $model->setName('Horarios de: ' . $profe->getNombre());
        $descarga = $this->getRepo('PlaneacionAdminBundle:TipoDescargaAdministrativa')->findAll();
        //  ldd($model->defineRutas());
        return $this->render($this->view, array('model' => $model, 'tipoDescargas' => $descarga, 'rutas' => $model->defineRutas()));
    }

    /**
     * @return Response
     */
    public function newAction()
    {
        $tableModel = $this->get($this->tableModelService);
//        $entity = $tableModel->getEntity();
        $obj = new ProfePeriodo();

        $extra_params = array();
       
        $profe = $this->getEm()->find("PlaneacionAdminBundle:Profesor", $this->getParameter('idProfe'));
        $extra_params['profesor'] = $profe;
//        $dias = $this->getRepo("PlaneacionAdminBundle:Dia")->getEntreSemana();
//        $horas = $this->getRepo("PlaneacionAdminBundle:Hora")->filterObjects();
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->filterObjects();
//        $extra_params['horas']=$horas;
//        $extra_params['dias']=$dias;
        $extra_params['grupos'] = $grupos;
        $extra_params['aulas'] = $this->getRepo("PlaneacionAdminBundle:Aula")->filterObjects();
        $extra_params['_constructor_params'] = $extra_params['profesor'];
        $obj->setProfesor($extra_params['profesor']);
        $crimi = false;
        $derecho = false;
        if ('POST' === $this->getRequest()->getMethod()) {
            $horarios = $this->getParameter('horario');
            if (!is_array($horarios))
                $horarios = array();
            foreach ($horarios as $horario) {
                //hora_dia_grupo_materia
                $array = explode("_", $horario);

                $materia = $this->getEm()->find("PlaneacionAdminBundle:Materia", $array[3]);
                $var = new ProfePeriodoHorario();
                $obj->addProfePeriodoHorario($var);
                /*if ($materia->getPlanEstudio()->getLicenciatura()->getId() == ELicenciatura::Criminologia)
                    $crimi = true;
                else
                    if ($materia->getPlanEstudio()->getLicenciatura()->getId() == ELicenciatura::Derecho)
                        $derecho = true;
                $profe->setDerecho($derecho);
                $profe->setCriminologia($crimi);*/
                $this->getEm()->persist($profe);
                $var->setMateria($materia);
                $var->setGrupo($this->getEm()->find("PlaneacionAdminBundle:GrupoEstudiantes", $array[2]));
                $var->setHora($this->getEm()->find("PlaneacionAdminBundle:HoraPeriodo", $array[0]));
                $var->setDia($this->getEm()->find("PlaneacionAdminBundle:Dia", $array[1]));
            }
        }
        $extra_params['edit'] = false;
        return $this->creadeUpdate($obj, $this->createView, '', $extra_params);
    }

    protected function getExtraParams()
    {
        return array(array('name' => 'idProfe', 'value' => $this->getParameter('idProfe')));
    }

    /**
     * @return Response
     */
    public function editAction()
    {
        $em = $this->getEm();
        $tableModel = $this->get($this->tableModelService);
//        $entity = $tableModel->getEntity();
       //ld($this->getParameter('id'));
        $obj = $this->getEm()->find("PlaneacionAdminBundle:ProfePeriodo", $this->getParameter('id'));
//ldd($obj);
        $extra_params = array();
        $extra_params['idObj'] = $obj->getId();
        $extra_params['profesor'] = $obj->getProfesor();
//        $dias = $this->getRepo("PlaneacionAdminBundle:Dia")->getEntreSemana();
//        $horas = $this->getRepo("PlaneacionAdminBundle:Hora")->filterObjects();
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->filterObjects();
//        $extra_params['horas']=$horas;
//        $extra_params['dias']=$dias;

        $extra_params['grupos'] = $grupos;
        $extra_params['aulas'] = $this->getRepo("PlaneacionAdminBundle:Aula")->filterObjects();
        $extra_params['_constructor_params'] = $extra_params['profesor'];
        $obj->setProfesor($extra_params['profesor']);

        if ('POST' === $this->getRequest()->getMethod()) {
            $horarios = $this->getParameter('horario');
            foreach ($obj->getProfePeriodoHorario() as $delete) {
                $obj->removeProfePeriodoHorario($delete);
                $em->remove($delete);
            }
            foreach ($horarios as $horario) {
                //hora_dia_grupo_materia
                $array = explode("_", $horario);
                $var = new ProfePeriodoHorario();
                $obj->addProfePeriodoHorario($var);
                $var->setMateria($this->getEm()->find("PlaneacionAdminBundle:Materia", $array[3]));
                $var->setGrupo($em->find("PlaneacionAdminBundle:GrupoEstudiantes", $array[2]));
                $var->setHora($em->find("PlaneacionAdminBundle:HoraPeriodo", $array[0]));
                $var->setDia($em->find("PlaneacionAdminBundle:Dia", $array[1]));
               //  $var->setEstado($em->find("PlaneacionAdminBundle:EstadoHorario", 1));
                if (count($array)==5){
                    $var->setAula($em->find("PlaneacionAdminBundle:Aula", $array[4]));
                }
            }
        } else {
//            $extra_params['horarios'] = array();
//            foreach($obj->getProfePeriodoHorario() as $horario)
//            {
//                /**
//                 * @var $horario ProfePeriodoHorario
//                 */
////                $extra_params['horario'][] = $horario->getHora()->getId()."_".$horario->getDia()->getId()."_".$horario->getGrupo()->getId()."_".$horario->getMateria()->getId();
//                $extra_params['horarios'][] = array($horario->getHora()->getId(), $horario->getDia()->getId(), $horario->getGrupo()->getNombreCompleto(), $horario->getMateria()->getClave());
//            }
        }
        $extra_params['redirect'] = false;
        $extra_params['edit'] = true;
        $extra_params['periodo'] = $obj->getPeriodo();
        // ldd(1);
        return $this->creadeUpdate($obj, $this->createView, '', $extra_params);
    }

    public function exportarHorarioAction()
    {
        $obj = $this->getEm()->find("PlaneacionAdminBundle:ProfePeriodo", $this->getParameter('id'));
        $profe = $obj->getProfesor();
        $periodo = $obj->getPeriodo()->getId();
        $dias = $this->getRepo("PlaneacionAdminBundle:Dia")->getEntreSemana();
        $horas = $this->getEm()->getRepository("PlaneacionAdminBundle:HoraPeriodo")->getOrderedByPeriodo($periodo);
        $materias = $obj->getMateria();
//        ld($periodo);
//        ldd($horas);
        $horarios = array();
        foreach ($obj->getProfePeriodoHorario() as $horario) {
//                ld($horario->getId());
            /**
             * @var $horario ProfePeriodoHorario
             */
//                $extra_params['horario'][] = $horario->getHora()->getId()."_".$horario->getDia()->getId()."_".$horario->getGrupo()->getId()."_".$horario->getMateria()->getId();
            $horarios[] = array($horario->getHora()->getId(), $horario->getDia()->getId(), $horario->getGrupo()->getId(), $horario->getMateria()->getId(), $horario->getGrupo()->getNombreCompleto(), $horario->getMateria()->getClave(), $horario->getGrupo()->getAula()->getNombre());
        }
//        $html= $this->createUpdate(new ProfesorType(), $obj,$extraParams,'export');
//        ldd($horarios);
        $content = $this->renderView('PlaneacionAdminBundle:ProfesorHorario/Exportar:tabla_hora_horario.html.twig', array(
            'obj' => $obj,
            'profe' => $profe,
            'dias' => $dias,
            'materias' => $materias,
            'horas' => $horas,
            "horarios" => $horarios
        ));
//        ldd($content);
//        return new Response(
//            $content
//        );
        $pName = $obj->getPeriodo()->getAbreviado();
        $pname = str_replace("/", "-", $pName);
        return new \Symfony\Component\HttpFoundation\Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($content, array('lowquality' => false, 'viewport-size' => "1600x900", 'margin-top' => 5, 'page-size' => 'A4')),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Horario período ' . $pname . ' de ' . $profe->getNombre() . '-' . $profe->getNumeroEmpleado() . '.pdf"'
            )
        );
//        ldd($content);

    }
}
