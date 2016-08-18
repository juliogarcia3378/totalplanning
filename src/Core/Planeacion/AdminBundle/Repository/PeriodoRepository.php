<?php

namespace Core\Planeacion\AdminBundle\Repository;


use Core\ComunBundle\Util\ResultType;
use Doctrine\ORM\Mapping as ORM;

class PeriodoRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{
    public function getCurrentPeriodo(){
        $mes = new \DateTime();
        $year = $mes->format('Y');
        $mes = $mes->format('n');
        $periodo = $mes/7+1;
        $qb = $this->getQB();

        $filters = array();
        $filters['anno'] = $year;
        $filters['tipoPeriodo'] = $periodo;
        $actual = $this->filterQB($qb,$filters,ResultType::FirsResult);

        return $actual;

    }

    public function prePersistNew($entity){

            $estado=$this->getRepo("PlaneacionAdminBundle:Estado")->find(1);
         $entity->setEstado($estado);
        return $entity;

    }
    public function getOrdered($filter=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB()->addOrderBy('periodo.anno','desc')->addOrderBy('periodo.tipoPeriodo','desc');
        return $this->filterQB($qb,$filter,$resultType);
    }
    public function getNotByProfe($idProfe, $filter=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB(array('profePeriodo'))->addOrderBy('periodo.anno','desc')->addOrderBy('periodo.tipoPeriodo','desc');
        $filter['profePeriodo.profesor']=$idProfe;
        $ids =  $this->filterQB($qb,$filter,ResultType::IDSType);

        if(count($ids) > 0)
            $qb = $this->getQB()->andWhere('periodo.id not in (:ids)')->setParameter('ids',$ids)->addOrderBy('periodo.anno','desc')->addOrderBy('periodo.tipoPeriodo','desc');
        else
            $qb = $this->getQB()->addOrderBy('periodo.anno','desc')->addOrderBy('periodo.tipoPeriodo','desc');
        return $this->filterQB($qb,array(),$resultType);
    }
    public function getByProfeConMateria($idProfe, $filter=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB(array('profePeriodo','profePeriodo.materia'))->addOrderBy('periodo.anno','desc')->addOrderBy('periodo.tipoPeriodo','desc');
        $filter['profePeriodo.profesor']=$idProfe;
        $r1 = $this->filterQB($qb,$filter,$resultType);

        $ids = array();
        foreach($r1 as $p)
            $ids[]=$p->getId();
        $qb = $this->getQB(array('profePeriodo','profePeriodo.historicoMateriaManual'))->addOrderBy('periodo.anno','desc')->addOrderBy('periodo.tipoPeriodo','desc');

        if(count($ids) > 0)
            $qb->andWhere('periodo.id not in (:ids)')->setParameter('ids',$ids);
        $r2 = $this->filterQB($qb,$filter,$resultType);
        return array_merge($r1,$r2);

    }

    public function findbyState($filters,$order=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB();
        $qb->join('periodo.anteproyecto', 'anteproyecto');
        $qb->join('anteproyecto.estado', 'estado')
            ->addOrderBy('periodo.anno','asc')
        ;
        $filter=array();
        if (isset($filters['estado']))
            $qb->andWhere('estado.id = :estado')->setParameter('estado',$filters['estado']);
        return $this->filterQB($qb,$filter,ResultType::ObjectType);

    }
    public function getAnteproyectos($filters=array(),$order=array(),$resultType=ResultType::ObjectType)
    {
        /*$qb = $this->getQB();
        $qb->join('periodo.anteproyecto', 'anteproyecto');
        $qb->join('anteproyecto.estado', 'estado')
            ->addOrderBy('periodo.anno','asc');
        $filter=array();
        $qb->andWhere('estado.id = :estado')->setParameter('estado', EEstado::Terminado);
        $ids= $this->filterQB($qb,$filter,ResultType::IDSType);

        if(count($ids)>0 ){
            $qb = $this->getQB();
            $qb->join('periodo.anteproyecto', 'anteproyecto');
            $qb->join('anteproyecto.estado', 'estado')
                ->addOrderBy('periodo.anno','asc');
        }
        $qb = $this->getQB()->andWhere("periodo.id not in (:ids)")->setParameter('ids', $ids);*/

        $qb = $this->getQB();
        $qb->join('periodo.anteproyecto', 'anteproyecto');
        $qb->join('anteproyecto.estado', 'estado')
            ->addOrderBy('periodo.anno','asc');
        $filter=array();
        $ids= $this->filterQB($qb,$filter,ResultType::IDSType);

        $qb = $this->getQB()->andWhere("periodo.id not in (:ids)")->setParameter('ids', $ids);

        return $this->filterQB($qb, $filters, $resultType, $order);
    }
}