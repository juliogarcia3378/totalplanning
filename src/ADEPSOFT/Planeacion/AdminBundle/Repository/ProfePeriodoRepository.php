<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Repository;


use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\ComunBundle\Util\UtilRepository2;
use ADEPSOFT\ComunBundle\Util\UtilRepository2Config;
use ADEPSOFT\Planeacion\AdminBundle\Entity\ProfePeriodo;
use Doctrine\ORM\Mapping as ORM;

class ProfePeriodoRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{
    public function datosTabla($filters = array(),$order=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB();
        if(array_key_exists('profePeriodo.periodo',$order) && !is_array($order['profePeriodo.periodo']))
        {
            $qb->join('profePeriodo.periodo','periodo');
            $qb->andWhere('profePeriodo.categoria is not null');
            $qb->addGroupBy('profePeriodo');
            $qb->addGroupBy('periodo.anno');
            $qb->addGroupBy('periodo.tipoPeriodo');
            $qb->addOrderBy('periodo.anno','desc');
            $qb->addOrderBy('periodo.tipoPeriodo','desc');
            unset($order['profePeriodo.periodo']);
//            UtilRepository2::getSession()->set('total',false);
        }

        UtilRepository2Config::$paginate=false;
        $r =  $this->filterQB($qb,$filters,$resultType,$order);
        UtilRepository2Config::$paginate=true;
        UtilRepository2::getSession()->set('total',count($r));
        //ldd($r);
        $r = array_slice($r, UtilRepository2::getContainer()->get('request')->get('iDisplayStart'),UtilRepository2::getContainer()->get('request')->get('iDisplayLength'));
        return $r;
    }
    public function getByPeriodoMateriaProfe($idPeriodo,$idMateria,$idProfe,$filters=array(),$resutType=ResultType::FirsResult)
    {
        $qb = $this->getQB(array('historicoMateriaManual'));
        if(is_array($idMateria) and count($idMateria) > 0)
            $qb->andWhere('historicoMateriaManual.id in (:materias)')->setParameter('materias',$idMateria);
        else
            $filters['historicoMateriaManual.id']=$idMateria;
        $filters['profesor']=$idProfe;
        $filters['periodo']=$idPeriodo;
        return $this->filterQB($qb,$filters,$resutType);
    }
    public function getByPeriodoMateriaProfeAuto($idPeriodo,$idMateria,$idProfe,$filters=array(),$resutType=ResultType::FirsResult)
    {
        $qb = $this->getQB('materia');
        if(is_array($idMateria) and count($idMateria) > 0)
            $qb->andWhere('materia.id in (:materias)')->setParameter('materias',$idMateria);
        else
            $filters['materia.id']=$idMateria;
        $filters['profesor']=$idProfe;
        $filters['periodo']=$idPeriodo;
        return $this->filterQB($qb,$filters,$resutType);
    }

    public function getByPeriodo($periodo){
        $qb = $this->getQB();
    //   $qb->join('profePeriodo.periodo','periodo');
        $qb->where('profePeriodo.periodo= :periodo')->setParameter('periodo',$periodo);
        return $this->filterQB($qb,array(),ResultType::ObjectType);
    }

    public function  crearNuevosPeriodos($anterior, $actual){

       $profesPeriodoAnterior= self::getByPeriodo($anterior);

        foreach ($profesPeriodoAnterior as $profePeriodo)
        {

            $n = new ProfePeriodo();
            $n->setAntiguedad($profePeriodo->getAntiguedad());
            $n->setAsistenciaSemAnterior($profePeriodo->getAsistenciaSemAnterior());
            $n->setCategoria($profePeriodo->getCategoria());
            $n->setDescargaADMVA($profePeriodo->getDescargaADMVA());
            $n->setDescargaAnt($profePeriodo->getDescargaAnt());
            $n->setHorasAsignadas($profePeriodo->getHorasAsignadas());
            $n->setHorasCubrir($profePeriodo->getHorasCubrir());
            $n->setProfesor($profePeriodo->getProfesor());
            $n->setPeriodo($actual);
          $this->getEntityManager()->persist($n);
        }
        $this->getEntityManager()->flush();

    }


}