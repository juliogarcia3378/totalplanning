<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Repository;


use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\Planeacion\AdminBundle\Enums\EDia;
use Doctrine\ORM\Mapping as ORM;

class HoraRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{
    public function getLunesViernes($filters=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB(array('dia'))->andWhere('dia.id >= '.EDia::Lunes.' and dia.id <'.EDia::Sabado);
        return $this->filterQB($qb,$filters,$resultType,array('hora.hora'=>'asc'));
    }
    public function getSabado($filters=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB('dia')->andWhere('dia.id ='.EDia::Sabado);
        return $this->filterQB($qb,$filters,$resultType,array('hora.hora'=>'asc'));
    }
    public function getPreferenciasByProfe($idProfe,$filters=array(),$resultType=ResultType::ObjectType)
    {

        $qb = $this->getQB(array('dia','preferenciaProfehora'))->andWhere('dia.id >= '.EDia::Lunes.' and dia.id <'.EDia::Sabado);
        $filters['preferenciaProfehora.profe']=$idProfe;
        $filters['preferenciaProfehora.ordenPreferencia']=1;
        $a1= $this->filterQB($qb,$filters,$resultType,array('hora.hora'=>'asc'));
        $filters['preferenciaProfehora.ordenPreferencia']=2;
        $a2= $this->filterQB($qb,$filters,$resultType,array('hora.hora'=>'asc'));
        $qb1 = $this->getQB(array('dia','preferenciaProfehora'))->andWhere('dia.id = '.EDia::Sabado);

        $filters['preferenciaProfehora.profe']=$idProfe;
        $filters['preferenciaProfehora.ordenPreferencia']=1;
        $a3= $this->filterQB($qb1,$filters,$resultType,array('hora.hora'=>'asc'));
        $filters['preferenciaProfehora.ordenPreferencia']=2;
        $a4= $this->filterQB($qb1,$filters,$resultType,array('hora.hora'=>'asc'));
       // ldd(array('1'=>$a1,'2'=>$a2,'4'=>$a4,'3'=>$a3));
        return array('1'=>$a1,'2'=>$a2,'4'=>$a4,'3'=>$a3);
    }
}