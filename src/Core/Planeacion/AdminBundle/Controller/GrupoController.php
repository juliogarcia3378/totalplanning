<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;

class GrupoController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\GrupoType';
    protected $textProperty = 'nombre';
    protected $view = "PlaneacionAdminBundle:Grupo:grupo_horario_crud.html.twig";
    protected $exportTwigExcel = '@Comun/architecture/components/CRUD/export_xls/export.html.twig';
    protected $tableModelService = 'planeacion.admin.grupo.tm';
    protected $exportFileName = 'Grupos';



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
            $obj = $this->getEm()->getRepository("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array("id" => $id, "periodo" => $periodo));
            if ($obj != null)
                foreach ($obj[0]->getProfePeriodoHorario() as $horario) {
                    if ($horario->getProfeperiodo()!=null)
                    if ($horario->getAula()!=null)
                        $horarios[] = array(
                            $horario->getHora()->getId(),
                            $horario->getDia()->getId(),
                            $horario->getGrupo()->getId(),
                            $horario->getMateria()->getId(),


                            $horario->getProfeperiodo()->getProfesor()->getNombreNumEmpleado(),
                            $horario->getMateria()->getNombre(),
                            $horario->getAula()->getNombre());
                    else
                        $horarios[] = array(
                            $horario->getHora()->getId(),
                            $horario->getDia()->getId(),
                            $horario->getGrupo()->getId(),
                            $horario->getMateria()->getId(),

                            $horario->getProfeperiodo()->getProfesor()->getNombreNumEmpleado(),
                            $horario->getMateria()->getNombre(),
                            $horario->getGrupo()->getAula()->getNombre());

                    /*   $horarios[] = array(
                           $horario->getHora()->getId(),
                           $horario->getDia()->getId(),
                           $horario->getGrupo()->getId(),
                           $horario->getMateria()->getId(),
                           $horario->getProfeperiodo()->getProfesor()->getNombreNumEmpleado(),
                           $horario->getMateria()->getNombre());*/
                }
        }
        if (count($horarios > 0))
            $script = $this->getParameter('disableScripts');
//        ldd($script);
        return $this->render("@PlaneacionAdmin/Grupo/tabla_hora_horario.html.twig", array("horarios" => $horarios, "horas" => $horas, 'dias' => $dias, 'disableScripts' => $script));
    }

    public function exportarHorarioHtmlAction()
    {
        return null;
    }

    public function exportarHorarioAction()
    {
        $id = $this->getParameter('id');
        $obj = $this->getEm()->find("PlaneacionAdminBundle:GrupoEstudiantes", $this->getParameter('id'));
        $gname = $obj->getNombre();
        $periodo = $obj->getPeriodo()->getId();
        $period = $obj->getPeriodo()->getNombre();
        $dias = $this->getRepo("PlaneacionAdminBundle:Dia")->getEntreSemana();
        $horas = $this->getEm()->getRepository("PlaneacionAdminBundle:HoraPeriodo")->getOrderedByPeriodo($periodo);
//        ld($periodo);
//        ldd($horas);
        $gdata = array("name" => $gname, "period" => $period);

        $horarios = array();

        if ($id != '') {
            $obj = $this->getEm()->getRepository("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array("id" => $id, "periodo" => $periodo));
            if ($obj != null)
                foreach ($obj[0]->getProfePeriodoHorario() as $horario) {
                    $horarios[] = array($horario->getHora()->getId(),
                        $horario->getDia()->getId(),
                        $horario->getGrupo()->getId(),
                        $horario->getMateria()->getId(),
                        $horario->getProfeperiodo()->getProfesor()->getNombreNumEmpleado(), $horario->getMateria()->getNombre());
                }
        }
        if (count($horarios > 0))
            $script = $this->getParameter('disableScripts');
        //  return $this->render("@PlaneacionAdmin/Grupo/Exportar/tabla_hora_horario.html.twig",array("horarios"=>$horarios,"horas"=>$horas,'dias'=>$dias,'disableScripts'=>$script));
        $content = $this->renderView("@PlaneacionAdmin/Grupo/Exportar/tabla_hora_horario.html.twig", array("gdata" => $gdata, "horarios" => $horarios, "horas" => $horas, 'dias' => $dias, 'disableScripts' => $script));

        return new \Symfony\Component\HttpFoundation\Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($content, array('lowquality' => false, 'viewport-size' => "1600x900", 'margin-top' => 5, 'page-size' => 'A4')),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Horario ' . $gname . '_' . $period . '.pdf"'
            )
        );
//        ldd($content);

    }
}
