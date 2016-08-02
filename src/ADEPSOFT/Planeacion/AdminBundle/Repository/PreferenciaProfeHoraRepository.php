<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Repository;


use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\Planeacion\AdminBundle\Enums\EDia;
use Doctrine\ORM\Mapping as ORM;

class PreferenciaProfeHoraRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{
    public function getPreferenciasByProfe($idProfe,$filters=array(),$resultType=ResultType::ObjectType)
    {

        $qb = $this->getQB(array('dia','hora'))->andWhere('dia.id = '.EDia::Lunes_Viernes);
        $filters['profe']=$idProfe;
        $filters['ordenPreferencia']=1;
        $a1= $this->filterQB($qb,$filters,$resultType,array('hora.hora'=>'asc'));
        $filters['ordenPreferencia']=2;
        $qb1 = $this->getQB(array('dia','hora'))->andWhere('dia.id = '.EDia::Lunes_Viernes);
        $a2= $this->filterQB($qb,$filters,$resultType,array('hora.hora'=>'asc'));

        $filters['ordenPreferencia']=1;
        $qb1 = $this->getQB(array('dia','hora'))->andWhere('dia.id = '.EDia::Sabado);
        $a3= $this->filterQB($qb1,$filters,$resultType,array('hora.hora'=>'asc'));
        $filters['ordenPreferencia']=2;
        $a4= $this->filterQB($qb1,$filters,$resultType,array('hora.hora'=>'asc'));
        // ldd(array('1'=>$a1,'2'=>$a2,'4'=>$a4,'3'=>$a3));
      //  ldd(array('1'=>$a1,'2'=>$a2,'4'=>$a4,'3'=>$a3));
        return array('1'=>$a1,'2'=>$a2,'4'=>$a4,'3'=>$a3);
    }
}
