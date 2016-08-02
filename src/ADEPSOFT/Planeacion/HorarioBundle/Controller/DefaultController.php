<?php

namespace Adepsoft\Planeacion\HorarioBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;

class DefaultController extends MyCRUDController
{
    public function indexAction()
    {
      /*  $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array('periodo' => 3));
        $periodoActual = $this->getRepo("PlaneacionAdminBundle:Periodo")->find(26);
        foreach ($grupos as $grupo) {
            if ($grupo->getSemestre()->getId()==10 ||$grupo->getSemestre()->getId()==11)
                continue;
        $newg = new GrupoEstudiantes();
            $newg->setPeriodo($periodoActual);
            $newg->setAula($grupo->getAula());
            $newg->setBilingue($grupo->getBilingue());
            $newg->setCampus($grupo->getCampus());
            $newg->setLicenciatura($grupo->getLicenciatura());
            $newg->setNivel($grupo->getNivel());
            $newg->setNombre($grupo->getNombre());
            $newg->setSemestre( $this->getRepo("PlaneacionAdminBundle:Semestre")->find($grupo->getSemestre()->getId()+1));
            $newg->setTerceros($grupo->getTerceros());
            $newg->setTurno($grupo->getTurno());
            $this->getEm()->persist($newg);

            $grupoCambio = new GrupoEstudiantesCambio();
            $grupoCambio->setAnterior($grupo);
            $grupoCambio->setPeriodo($periodoActual);
            $grupoCambio->setActual($newg);
            $this->getEm()->persist($grupoCambio);
        }
        $this->getEm()->flush();

        die;*/
        $aulas = $this->getRepo("PlaneacionAdminBundle:Aula")->findBy(array(), array('capacidad' => 'desc'));
        $array = array();

        foreach ($aulas as $aula) {
            if (!isset($array[$aula->getCapacidad()]))
                $array[$aula->getCapacidad()] = array();
            $array[$aula->getCapacidad()][] = $aula;
        }

        $semestresGrupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->getDistribucionCambios();
            //ldd($semestresGrupos);
        $turnos = $this->getRepo("PlaneacionAdminBundle:Turno")->findAll();
        return $this->render('ComunBundle:architecture:components/AsignacionAulaCRUD/inicio_cambios.html.twig', array('aulas' => $array, 'licenciaturas' => $semestresGrupos, 'turnos' => $turnos, 'disableScripts' => true));
    }
}
