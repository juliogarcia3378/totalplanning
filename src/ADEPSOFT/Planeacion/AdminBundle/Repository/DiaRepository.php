<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Repository;


use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\Planeacion\AdminBundle\Enums\EDia;
use Doctrine\ORM\Mapping as ORM;

class DiaRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{
    public function getEntreSemana($fitlers=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB()->andWhere('dia.id >= '.EDia::Lunes.' and dia.id <='.EDia::Sabado);
        return $this->filterQB($qb,$fitlers,$resultType);
    }
}