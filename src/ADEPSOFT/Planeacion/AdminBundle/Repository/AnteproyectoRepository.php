<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Repository;


use ADEPSOFT\ComunBundle\Enums\EEstado;
use ADEPSOFT\ComunBundle\Util\ResultType;
use Doctrine\ORM\Mapping as ORM;

class AnteproyectoRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{
    public function findbyState($filters = array(), $order = array(), $resultType = ResultType::ObjectType)
    {
        $qb = $this->getQB();
        $qb->join('anteproyecto.periodo', 'anterior');
        $qb->join('grupoEstudiantesCambio.grupoActual', 'actual')
            //   $qb->join('anterior.licenciatura', 'licenciatura')
            ->addOrderBy('anterior.licenciatura', 'asc')
            ->addOrderBy('anterior.semestre', 'asc')
            ->addOrderBy('anterior.periodo', 'asc');
        $filter = array();

        if (isset($filters['licenciatura']))
            $qb->andWhere('anterior.licenciatura = :licenciatura')->setParameter('licenciatura', $filters['licenciatura']);
        if (isset($filters['turno']))
            $qb->andWhere('anterior.turno = :turno')->setParameter('turno', $filters['turno']);
        if (isset($filters['semestre']))
            $qb->andWhere('anterior.semestre = :semestre')->setParameter('semestre', $filters['semestre']);
        if (isset($filters['periodo'])) {
            $qb->andWhere('actual.periodo = :periodo')->setParameter('periodo', $filters['periodo']);

        }

        return $this->filterQB($qb, $filter, ResultType::ObjectType);

    }
    
    
    public function publicarAnteproyecto(){
        $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
        if (count($periodo) > 0) 
            $periodo = $periodo[0];
         $profePeriodoHorarios= $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->getByPeriodo($periodo);
         
         foreach ($profePeriodoHorarios as $profePeriodoAntep) {
             $this->getEntityManager()->remove($profePeriodoAntep);
         }
           $this->getEntityManager()->flush();
           //eliminar los horarios generados para este periodo
   
       
             $profePeriodoMaterias = array();
               $candidatos= $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")
                     ->devolverValidos();
              // ldd($candidatos);
               $materias=array();
                 foreach ($candidatos as $profePeriodoAntep) {
                     $materias[$profePeriodoAntep->getMateria()->getId()]=$profePeriodoAntep->getMateria();
             $profePeriodoHorario = new \ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodoHorario();
             $profePeriodoHorario->setAula($profePeriodoAntep->getAula());
             $profePeriodoHorario->setDia($profePeriodoAntep->getDia());
            // $profePeriodoHorario->setEstado($this->getRepo("PlaneacionAdminBundle:EstadoHorario")->
           //                  find(\ADEPSOFT\Planeacion\AdminBundle\Enums\EEstadoHorario::Aprobado));
             $profePeriodoHorario->setGrupo($profePeriodoAntep->getGrupo());
             $profePeriodoHorario->setHora($profePeriodoAntep->getHora());
             $profePeriodoHorario->setMateria($profePeriodoAntep->getMateria());
             $profePeriodo=$profePeriodoAntep->getProfePeriodo();
             
             $flag=false;
             foreach ($profePeriodo->getMateria() as $m) {
                 if ($m->getId()==$profePeriodoAntep->getMateria()->getId())
                     $flag=true;
             }
             if ($flag==false){
             $profePeriodo ->addMateria($profePeriodoAntep->getMateria());
            
              $this->getEntityManager()->persist($profePeriodo);
              ld($profePeriodo->getId());
             }
              $profePeriodoHorario->setProfePeriodo($profePeriodoAntep->getProfePeriodo());
             $this->getEntityManager()->persist($profePeriodoHorario);
             $profePeriodoMaterias[$profePeriodoAntep->getProfePeriodo()->getId()]["profePeriodo"]=$profePeriodoAntep->getProfePeriodo();
             $profePeriodoMaterias[$profePeriodoAntep->getProfePeriodo()->getId()]["materia"][$profePeriodoAntep->getMateria()->getId()]=$profePeriodoAntep->getMateria();
                 
                 
               
                 }
        $this->getEntityManager()->flush();
        $filter = array();
    }
    public function eliminarAnteproyecto()
    {
        $anteproyecto = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('estado' => EEstado::Elaboracion));
        if (count($anteproyecto) > 0)
            $anteproyecto = $anteproyecto[0];
        //eliminar grupos de cambios
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findAll();
        foreach ($grupos as $grupo)
            $this->getEntityManager()->remove($grupo);

        //eliminar grupos
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array('periodo' => $anteproyecto->getPeriodo()->getId()));
        foreach ($grupos as $grupo)
            $this->getEntityManager()->remove($grupo);

        //eliminar Horarios
        $horarios = $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->findBy(array('hora'=>null));
        $periodo =$anteproyecto->getPeriodo();

        foreach ($horarios as $horario)
            $this->getEntityManager()->remove($horario);

        $horarios = $this->getRepo("PlaneacionAdminBundle:ProfePeriodoHorario")->getByPeriodo($periodo->getId());

        foreach ($horarios as $horario)
            $this->getEntityManager()->remove($horario);

        $horas = $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->findBy(array('periodo' => $periodo->getId()));
        foreach ($horas as $hora)
            $this->getEntityManager()->remove($hora);

        $this->getEntityManager()->remove($anteproyecto);
        $this->getEntityManager()->flush();
    }

    function getSIASEInput($group_id)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql =   'select
                  grupo_estudiantes.nombre_completo as grupo,
                  hora_periodo.nombre as hora,
                  dia.nombre as dia,
                  profesor.numero_empleado as profe,
                  materia.clave as materia,
                  aula.nombre as aula
                  from grupo_horario_anteproyecto
                  inner join materia on materia.id = grupo_horario_anteproyecto.materia
                  inner join aula on aula.id = grupo_horario_anteproyecto.aula
                  inner join grupo_estudiantes on grupo_estudiantes.id = grupo_horario_anteproyecto.grupo_estudiantes
                  inner join profe_periodo on profe_periodo.id = grupo_horario_anteproyecto.profe_periodo
                  inner join profesor on profesor.id = profe_periodo.profesor
                  inner join dia on dia.id = grupo_horario_anteproyecto.dia
                  inner join hora_periodo on hora_periodo.id = grupo_horario_anteproyecto.hora_periodo
                  where grupo_estudiantes.id = '.$group_id.'
                  order by materia.clave';

        $query = $connection->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /*public function crearNuevosGrupos($periodoAnterior, $periodoActual, $anteproyecto)
    {
        $grupos = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array('periodo' => $periodoAnterior));
        
        if (count($grupos) == 0)
            throw new AnteProyectoException("No hay grupos asociados al per&iacute;odo anterior.");
        $periodoActual = $this->getRepo("PlaneacionAdminBundle:Periodo")->find($periodoActual);
      //  ldd($periodoActual);
        foreach ($grupos as $grupo) {
            if ($grupo->getSemestre()->getId() == 10 || $grupo->getSemestre()->getId() == 11)
                continue;
            $newg = new GrupoEstudiantes();
            $newg->setPeriodo($periodoActual);
            $newg->setAula($grupo->getAula());
            $newg->setBilingue($grupo->getBilingue());
            $newg->setCampus($grupo->getCampus());
            $newg->setPaquete($grupo->getPaquete());
            $newg->setPlanEstudio($grupo->getPlanEstudio());
            $newg->setLicenciatura($grupo->getLicenciatura());
            $newg->setNivel($grupo->getNivel());
            $newg->setNombre($grupo->getNombre());
            $newg->setSemestre($this->getRepo("PlaneacionAdminBundle:Semestre")->find($grupo->getSemestre()->getId() + 1));
            $newg->setTerceros($grupo->getTerceros());
            $newg->setTurno($grupo->getTurno());
            $this->getEntityManager()->persist($newg);
        }
        $this->getEntityManager()->flush();
    }*/
}