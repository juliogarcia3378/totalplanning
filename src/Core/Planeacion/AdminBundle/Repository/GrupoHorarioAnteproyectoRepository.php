<?php

namespace Core\Planeacion\AdminBundle\Repository;


use Core\ComunBundle\Util\ResultType;
use Core\Planeacion\AdminBundle\Entity\GrupoHorarioAnteproyecto;
use Core\Planeacion\AdminBundle\Entity\GrupoHorarioProfesorAnteproyecto;
use Core\Planeacion\AdminBundle\Entity\ProfePeriodo;
use Doctrine\ORM\Mapping as ORM;

class GrupoHorarioAnteproyectoRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{

    public function findByCriteria($filter){
        $ids=array();
        $qb = $this->getQB("aula");
        $qb->andWhere('grupoHorarioAnteproyecto.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        $qb->join('grupoHorarioAnteproyecto.grupo','grupo');
        //en horarios est?n los horarios de un grupo
        $horarios = $this->filterQB($qb,array(),ResultType::ObjectType);
        // return $horarios;
        $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($filter["grupo"]);
        $ids[$grupo->getAula()->getId()]=$grupo->getAula()->getId();
        foreach ($horarios as $horario){
            if (!array_key_exists($horario->getAula()->getId(),$ids))
            {
                $ids[$horario->getAula()->getId()]=$horario->getAula()->getId();
            }

        }
        $horarioAulas=array();

        if (count($ids)>0) {
            $qb2 = $this->getQB();
            $qb2->join('grupoHorarioAnteproyecto.hora', 'horaPeriodo')
                ->join('grupoHorarioAnteproyecto.aula', 'aula')
                ->join('horaPeriodo.periodo', 'periodo');
            $qb2->andWhere('aula.id in (:aulas)')->setParameter('aulas', $ids);
            $qb2->andWhere('horaPeriodo.periodo = :periodo')->setParameter('periodo', $filter["periodo"]);
            $qb2->andWhere('grupoHorarioAnteproyecto.grupo != :grupo')->setParameter('grupo', $filter["grupo"]);
            //aqui se encuentran los horarios de las otras aulas donde
            $horarioAulas = $this->filterQB($qb2, array(), ResultType::ObjectType);
        }
        return $result = array_merge($horarioAulas,$horarios);
        /*$qb21 = $this->getQB()
            ->join('grupoHorarioAnteproyecto.hora','horaPeriodo')
            ->join('grupoHorarioAnteproyecto.grupo','grupo')
            ->join('grupo.aula','aula')
            ->join('horaPeriodo.periodo','periodo');
        $qb21->andWhere('aula.id in (:aulas)')->setParameter('aulas',$ids);
        $qb21->andWhere('horaPeriodo.periodo = :periodo')->setParameter('periodo',$filter["periodo"]);
        $qb21->andWhere('grupoHorarioAnteproyecto.grupo != :grupo')->setParameter('grupo',$filter["grupo"]);
        //aqui se encuentran los horarios de las otras aulas donde
        $horarioAulas = array_merge($horarioAulas,$this->filterQB($qb21,array(),ResultType::ObjectType));
    }
    $qb3 = $this->getQB();
    $qb3->join('grupoHorarioAnteproyecto.grupo','grupo')
        ->join('grupoHorarioAnteproyecto.hora','horaPeriodo')
        ->join('horaPeriodo.periodo','periodo');
    $qb3->andWhere('grupoHorarioAnteproyecto.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
    $qb3->andWhere('horaPeriodo.periodo = :periodo')->setParameter('periodo',$filter["periodo"]);
    $withoutAulas= $this->filterQB($qb3,array(),ResultType::ObjectType);*/
        //   return $result = array_merge($withoutAulas,$horarioAulas);
        return $horarioAulas;
    }

    public function asignarProfesorAMateria($filter,$profesor,$periodo){
        //  ldd($data);
        $data = explode("_",$filter);
        $filter=Array();
        $filter["aula"]=$data[0]; //aula
        $filter["hora"]=$data[1]; //hora
        $filter["dia"]=$data[2]; //dia
        $filter["grupo"]=$data[4]; //grupo
        $filter["materia"]=$data[5];//materia
        $qb = $this->getQB();
        $qb->join('grupoHorarioAnteproyecto.grupo','grupo');
        $qb->andWhere('grupoHorarioAnteproyecto.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        $qb->andWhere('grupoHorarioAnteproyecto.materia = :materia')->setParameter('materia',$filter["materia"]);
        $turno_clases=$this->filterQB($qb,array(),ResultType::ObjectType);

        $profeP = $this->getRepo("PlaneacionAdminBundle:ProfePeriodo")->findBy(array("profesor"=>$profesor,
            "periodo"=>$periodo->getId()));
        if (count($profeP)>0)
            $profeP= $profeP[0];
        else {
            $profesor = $this->getRepo("PlaneacionAdminBundle:Profesor")->find($profesor);
            $profeP = new ProfePeriodo();
            $profeP->setPeriodo($periodo);
            $profeP->setProfesor( $profesor);
            $profeP->setCategoria($profesor->getCategoria());
            $this->getEntityManager()->persist($profeP);
        }

        $qb = $this->getQB();
        $qb->join('grupoHorarioAnteproyecto.profePeriodo','profePeriodo');
        $qb->andWhere('grupoHorarioAnteproyecto.materia = :materia')->setParameter('materia',$filter["materia"]);
        $qb->andWhere('grupoHorarioAnteproyecto.profePeriodo = :profePeriodo')->setParameter('profePeriodo',$profeP->getId());
        $turnos_profesor_materias=$this->filterQB($qb,array(),ResultType::ObjectType);
        /*foreach ($turnos_profesor_materias as $turno_profesor)
        {
            $this->getEntityManager()->remove($turno_profesor);
        }*/
        $this->getEntityManager()->flush();
        //
        $qb = $this->getQB();
        $qb->join('grupoHorarioAnteproyecto.profePeriodo','profePeriodo');
        $qb->andWhere('grupoHorarioAnteproyecto.profePeriodo = :profePeriodo')->setParameter('profePeriodo',$profeP->getId());
        $turnos_profesor=$this->filterQB($qb,array(),ResultType::ObjectType);
//
        $flag=false;
        foreach ($turno_clases as $turno)
            foreach ($turnos_profesor as $turno_profesor)
            {
                if ($turno_profesor->getDia()->getId()==$turno->getDia()->getId() &&
                    $turno_profesor->getHora()->getId()==$turno->getHora()->getId()
                )
                    $flag=true;
            }
        if (!$flag){
            foreach ($turno_clases as $turno)
            {
                $turno->setProfePeriodo($profeP);
                $this->getEntityManager()->persist($turno);
            }

        }
        else
            foreach ($turnos_profesor_materias as $turno_profesor)
            {
                $this->getEntityManager()->persist($turno_profesor);
            }
        $this->getEntityManager()->flush();
        return $flag;
    }

    public function eliminarProfesorAMateria($filter,$profesor,$periodo){
        //  ldd($data);
        $data = explode("_",$filter);
        $filter=Array();
        $filter["aula"]=$data[0]; //aula
        $filter["hora"]=$data[1]; //hora
        $filter["dia"]=$data[2]; //dia
        $filter["grupo"]=$data[4]; //grupo
        $filter["materia"]=$data[5];//materia
        $qb = $this->getQB();
        $qb->join('grupoHorarioAnteproyecto.grupo','grupo');
        $qb->andWhere('grupoHorarioAnteproyecto.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        $qb->andWhere('grupoHorarioAnteproyecto.materia = :materia')->setParameter('materia',$filter["materia"]);
        $turno_clases=$this->filterQB($qb,array(),ResultType::ObjectType);

        foreach ($turno_clases as $turno)
        {
            $turno->setProfePeriodo();
            $this->getEntityManager()->persist($turno);
        }
        $this->getEntityManager()->flush();
    }

    public function asignarMateria($filter){
        $data = explode("_",$filter);
        $filter=Array();
        $filter["aula"]=$data[0]; //aula
        $filter["hora"]=$data[1]; //hora
        $filter["dia"]=$data[2]; //dia
        $filter["materia"]=$data[4]; //grupo
        $filter["grupo"]=$data[5];//materia
        $qb = $this->getQB();
        $qb->join('grupoHorarioAnteproyecto.grupo','grupo');
        $qb->andWhere('grupoHorarioAnteproyecto.dia = :dia')->setParameter('dia',$filter["dia"]);
        $qb->andWhere('grupoHorarioAnteproyecto.hora = :hora')->setParameter('hora',$filter["hora"]);
        $qb->andWhere('grupoHorarioAnteproyecto.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        $qb->andWhere('grupoHorarioAnteproyecto.materia = :materia')->setParameter('materia',$filter["materia"]);
        $turno_clases=$this->filterQB($qb,array(),ResultType::ObjectType);
        //   ldd($turno_clases);
        if (count($turno_clases)>0)
            $turno_clases= $turno_clases[0];
        else{
            $profeP = new GrupoHorarioAnteproyecto();
            $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($filter["grupo"]);
            $profeP->setGrupo($grupo);
            $dia = $this->getRepo("PlaneacionAdminBundle:Dia")->find($filter["dia"]);
            $profeP->setDia($dia);

            $materia = $this->getRepo("PlaneacionAdminBundle:Materia")->find($filter["materia"]);
            $profeP->setMateria($materia);

            $aulas_esp = $this->getRepo("PlaneacionAdminBundle:AutoasignacionAula")->findAll();
            $aula = $this->getRepo("PlaneacionAdminBundle:Aula")->find($filter["aula"]);
            foreach ($aulas_esp as $room) {
                if ($room->getMateria() == $materia) {
                    $aula = $room->getAula();
                    break;
                }
            }
            $profeP->setAula($aula);

            $hora = $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->find($filter["hora"]);
            $profeP->setHora($hora);

            $this->getEntityManager()->persist($profeP);
            $this->getEntityManager()->flush();
        }

    }
    public function findAulasByGroup($filters=array(),$order=array(),$resultType=ResultType::ObjectType){
        $qb = $this->getQB();
        $qb->join('grupoHorarioAnteproyecto.aula','aula')
            ->join('grupoHorarioAnteproyecto.grupo','grupo')
            ->andWhere('grupo =:grupo')->setParameter('grupo', $filters['grupo']);
        return $this->filterQB($qb, array(), $resultType, $order);
    }

    public function eliminarMateria($filter){
        $data = explode("_",$filter);

        //  ld($data);
        $filter=Array();
        $filter["aula"]=$data[0]; //aula
        $filter["hora"]=$data[1]; //hora
        $filter["dia"]=$data[2]; //dia
        //$filter["turno"]=$data[3];//turno
        $filter["materia"]=$data[4];//materia
        $filter["grupo"]=$data[5]; //grupo
        $qb = $this->getQB();
        $qb->join('grupoHorarioAnteproyecto.grupo','grupo');
        $qb->andWhere('grupoHorarioAnteproyecto.dia = :dia')->setParameter('dia',$filter["dia"]);
        $qb->andWhere('grupoHorarioAnteproyecto.hora = :hora')->setParameter('hora',$filter["hora"]);
        $qb->andWhere('grupoHorarioAnteproyecto.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        $qb->andWhere('grupoHorarioAnteproyecto.materia = :materia')->setParameter('materia',$filter["materia"]);
        $turno_clases=$this->filterQB($qb,array(),ResultType::ObjectType);
        //   ldd($turno_clases);
        if (count($turno_clases)>0)
        {
            $this->getEntityManager()->remove($turno_clases[0]);
            $this->getEntityManager()->flush();
        }

    }

    public function buscarTurnosMateria($filter){
        $asignada=$filter["asignada"];
        $qb = $this->getQB();
        $qb->join('grupoHorarioAnteproyecto.grupo','grupo');
        $qb->andWhere('grupoHorarioAnteproyecto.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        $qb->andWhere('grupoHorarioAnteproyecto.materia = :materia')->setParameter('materia',$filter["materia"]);
        if ($asignada==false)
            $qb->andWhere('grupoHorarioAnteproyecto.profePeriodo is null');
        else
            $qb->andWhere('grupoHorarioAnteproyecto.profePeriodo is not null');
        return $this->filterQB($qb,array(),ResultType::ObjectType);


    }
    public function devolverValidos(){

        $qb = $this->getQB();

        $qb->andWhere('grupoHorarioAnteproyecto.profePeriodo is not null');

        return $this->filterQB($qb,array(),ResultType::ObjectType);


    }

    public function findFrecuenciaMateria($filter){
        $qb = $this->getQB();
        $qb->join('grupoHorarioAnteproyecto.hora','horaPeriodo');
        $qb->andWhere('horaPeriodo.periodo = :periodo')->setParameter('periodo',$filter["periodo"]);
        $qb->andWhere('grupoHorarioAnteproyecto.materia = :materia')->setParameter('materia',$filter["materia"]);
        $qb->andWhere('grupoHorarioAnteproyecto.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        return  $this->filterQB($qb,array(),ResultType::ObjectType);

    }


    public function asociarAula($grupo, $aula, $periodo)
    {
        $ngrupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($grupo);
        $naula = $this->getRepo("PlaneacionAdminBundle:Aula")->find($aula);
        $nperiodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->find($periodo);
        $qb3 = $this->getQB();
        $qb3->join('grupoHorarioAnteproyecto.grupo', 'grupo');
        $qb3->andWhere('grupoHorarioAnteproyecto.grupo = :grupo')->setParameter('grupo', $grupo)
            ->andWhere('grupoHorarioAnteproyecto.materia is null')
            ->andWhere('grupoHorarioAnteproyecto.hora is null')
            ->andWhere('grupoHorarioAnteproyecto.aula = :aula')->setParameter('aula', $aula);
        $withoutAulas = $this->filterQB($qb3, array(), ResultType::ObjectType);
        if (count($withoutAulas) == 0) {
            $nuevaentrada = new GrupoHorarioAnteproyecto();
            $nuevaentrada->setAula($naula);
            $nuevaentrada->setGrupo($ngrupo);
            $this->getEntityManager()->persist($nuevaentrada);
            $this->getEntityManager()->flush();

        } else {

        }
        return $withoutAulas;
    }

    public function asignacionDirecta()
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql = 'update grupo_horario_anteproyecto set aula=70
                  where materia in (66,67,68,16,45,266,213,243,264,265,1312);
                  update grupo_horario_anteproyecto set aula=74
                  where materia in (15,214);';

        return $connection->exec($sql);
    }
}