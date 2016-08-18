<?php

namespace Core\Planeacion\AdminBundle\Repository;


use Core\ComunBundle\Enums\EEstado;
use Core\ComunBundle\Util\ResultType;
use Core\Planeacion\AdminBundle\Entity\GrupoHorarioAnteproyecto;
use Core\Planeacion\AdminBundle\Entity\ProfePeriodo;
use Core\Planeacion\AdminBundle\Entity\ProfePeriodoHorario;
use Doctrine\ORM\Mapping as ORM;

class ProfePeriodoHorarioRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{
    public function asignarMateria($filter){
        $data = explode("_",$filter);
        $filter=Array();
        $filter["aula"]=$data[0]; //aula
        $filter["hora"]=$data[1]; //hora
        $filter["dia"]=$data[2]; //dia
        $filter["grupo"]=$data[3]; //grupo
        $filter["materia"]=$data[4];//materia
        $qb = $this->getQB();
        $qb->join('profePeriodoHorario.grupo','grupo');
          $qb->andWhere('profePeriodoHorario.dia = :dia')->setParameter('dia',$filter["dia"]);
          $qb->andWhere('profePeriodoHorario.hora = :hora')->setParameter('hora',$filter["hora"]);
        $qb->andWhere('profePeriodoHorario.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        $qb->andWhere('profePeriodoHorario.materia = :materia')->setParameter('materia',$filter["materia"]);
        $turno_clases=$this->filterQB($qb,array(),ResultType::ObjectType);
        if (count($turno_clases)>0)
            $turno_clases= $turno_clases[0];
        else{
            $profeP = new ProfePeriodoHorario();
            $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($filter["grupo"]);
            $profeP->setGrupo($grupo);
            $dia=    $this->getRepo("PlaneacionAdminBundle:Dia")->find($filter["dia"]);
            $profeP->setDia($dia);
            if ($grupo->getAula()->getId()!=$filter["aula"]){
                $aula=    $this->getRepo("PlaneacionAdminBundle:Aula")->find($filter["aula"]);
                $profeP->setAula($aula);
            }
            $hora=   $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->find($filter["hora"]);
            $profeP->setHora($hora);
            $materia=$this->getRepo("PlaneacionAdminBundle:Materia")->find($filter["materia"]);

            $profeP->setMateria($materia);
            //$profeP->setEstado($this->getRepo("PlaneacionAdminBundle:EstadoHorario")->find(EEstadoHorario::Elaboracion));
            $this->getEntityManager()->persist($profeP);
            $this->getEntityManager()->flush();
        }

    }
    public function asignarProfesorAMateria($filter,$profesor,$periodo){
      //  ldd($data);
        $data = explode("_",$filter);
        $filter=Array();
        $filter["aula"]=$data[0]; //aula
        $filter["hora"]=$data[1]; //hora
        $filter["dia"]=$data[2]; //dia
      //  $filter["turno"]=$data[3]; //turno
        $filter["grupo"]=$data[4]; //grupo
        $filter["materia"]=$data[5];//materia
       // $filter["profesor"]=$data["profesor"];//profesor
       // $filter["periodo"]=$data["periodo"];//profesor
      //  $data["periodo"]=$periodo;
       // ld($filter);
        $qb = $this->getQB();
        $qb->join('profePeriodoHorario.grupo','grupo');
      //  $qb->andWhere('profePeriodoHorario.dia = :dia')->setParameter('dia',$filter["dia"]);
       // $qb->andWhere('profePeriodoHorario.hora = :hora')->setParameter('hora',$filter["hora"]);
        $qb->andWhere('profePeriodoHorario.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        $qb->andWhere('profePeriodoHorario.materia = :materia')->setParameter('materia',$filter["materia"]);
         $turno_clases=$this->filterQB($qb,array(),ResultType::ObjectType);
     //   ldd($turno_clases);
        if (count($turno_clases)>0)
            $turno_clases= $turno_clases[0];


        $profeP = $this->getRepo("PlaneacionAdminBundle:ProfePeriodo")->findBy(array("profesor"=>$profesor,
            "periodo"=>$periodo->getId()));
        if (count($profeP)>0)
            $profeP= $profeP[0];
        else {
           // ldd($profesor);
$profesor = $this->getRepo("PlaneacionAdminBundle:Profesor")->find($profesor);
            $profeP = new ProfePeriodo();
            $profeP->setPeriodo($periodo);
            $profeP->setProfesor( $profesor);
            $profeP->setCategoria($profesor->getCategoria());
            $this->getEntityManager()->persist($profeP);
        }

        foreach ($turno_clases as $turno)
        {
            $turno->setProfePeriodo($profeP);
            //$turno->setEstado($this->getRepo("PlaneacionAdminBundle:EstadoHorario")->find(EEstadoHorario::Aprobado));
            $this->getEntityManager()->persist($turno);
        }
        $this->getEntityManager()->flush();
        /*else{

         $profeP = new ProfePeriodoHorario();
        $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($filter["grupo"]);
                 $profeP->setGrupo($grupo);
        $dia=    $this->getRepo("PlaneacionAdminBundle:Dia")->find($filter["dia"]);
            $profeP->setDia($dia);
            if ($grupo->getAula()->getId()!=$filter["aula"]){
            $aula=    $this->getRepo("PlaneacionAdminBundle:Aula")->find($filter["aula"]);
            $profeP->setAula($aula);
            }
        $hora=   $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->find($filter["hora"]);
            $profeP->setHora($hora);
        $materia=$this->getRepo("PlaneacionAdminBundle:Materia")->find($filter["materia"]);
          //  ld($materia);
                 $profeP->setMateria($materia);
        $this->getEntityManager()->persist($profeP);
            $this->getEntityManager()->flush();
    }*/

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
    $qb->join('profePeriodoHorario.grupo','grupo');
    $qb->andWhere('profePeriodoHorario.dia = :dia')->setParameter('dia',$filter["dia"]);
    $qb->andWhere('profePeriodoHorario.hora = :hora')->setParameter('hora',$filter["hora"]);
    $qb->andWhere('profePeriodoHorario.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
    $qb->andWhere('profePeriodoHorario.materia = :materia')->setParameter('materia',$filter["materia"]);
    $turno_clases=$this->filterQB($qb,array(),ResultType::ObjectType);
    //   ldd($turno_clases);
    if (count($turno_clases)>0)
    {
        $this->getEntityManager()->remove($turno_clases[0]);
        $this->getEntityManager()->flush();
    }

}
    public function findByCriteria($filter){
        $ids=array();
        $qb = $this->getQB("aula");
        $qb->andWhere('profePeriodoHorario.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        $qb->join('profePeriodoHorario.grupo','grupo');
        //en horarios est�n los horarios de un grupo
        $horarios = $this->filterQB($qb,array(),ResultType::ObjectType);
        $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($filter["grupo"]);
        $ids[$grupo->getAula()->getId()]=$grupo->getAula()->getId();
        foreach ($horarios as $horario){
            if (!array_key_exists($horario->getAula()->getId(),$ids))
            {
                $ids[$horario->getAula()->getId()]=$horario->getAula()->getId();
            }

        }
        $horarioAulas=array();
        // ldd($ids);
        if (count($ids)>0)
        {
    $qb2 = $this->getQB();
    $qb2->join('profePeriodoHorario.hora','horaPeriodo')
        ->join('profePeriodoHorario.aula','aula')
        ->join('horaPeriodo.periodo','periodo');
    $qb2->andWhere('aula.id in (:aulas)')->setParameter('aulas',$ids);
    $qb2->andWhere('horaPeriodo.periodo = :periodo')->setParameter('periodo',$filter["periodo"]);
    $qb2->andWhere('profePeriodoHorario.grupo != :grupo')->setParameter('grupo',$filter["grupo"]);
        //aqui se encuentran los horarios de las otras aulas donde
        $horarioAulas = $this->filterQB($qb2,array(),ResultType::ObjectType);

            $qb21 = $this->getQB()->join('profePeriodoHorario.hora','horaPeriodo')->join('profePeriodoHorario.grupo','grupo')
                ->join('grupo.aula','aula') ->join('horaPeriodo.periodo','periodo');
            $qb21->andWhere('aula.id in (:aulas)')->setParameter('aulas',$ids);
            $qb21->andWhere('horaPeriodo.periodo = :periodo')->setParameter('periodo',$filter["periodo"]);
            $qb21->andWhere('profePeriodoHorario.grupo != :grupo')->setParameter('grupo',$filter["grupo"]);
            //aqui se encuentran los horarios de las otras aulas donde
            $horarioAulas = array_merge($horarioAulas,$this->filterQB($qb21,array(),ResultType::ObjectType));
    }
    $qb3 = $this->getQB();
    $qb3->join('profePeriodoHorario.grupo','grupo')
        ->join('profePeriodoHorario.hora','horaPeriodo')
        ->join('horaPeriodo.periodo','periodo');
    $qb3->andWhere('profePeriodoHorario.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
    $qb3->andWhere('horaPeriodo.periodo = :periodo')->setParameter('periodo',$filter["periodo"]);
    $withoutAulas= $this->filterQB($qb3,array(),ResultType::ObjectType);
    return $result = array_merge($withoutAulas,$horarioAulas);
}
    public function findFrecuenciaMateria($filter){
        $qb = $this->getQB();
        $qb->join('profePeriodoHorario.hora','horaPeriodo');
        $qb->andWhere('horaPeriodo.periodo = :periodo')->setParameter('periodo',$filter["periodo"]);
        $qb->andWhere('profePeriodoHorario.materia = :materia')->setParameter('materia',$filter["materia"]);
        $qb->andWhere('profePeriodoHorario.grupo = :grupo')->setParameter('grupo',$filter["grupo"]);
        return  $this->filterQB($qb,array(),ResultType::ObjectType);

    }
    public function findAulasByGroup($filters=array(),$order=array(),$resultType=ResultType::ObjectType){
      //  ldd($filters);
        $qb = $this->getQB();
        $qb->join('profePeriodoHorario.aula','aula')
            ->join('profePeriodoHorario.grupo','grupo')
            ->leftJoin('profePeriodoHorario.profePeriodo','profePeriodo')
            ->andWhere('profePeriodo.periodo =:periodo')->setParameter('periodo', $filters['periodo'])
            ->andWhere('grupo =:grupo')->setParameter('grupo', $filters['grupo']);
        return $this->filterQB($qb, array(), $resultType, $order);
    }
    public function asociarAula($grupo,$aula,$periodo){
        $ngrupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($grupo);
        $naula = $this->getRepo("PlaneacionAdminBundle:Aula")->find($aula);
        $nperiodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->find($periodo);
        $qb3 = $this->getQB();
        $qb3->join('profePeriodoHorario.grupo','grupo');
        $qb3->andWhere('profePeriodoHorario.grupo = :grupo')->setParameter('grupo',$grupo)
            ->andWhere('profePeriodoHorario.materia is null')
            ->andWhere('profePeriodoHorario.hora is null')
            ->andWhere('profePeriodoHorario.aula = :aula')->setParameter('aula',$aula);
        $withoutAulas= $this->filterQB($qb3,array(),ResultType::ObjectType);
       if (count($withoutAulas)==0)
       {
           $profePeriodoHorario = new ProfePeriodoHorario();
           $profePeriodoHorario->setAula($naula);
           $profePeriodoHorario->setGrupo($ngrupo);
           $this->getEntityManager()->persist($profePeriodoHorario);
           $this->getEntityManager()->flush();

       }else{

       }
        return $withoutAulas;
    }

    public function getByPeriodo($periodo){
        $qb = $this->getQB();
        $qb->join('profePeriodoHorario.grupo','grupo');
        $qb->join('profePeriodoHorario.hora',' horaPeriodo');
     //   $qb->andWhere('profePeriodoHorario.grupo = :grupo')->setParameter('grupo',$grupo);
        $qb->andWhere('horaPeriodo.periodo= :periodo')->setParameter('periodo',$periodo);
        return $this->filterQB($qb,array(),ResultType::ObjectType);
    }

    public function duplicarHorarios()
    {
        $em =  $this->getEntityManager();
        $propuestas = $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findAll();
        foreach ($propuestas as $prop) 
         $em->remove($prop);   
         $em->flush();
         
         $anteproyecto = $this->getAnteproyecto();
        $result =$this->turnosReferencia($anteproyecto);
        $gruposActuales = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array("periodo"=>$anteproyecto->getPeriodo()->getId()));
        $tablaIndicacion=array();
        foreach ($gruposActuales as $grupoActual){
      $tablaIndicacion= $this->duplicarHorariosGrupo($grupoActual,$result,$tablaIndicacion);
        }
        //ldd($tablaIndicacion);
    }
    
    public function restricciones($grupo){
         if (count($grupo->getProfePeriodoHorario())>0)
            return;
        if (count($this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findBy(array("grupo"=>$grupo)))>0)
            return;
    }
   
    public function getAnteproyecto(){
        $anteproyecto = $this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('estado' => EEstado::Elaboracion));
        if (count($anteproyecto)>0)
            $anteproyecto=$anteproyecto[0];
        return $anteproyecto;
    }
    
    public function getGrupoAnterior($grupo,$anteproyecto)
                {
        $grupoAnterior=$this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array("nombre"=>$grupo->getNombre(),"periodo"=>$anteproyecto->getPeriodoAnterior()));
        if (count($grupoAnterior)==0)
            return;
        return $grupoAnterior[0];
                }
      
                
 public function turnosReferencia($anteproyecto) {
        $turnos_anterior_orden=array();
        $horas_anterior_orden=array();
        $horasPeriodoAnterior = $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->findBy(array("periodo"=>$anteproyecto->getPeriodoAnterior()->getId()),array("nombre"=>"asc"));
        $iter=0;
        $turno_anterior=0;
        foreach( $horasPeriodoAnterior as $horaP)
        {
            if ($turno_anterior!=$horaP->getTurno()->getId()){
                $iter=0;
                $turno_anterior=$horaP->getTurno()->getId();
            }
            $turnos_anterior_orden[$horaP->getTurno()->getId()][$iter]=$horaP->getId();
            $horas_anterior_orden[$horaP->getId()]=$iter;
            $iter=$iter+1;
        }

        $turnos_actual_orden=array();
        $horas_actual_orden=array();
        $horasPeriodoActual = $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->findBy(array("periodo"=>$anteproyecto->getPeriodo()->getId()),array("nombre"=>"asc"));
        $turno_actual=0;
        $iter=0;
        foreach( $horasPeriodoActual as $horaP)
        {
            if ($turno_actual!=$horaP->getTurno()->getId()){
                $iter=0;
                $turno_actual=$horaP->getTurno()->getId();
            }
            $turnos_actual_orden[$horaP->getTurno()->getId()][$iter]=$horaP->getId();
            $horas_actual_orden[$horaP->getId()]=$iter;
            $iter=$iter+1;
        }
        
        return array($turnos_anterior_orden,$horas_anterior_orden,$turnos_actual_orden,$horas_actual_orden);
        }            
    
        
        public function duplicarHorariosGrupo($grupo,$referencia,$tabla_indicacion)
    {  
          
            $array=array();
         /* if (count($grupo->getProfePeriodoHorario())>0)
            return;
        if (count($this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findBy(array("grupo"=>$grupo)))>0)
            return*/;
        $anteproyecto = $this->getAnteproyecto();
        
        $periodoActual=$anteproyecto->getPeriodo();
        $grupoAnterior = $this->getGrupoAnterior($grupo, $anteproyecto);

         if (count($grupoAnterior)==0)
            return $tabla_indicacion;
         
        if ($grupoAnterior->getPlanEstudio()->getId()!=$grupo->getPlanEstudio()->getId())
            return $tabla_indicacion;

        
       
        $turnos_anterior_orden=$referencia[0];
        $horas_anterior_orden=$referencia[1];
        $turnos_actual_orden=$referencia[2];
        $horas_actual_orden=$referencia[3];
     
           $idTurno=$grupo->getTurno()->getId();
        foreach ($grupoAnterior->getProfePeriodoHorario() as $horarioRef){
            $idProfesor = $horarioRef->getProfePeriodo()->getProfesor()->getId();
            
            
            $profeP= $this->crearProfesor($idProfesor,$periodoActual);
            $this->adicionarMateriaAProfesor($profeP,$horarioRef);
            $nHorario = new GrupoHorarioAnteproyecto();
            $nHorario->setGrupo($grupo);
            $nHorario->setAula($grupo->getAula());
            $nHorario->setDia($horarioRef->getDia());
            
            if($horarioRef->getHora()->getTurno()->getId()==$grupo->getTurno()->getId())
                $nHorario->setProfePeriodo($profeP);
            
            if (array_key_exists($horarioRef->getHora()->getId(),$horas_anterior_orden))
            {
                $horaBase=$horas_anterior_orden[$horarioRef->getHora()->getId()];
                if (!array_key_exists($horaBase,$turnos_actual_orden[$idTurno]))
                {
                    continue;
                }
                $horaPeriodo = $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")
                    ->find($turnos_actual_orden[$idTurno][$horaBase]);
                $nHorario->setHora($horaPeriodo);
                $nHorario->setMateria($horarioRef->getMateria());
                //               ld("a");
               // $tabla_indicacion[]=
               $grupoHorarioAnteproyecto=$this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")
                       ->findBy(array("dia"=>$horarioRef->getDia()->getId(),"hora"=>$horaPeriodo->getId(),"grupo"=>$grupo->getId()));
              // ld(count($grupoHorarioAnteproyecto));
               if (!isset($tabla_indicacion[$horarioRef->getDia()->getId()."_".$horaPeriodo->getId()."_".$grupo->getId()])){
                $this->getEntityManager()->persist($nHorario);
                 $tabla_indicacion[$horarioRef->getDia()->getId()."_".$horaPeriodo->getId()."_".$grupo->getId()]=1;
               // $this->getEntityManager()->flush();
               }
               else
               {
                   $tabla_indicacion[$horarioRef->getDia()->getId()."_".$horaPeriodo->getId()."_".$grupo->getId()]+=1;
               }
            }
          
            //ld(count($grupoReferenciaAnterior->getProfePeriodoHorario())."     ".count($grupoActual));
        }
        $this->getEntityManager()->flush();
return $tabla_indicacion;
    }
    
    public function adicionarMateriaAProfesor($profeP,$horarioRef){
          $flag=false;
            foreach ($profeP->getMateria() as $m) {
                if ($m->getId()==$horarioRef->getMateria()->getId()){
                    $flag=true;
                    break;
                }
            }
            if ($flag==false)
                $profeP ->addMateria($horarioRef->getMateria());
            $this->getEntityManager()->persist($profeP);
        
    }
    
    public function crearProfesor($idProfesor,$periodoActual){
         $profeP = $this->getRepo("PlaneacionAdminBundle:ProfePeriodo")->findBy(array("profesor"=>$idProfesor,
                "periodo"=>$periodoActual->getId()));
            if (count($profeP)>0)
                $profeP= $profeP[0];
            else {
         $profesor = $this->getRepo("PlaneacionAdminBundle:Profesor")->find($idProfesor);
                $profeP = new ProfePeriodo();
                $profeP->setPeriodo($periodoActual);
                $profeP->setProfesor( $profesor);
                $profeP->setCategoria($profesor->getCategoria());
                $profeP->setHorasCubrir(0);
                $profeP->setHorasAsignadas(0);
                $profeP->setAntiguedad(0);
                $this->getEntityManager()->persist($profeP);
                $this->getEntityManager()->flush();
            }
                return $profeP;
    }

    public function findByMateriaYGrupo($filters){
        $materia = $filters[0];
        $grupo= $filters[1];
        $estado = $filters[2];
        $qb = $this->getQB();
        $qb->join('profePeriodoHorario.grupo','grupo');
        $qb->join('profePeriodoHorario.materia','materia');
        $qb->andWhere('profePeriodoHorario.estado = :estado')->setParameter('estado',$estado);
        $qb->andWhere('grupo = :grupo')->setParameter('grupo',$grupo);
        $qb->andWhere('materia = :materia')->setParameter('materia',$materia);
     return $this->filterQB($qb,array(),ResultType::ObjectType);
}

}
