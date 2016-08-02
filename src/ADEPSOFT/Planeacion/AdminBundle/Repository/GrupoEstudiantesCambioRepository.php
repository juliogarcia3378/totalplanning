<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Repository;


use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\Planeacion\AdminBundle\Enums\ELicenciatura;
use Doctrine\ORM\Mapping as ORM;

class GrupoEstudiantesCambioRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{

    public function getDistribucionCambios($anteproyecto){
        $semestres = $this->getRepo("PlaneacionAdminBundle:Semestre")->findAll();
        $turnos = $this->getRepo("PlaneacionAdminBundle:Turno")->findAll();
        $array=array();
        $filters=array();
        $filters['periodo']=$anteproyecto->getPeriodo()->getId();
        //semestres de derecho
        foreach ($semestres as $semestre){
            $filters["licenciatura"]=ELicenciatura::Derecho;
            $filters["semestre"]=$semestre->getId();
            foreach ($turnos as $turno){
                $filters["turno"]=$turno->getId();
                $array[ELicenciatura::Derecho][$semestre->getNombre()][$turno->getNombre()]=self::getBySemestre($filters);
            }}
        foreach ($semestres as $semestre){
            $filters["licenciatura"]=ELicenciatura::Criminologia;
            $filters["semestre"]=$semestre->getId();
            foreach ($turnos as $turno){
                $filters["turno"]=$turno->getId();
                $grupos=self::getBySemestre($filters);
                $array[ELicenciatura::Criminologia][$semestre->getNombre()][$turno->getNombre()]=$grupos;
            }}
        return $array;
    }
    public function getBySemestre($filters=array()){

        $qb = $this->getQB();
             $qb->join('grupoEstudiantesCambio.grupoAnterior', 'anterior');
                  $qb->join('grupoEstudiantesCambio.grupoActual', 'actual')
           //   $qb->join('anterior.licenciatura', 'licenciatura')
            ->addOrderBy('anterior.licenciatura','asc')
            ->addOrderBy('anterior.semestre','asc')
                  ->addOrderBy('anterior.periodo','asc')
        ;
        $filter=array();

        if (isset($filters['licenciatura']))
            $qb->andWhere('anterior.licenciatura = :licenciatura')->setParameter('licenciatura',$filters['licenciatura']);
        if (isset($filters['turno']))
            $qb->andWhere('anterior.turno = :turno')->setParameter('turno',$filters['turno']);
        if (isset($filters['semestre']))
            $qb->andWhere('anterior.semestre = :semestre')->setParameter('semestre',$filters['semestre']);
        if (isset($filters['periodo']))
        {
            $qb->andWhere('actual.periodo = :periodo')->setParameter('periodo',$filters['periodo']);

        }

        return $this->filterQB($qb,$filter,ResultType::ObjectType);


    }


    public function getByPeriodo($periodo){
        $qb = $this->getQB();
        $qb->join('grupoEstudiantesCambio.grupoAnterior', 'anterior');

        $qb->andWhere('anterior.periodo= :periodo')->setParameter('periodo',$periodo);
        return $this->filterQB($qb,array(),ResultType::ObjectType);
    }

    public function getSiguiente($rupoEstudiantesCambio){

        $cambio = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantesCambio")->findBy(array("grupoAnterior"=>$rupoEstudiantesCambio->getAnterior()));
         if (count($cambio)==0)
         {
             ld($rupoEstudiantesCambio);
         }
        $grupoAnterior = $cambio[0]->getAnterior();
        $grupoActual = $cambio[0]->getActual();


    // ld($this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->byPeriodoAndName($grupoAnterior->getPeriodo(),$grupoActual->getNombre()));

        return $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->findBy(array("nombre"=>$grupoActual->getNombre(),
                                                                                                "periodo"=>$grupoAnterior->getPeriodo()->getId()));


    }
}