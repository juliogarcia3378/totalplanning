<?php

namespace Core\Planeacion\AdminBundle\Repository;


use Core\ComunBundle\Enums\EEstado;
use Core\ComunBundle\Util\ResultType;
use Core\Planeacion\AdminBundle\Enums\ELicenciatura;
use Doctrine\ORM\Mapping as ORM;

class GrupoEstudiantesRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{
    public function getOrderedForNaming(){
        $qb = $this->getQB()
            ->addOrderBy('grupoEstudiantes.licenciatura','asc')
            ->addOrderBy('grupoEstudiantes.periodo','asc')
            ->addOrderBy('grupoEstudiantes.semestre','asc')
            ->addOrderBy('grupoEstudiantes.turno','asc')
            ->addOrderBy('grupoEstudiantes.bilingue','desc')
            ->addOrderBy('grupoEstudiantes.aulaString','asc')
        ;
        return $this->filterQB($qb);
    }

    public function getDistribucionCambios($filter=array()){
        $semestres = $this->getRepo("PlaneacionAdminBundle:Semestre")->findBy(array(), array('id' => 'ASC'));
        $turnos = $this->getRepo("PlaneacionAdminBundle:Turno")->findAll();
        $array=array();
        $filters=array();
        $periodo = $this->getRepo("PlaneacionAdminBundle:Periodo")->findbyState(array('estado' => EEstado::Elaboracion));
        if (count($periodo) > 0) {
            $periodo = $periodo[0];
        }
        $filters['periodo']=$periodo->getId();
        //semestres de derecho
        foreach ($semestres as $semestre){
            $filters["licenciatura"]=ELicenciatura::Derecho;
            $filters["semestre"]=$semestre->getId();
            foreach ($turnos as $turno){
                $filters["turno"]=$turno->getId();
               //  ld($filters);
             //   ld(self::getBySemestre($filters));
                $result = self::getBySemestre($filters);
            
            if (count($result)>0)
               $array[ELicenciatura::Derecho][$semestre->getNombre()][$turno->getNombre()]=$result;
            }
            
            }
        //semestres de criminología
        foreach ($semestres as $semestre){
            $filters["licenciatura"]=ELicenciatura::Criminologia;
            $filters["semestre"]=$semestre->getId();
            foreach ($turnos as $turno){
                $filters["turno"]=$turno->getId();
                  $result = self::getBySemestre($filters);
            
            if (count($result)>0)
               $array[ELicenciatura::Criminologia][$semestre->getNombre()][$turno->getNombre()]=$result;
            
            }}
        return $array;
    }

    public function getByPeriodo($filters=array()){
        $qb = $this->getQB();
        $qb->where('grupoEstudiantes.periodo = :periodo')->setParameter('periodo',$filters['periodo']);
        $qb->andWhere('grupoEstudiantes.paquete = false');
        $qb->andWhere('grupoEstudiantes.terceros = false')
            ->addOrderBy('grupoEstudiantes.semestre','asc');
        return $this->filterQB($qb);
    }

    public function getBySemestre($filters=array()){
         $anteproyecto =$this->getRepo("PlaneacionAdminBundle:Anteproyecto")->findBy(array('estado'=>EEstado::Elaboracion));
        $anteproyecto = $anteproyecto[0];
        $qb = $this->getQB()->addOrderBy('grupoEstudiantes.nombre','asc');
        $filter=array();
        if (isset($filters['licenciatura']))
            $filter['licenciatura']=$filters['licenciatura'];
        if (isset($filters['turno']))
            $filter['turno']=$filters['turno'];
        if (isset($filters['semestre']))
            $filter['semestre']=$filters['semestre'];
        if (isset($filters['periodo']))
            $filter['periodo']=$filters['periodo'];
        $grupos = $this->filterQB($qb,$filter,ResultType::ObjectType);
        //ld(count($grupos));
        $response = array ();
        foreach ($grupos as $key => $value) {
            $name = $value->getNombre();
            $sem = intval(substr($name, 0, 2));
            $sem = $sem - 1;
            if ($sem > 0) {
                $name = "0" . $sem . substr($name, 2);
            } else {
                $name = "_bad";
            }

            $ngrupos = $this->byPeriodoAndName($anteproyecto->getPeriodoAnterior()->getId(), $value->getNombre());
            $promo_grupos = $this->byPeriodoAndName($anteproyecto->getPeriodoAnterior()->getId(), $name);
            if (count($ngrupos) > 0) {
                if (count($promo_grupos) > 0)
                    $response[] = array("actual" => $value, "anterior" => $ngrupos[0], "promo" => $promo_grupos[0]);
                else
                    $response[] = array("actual" => $value, "anterior" => $ngrupos[0], "promo" => "");
            } else {
                if (count($promo_grupos) > 0)
                    $response[] = array("actual" => $value, "anterior" => "", "promo" => $promo_grupos[0]);
                else
                    $response[] = array("actual" => $value, "anterior" => "",  "promo" => "");
            }
        }
        return $response;
    }

    public function getMaterias($filters=array()){
        $id = $filters["grupo"];
        $periodo = $filters["periodo"];

        $qb = $this->getQB();
        $qb->join('grupo.grupo','grupo')->join('grupo.profePeriodoHorario','profePeriodoHorario');
        $qb->andWhere('profePeriodoHorario.dia = :dia')->setParameter('dia',$filters['dia_clase']);
    }

    public function getByMaterias($filters=array()){
        $qb = $this->getQB()
            ->join('grupoEstudiantes.profePeriodoHorario','profePeriodoHorario');
        $qb->join('profePeriodoHorario.hora','hora')
            ->join('hora.periodo','periodo');
        $qb->andWhere('profePeriodoHorario.materia = :materia')->setParameter('materia',$filters['materia']);
        $qb->andWhere('periodo = :periodo')->setParameter('periodo',$filters['periodo']);
        return  $this->filterQB($qb,array(),ResultType::ObjectType);

    }

    public function desAsociarAula($grupo,$aula){
        $grupo=$this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($grupo);
       if ($grupo->getAula()->getId()==$aula)
           $grupo->setAula();
        $this->getEntityManager()->persist($grupo);
        $this->getEntityManager()->flush();
    }

    public function gruposSinAula($periodo){
        $qb = $this->getQB()
        ;
        $qb->andWhere('grupoEstudiantes.periodo= :periodo')->setParameter('periodo',$periodo);
        $qb->andWhere('grupoEstudiantes.aula is null');
        return $this->filterQB($qb,array(),ResultType::ObjectType);
    }

    public function getHorario($periodo,$grupo){
        $qb = $this->getQB();
        $qb->andWhere('grupoEstudiantes= :grupo')->setParameter('grupo',$grupo);
        $qb->andWhere('grupoEstudiantes.periodo= :periodo')->setParameter('periodo',$periodo);
        return $this->filterQB($qb,array(),ResultType::ObjectType);
    }

    public function byPeriodoAndName($periodo, $nombre){
        $qb = $this->getQB();
        $qb->andWhere('grupoEstudiantes.nombre LIKE :nombre')->setParameter('nombre',$nombre);
        $qb->andWhere('grupoEstudiantes.periodo= :periodo')->setParameter('periodo',$periodo);
        return $this->filterQB($qb,array(),ResultType::ObjectType);
    }

    public function bySemestre($semestre,$periodo){
        $qb = $this->getQB();
        $qb->andWhere('grupoEstudiantes.periodo= :periodo')->setParameter('periodo',$periodo);
        $qb->andWhere('grupoEstudiantes.semestre= :semestre')->setParameter('semestre',$semestre);
        return $this->filterQB($qb,array(),ResultType::ObjectType);
    }
    
    public function bySemestreYMateria($semestre,$periodo,$materia){
        $qb = $this->getQB()
             ->join('grupoEstudiantes.licenciatura','licenciatura')
        ->join('licenciatura.planEstudio','planEstudio')
                 ->join('planEstudio.materias','materia');
        $qb->andWhere('grupoEstudiantes.periodo= :periodo')->setParameter('periodo',$periodo);
        
          $qb->andWhere('materia.id= :materia')->setParameter('materia',$materia);
                 $qb->andWhere('grupoEstudiantes.semestre= :semestre')->setParameter('semestre',$semestre);
        return $this->filterQB($qb,array(),ResultType::ObjectType);
    }

    public function getHorasPeriodo($periodo_id, $grupo_id){
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql =   'select
                  materias.frecuencia
                  from grupo_estudiantes
                  inner join (select
	                  materia.semestre as semestre,
	                  materia.plan_estudio as plan_estudio,
	                  materia.horas_extra,
	                  materia.tipo_materia as tipo,
	                  sum(materia.frecuencia_semanal) as frecuencia
	                  from materia group by materia.semestre,materia.plan_estudio,materia.horas_extra,materia.tipo_materia) as materias
	                  on materias.plan_estudio = grupo_estudiantes.plan_estudio
	                  and materias.semestre = grupo_estudiantes.semestre
	                  and materias.horas_extra = false
	                  and materias.tipo <> 2
	              inner join plan_estudio on plan_estudio.id = grupo_estudiantes.plan_estudio
                  where grupo_estudiantes.periodo = '.$periodo_id.'
                  and grupo_estudiantes.terceros=false
                  and grupo_estudiantes.id='.$grupo_id.'
                  and grupo_estudiantes.paquete=false;';

        $query = $connection->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}