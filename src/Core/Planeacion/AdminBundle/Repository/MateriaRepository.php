<?php

namespace Core\Planeacion\AdminBundle\Repository;


use Core\ComunBundle\Util\ResultType;
use Core\Planeacion\AdminBundle\Enums\ETipoMateria;
use Doctrine\ORM\Mapping as ORM;

class MateriaRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{
    public function getHistoricoByProfeHorario($idProfe,$filters=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB(array('profePeriodo','profePeriodo.periodo'))
            ->addOrderBy('periodo.anno','asc')
            ->addOrderBy('periodo.tipoPeriodo','asc');
        $filters['profePeriodo.profesor'] = $idProfe;
        return $this->filterQB($qb,$filters,$resultType);
    }
    public function getByProfeYPeriodo($idProfe,$idPeriodo,$filters=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB(array('profePeriodo'));
        $filters['profePeriodo.profesor']=$idProfe;
        $filters['profePeriodo.periodo']=$idPeriodo;
        $m1 = $this->filterQB($qb,$filters,$resultType);

        $qb = $this->getQB(array('profePeriodoManual'));
        $filters['profePeriodoManual.profesor']=$idProfe;
        $filters['profePeriodoManual.periodo']=$idPeriodo;
        unset($filters['profePeriodo.profesor']);
        unset($filters['profePeriodo.periodo']);
        $m2 = $this->filterQB($qb,$filters,$resultType);

        return array('auto'=>$m1,'manual'=>$m2);
    }
    public function getHistoricoByProfeManual($idProfe,$filters=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB(array('profePeriodoManual','profePeriodoManual.periodo'))
            ->addOrderBy('periodo.anno','asc')
            ->addOrderBy('periodo.tipoPeriodo','asc');
        $filters['profePeriodoManual.profesor'] = $idProfe;
        return $this->filterQB($qb,$filters,$resultType);
    }
    public function getObligatoriasByPlanEstudio($idPlan,$filters=array(),$resultType = ResultType::ObjectType)
    {
        $filters['activo']=true;
        $filters['planEstudio']=$idPlan;
        $qb = $this->getQB()->andWhere('materia.tipoMateria=:basica or materia.tipoMateria=:libre')->setParameter('basica',ETipoMateria::Basica)->setParameter('libre',ETipoMateria::LibreEleccion);//(array('tipoMateria'=>ETipoMateria::Basica), array('materia.semestre'=>'asc','materia.clave'=>'asc'));
        $qb->addOrderBy('materia.semestre','asc');
        $qb->addOrderBy('materia.tipoMateria','desc');
        $qb->addOrderBy('materia.clave','asc');

        return $this->filterQB($qb,$filters,$resultType);
    }
    public function listTable($filters=array(),$order=array(),$resultType=ResultType::ObjectType)
    {
        $asignada=null;
        $repository=$this->getRepo("PlaneacionAdminBundle:Materia");
          /*if (isset($filters['frecuencia'])) {
                     $filters['frecuenciaSemanal']=$filters['frecuencia'];
                       unset($filters['frecuencia']);
                   }*/
               //    ldd($filters);
        if (!array_key_exists('filtro_periodo', $filters) ){
            $query = $repository->createQueryBuilder('materia');
            return $this->filterQB($query,$filters,ResultType::ObjectType, $order);
        }
        if (array_key_exists('asignada', $filters) && $filters['asignada'] != null) {
            $asignada = $filters['asignada'];
            unset($filters['asignada']);
        }

        if (array_key_exists('filtro_periodo', $filters) && $filters['filtro_periodo'] == null){
            $query = $repository->createQueryBuilder('materia');
            return $this->filterQB($query,$filters,ResultType::ObjectType, $order);
        }

        if ($asignada==1) {
            $query = $repository->createQueryBuilder('materia');

            if (array_key_exists('filtro_periodo', $filters) && $filters['filtro_periodo'] != null) {
                $query->join('materia.profePeriodoHorario', 'profePeriodoHorario');
                $query->join('profePeriodoHorario.profePeriodo', 'profePeriodo');
                $query->andWhere('profePeriodo.periodo = :filtro_periodo')->setParameter('filtro_periodo', $filters['filtro_periodo']);
            }
            if (array_key_exists('filtro_materia', $filters) && $filters['filtro_materia'] != null) {
                $query->andWhere('materia.id = :filtro_materia')->setParameter('filtro_materia', $filters['filtro_materia']);
                unset($filters['filtro_materia']);
            }
            if (isset($filters['filtro_periodo'])) {
                unset($filters['filtro_periodo']);
            }
             $query->distinct(true);
            return $this->filterQB($query,$filters,ResultType::ObjectType, $order);
        }
               if ($asignada==2){
				//   ldd($filters);
               //    ldd("2");
                   $materia=null;
                   $periodo=null;
                   $query = $repository->createQueryBuilder('materia');
                   if (array_key_exists('filtro_periodo', $filters) && $filters['filtro_periodo'] != null) {
                       $query->join('materia.profePeriodoHorario', 'profePeriodoHorario');
                       $query->join('profePeriodoHorario.profePeriodo', 'profePeriodo');
                       $query->andWhere('profePeriodo.periodo = :filtro_periodo')->setParameter('filtro_periodo', $filters['filtro_periodo']);
                   }
                /*   if (array_key_exists('filtro_materia', $filters) && $filters['filtro_materia'] != null) {
                       $query->andWhere('materia.id = :filtro_materia')->setParameter('filtro_materia', $filters['filtro_materia']);
                       $materia=$filters['filtro_materia'];
                       unset($filters['filtro_materia']);

                   }*/
                  
                   if (isset($filters['filtro_periodo'])) {
                       $periodo = $filters['filtro_periodo'];
                       unset($filters['filtro_periodo']);
                   }
                   //
                 $ids=$this->filterQB($query,$filters,ResultType::IDSType, $order,true);
                //   ldd($ids);



               $query1 = $repository->createQueryBuilder('materia');
                  /* if($periodo!=null)
                   {
                     //  $query1->join('materia.profePeriodoHorario', 'profePeriodoHorario');
                    // $query1->join('profePeriodoHorario.profePeriodo', 'profePeriodo');
                   //    $query1->andWhere('profePeriodo.periodo = :filtro_periodo')->setParameter('filtro_periodo',$periodo);
                   }
                  */ if($materia != null ){
                    //   $query1->andWhere('materia.id = :filtro_materia')->setParameter('filtro_materia',$materia);
                   }
                   $query1->andWhere('materia.id not in (:ids)')->setParameter('ids',$ids);
                   $query1->distinct(true);
                   return $this->filterQB($query1,$filters,ResultType::ObjectType, $order);
                   $query1->distinct(true);
                   return $this->filterQB($query1,$filters,ResultType::ObjectType, $order);
               }
        $query1->distinct(true);
        return $this->filterQB($query1,$filters,ResultType::ObjectType, $order);
    }
    public function obtenerOptativasSinSemestrePorPlan($idPlan, $filters=array(),$order=array(),$resultType=ResultType::ObjectType)
    {
        $filters['planEstudio']=$idPlan;
        $qb = $this->getQB()->andWhere('materia.semestre is null');
        return $this->filterQB($qb,$filters,$resultType, $order);
    }
    public function obtenerOptativasConSemestrePorPlan($idPlan, $filters=array(),$order=array(),$resultType=ResultType::ObjectType)
    {
        $filters['planEstudio']=$idPlan;
        $filters['tipoMateria']=ETipoMateria::Optativa;
        $qb = $this->getQB()->andWhere('materia.semestre is not null');
        return $this->filterQB($qb,$filters,$resultType, $order);
    }

    public function obtenerMateriasConSemestrePorPlan($idPlan, $filters=array(),$order=array(),$resultType=ResultType::ObjectType)
    {
        $filters['planEstudio']=$idPlan;
             $qb = $this->getQB('semestre')
                   ->addOrderBy('semestre.id','desc');
        return $this->filterQB($qb,$filters,$resultType, $order);
    }
    public function getByProfePreferencia($idProfe,$fitlers=array(),$resultType=ResultType::ObjectType)
    {
        $fitlers['preferenciaProfeMateria.profe']=$idProfe;
        $qb = $this->getQB('preferenciaProfeMateria');
        return $this->filterQB($qb,$fitlers,$resultType,array('preferenciaProfeMateria.ordenPreferencia'=>'asc'));
    }
    public function getActivas($filters=array())
    {
        $filters['activo']=true;
        return $this->filterObjects($filters);
    }
    public function getActivasByCarrera($idCarrera,$filters=array(),$resultType=ResultType::ObjectType)
    {
        $filters['activo']=true;
        $filters['planEstudio.carrera']=$idCarrera;
        $qb = $this->getQB(array('planEstudio'));
             $qb->innerJoin('materia.semestre', 'semestre')
        ->addOrderBy('semestre.id','desc')
              ->addOrderBy('materia.clave','desc');
        return $this->filterQB($qb,$filters,$resultType);
    }
    public function getHistoricoByProfe($idProfe,$filters=array(),$resultType=ResultType::ObjectType)
    {
//        $mhorario = $this->getHistoricoByProfeHorario($idProfe,$filters,ResultType::ObjectType);
//        $mmanual = $this->getHistoricoByProfeManual($idProfe,$filters,ResultType::ObjectType);
//        //Basandonos en que hay un profePeriodo y un profePeriodoHorario solamente por profesor podemos hacer lo siguiente
//        $mhorario->getProfePeriodoHorario()->getProfePeriodo()->getPeriodo()

    }
    public function getHorasSemanales($plan_estudio)
    {
        $filters['planEstudio']=$plan_estudio;
        $qb = $this->getQB()->andWhere('materia.semestre is not null');
        return $this->filterQB($qb,$filters,$resultType, $order);
    }
    public function byGroup($grupo){

   // //  $grupo= $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($grupo);
       // ld($grupo->getCarrera());
        $qb = $this->getQB();
        $qb->join('materia.planEstudio', 'planEstudio');
       $qb->join('planEstudio.grupoEstudiantes', 'grupo');

            $qb->andWhere('planEstudio.activo = true');
             $qb->andWhere('materia.activo = true');
            $qb->andWhere('grupo = :grupo')->setParameter('grupo', $grupo);
                $qb->andWhere('grupo.semestre = materia.semestre ');
                 $qb->andWhere('grupo.Carrera = planEstudio.Carrera ');

                 
                 $a = $this->filterQB($qb,array(),ResultType::ArrayType);
        return $this->filterQB($qb,array(),ResultType::ArrayType);
    }
}
