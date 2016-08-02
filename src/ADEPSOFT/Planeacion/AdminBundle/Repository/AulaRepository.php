<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Repository;


use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\ComunBundle\Util\UtilRepository2Config;
use Doctrine\ORM\Mapping as ORM;

class AulaRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{
    public function listTable($filters=array(),$order=array(),$resultType=ResultType::ObjectType)
    {
        if(count($order) == 0)
            $order['id'] ='asc';
        return $this->filtroContexto($filters,$order,$resultType);
    }

    protected function filtroContexto(&$filters,$order,$resultType=ResultType::ObjectType){
        $ocupado=true;
        $r =array();
        $filtered= false;

        if(array_key_exists('libre_ocupado',$filters) && $filters['libre_ocupado'] != null){
            if($filters['libre_ocupado']==1)
                $ocupado=false;
            unset($filters['libre_ocupado']);
        }

        $qb = $this->getQB();

        $joined = false;

        if(array_key_exists('filtro_periodo',$filters) && $filters['filtro_periodo'] != null ){

            $qb->join('aula.grupo','grupo')->join('grupo.profePeriodoHorario','profePeriodoHorario')->join('profePeriodoHorario.profePeriodo','profePeriodo')
                ->andWhere('profePeriodo.periodo =:periodo')->setParameter('periodo', $filters['filtro_periodo']);
            unset($filters['filtro_periodo']);
            $joined = true;
        }

        if(array_key_exists('hora_clase',$filters) &&  $filters['hora_clase'] != null &&  $filters['hora_clase'] != "" ){
            if(!$joined)
                $qb->join('aula.grupo','grupo')->join('grupo.profePeriodoHorario','profePeriodoHorario');
            $qb->join('profePeriodoHorario.hora','hora');
            $qb->andWhere('hora.nombre = :hora')->setParameter('hora',$filters['hora_clase']);
            unset($filters['hora_clase']);
        }
        if(array_key_exists('dia_clase',$filters)  &&  $filters['dia_clase'] != null &&  $filters['dia_clase'] != ""){
            if(!$joined)
                $qb->join('aula.grupo','grupo')->join('grupo.profePeriodoHorario','profePeriodoHorario');
            $qb->andWhere('profePeriodoHorario.dia = :dia')->setParameter('dia',$filters['dia_clase']);
            unset($filters['dia_clase']);
        }
        if(!$ocupado)
        {
            $tmp = UtilRepository2Config::$paginate;
            UtilRepository2Config::$paginate=false;
            $r = $this->filterQB($qb, array(), ResultType::IDSType);
            UtilRepository2Config::$paginate=$tmp;
            $filtered=true;
        }
        else
            $qb->distinct(true);
        if(!$filtered) {
            $r = $this->filterQB($qb, $filters, $resultType, $order);
        }
        else{
            if(count($r)>0 ){
                $qb = $this->getQB()->andWhere("aula.id not in (:ids)")->setParameter('ids',$r);
                $r = $this->filterQB($qb, $filters, $resultType, $order);
            }
            else
            {
                $qb = $this->getQB();
                $r = $this->filterQB($qb, $filters, $resultType, $order);
            }

        }
//        $rf = $r;
//        if(count($rf) > 0) {
////            $rf = $this->obtenerXArrayId($rf, $resultType);
//            UtilRepository2::getSession()->set('finishedTable', false);
//            UtilRepository2::getSession()->set('total', count($rf));
//            $rf = array_slice($rf, UtilRepository2::getContainer()->get('request')->get('iDisplayStart'), UtilRepository2::getContainer()->get('request')->get('iDisplayLength'));
//            return $rf;
//        }
//        else {
//            UtilRepository2::getSession()->set('total', 0);
//            return array();
//        }
        return $r;
    }

    function getGroupsInClassRoom($periodo_id, $aula_id)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql =   'select
                  --aula.id as aula_id,
                  --aula.nombre,
                  --aula.capacidad,
                  grupo_estudiantes.id as grupo_id,
                  grupo_estudiantes.nombre_completo,
                  grupo_estudiantes.turno,
                  grupo_estudiantes.nivel,
                  plan_estudio.nombre as plan_estudio,
                  plan_estudio.licenciatura as carrera,
                  grupo_estudiantes.semestre,
                  grupo_estudiantes.terceros,
                  grupo_estudiantes.bilingue,
                  grupo_estudiantes.enlinea,
                  materias.frecuencia
                  from aula
                  inner join grupo_estudiantes on grupo_estudiantes.aula = aula.id
                  inner join (select
	                  materia.semestre as semestre,
	                  materia.plan_estudio as plan_estudio,
	                  sum(materia.frecuencia_semanal) as frecuencia
	                  from materia
	                  where materia.horas_extra = false
	                  and materia.tipo_materia <> 2
	                  group by materia.semestre, materia.plan_estudio) as materias
	                  on materias.plan_estudio = grupo_estudiantes.plan_estudio
	                  and materias.semestre = grupo_estudiantes.semestre
	              inner join plan_estudio on plan_estudio.id = grupo_estudiantes.plan_estudio
                  where grupo_estudiantes.periodo = '.$periodo_id.'
                  and aula.id = '.$aula_id.'
                  and grupo_estudiantes.terceros=false
                  and grupo_estudiantes.paquete=false
                  group by
                  --aula.id,
                  --aula.nombre,
                  --aula.capacidad,
                  grupo_estudiantes.id,
                  grupo_estudiantes.nombre_completo,
                  grupo_estudiantes.turno,
                  plan_estudio.nombre,
                  plan_estudio.licenciatura,
                  materias.frecuencia,
                  grupo_estudiantes.bilingue,
                  grupo_estudiantes.terceros,
                  grupo_estudiantes.semestre,
                  grupo_estudiantes.enlinea,
                  grupo_estudiantes.nivel
                  order by grupo_estudiantes.turno;';

        $query = $connection->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getAvailableClassRooms($periodo_id)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql =   'select
                  aula.capacidad as capacidad
                  from grupo_estudiantes
                  inner join aula on aula.id = grupo_estudiantes.aula
                  where aula.enlinea = false
                  and aula.activa = true
                  and grupo_estudiantes.semestre = 10
                  and grupo_estudiantes.periodo = '.$periodo_id.'
                  group by aula.id';

        $query = $connection->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}