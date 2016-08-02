<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Repository;


use ADEPSOFT\ComunBundle\Util\ResultType;
use Doctrine\ORM\Mapping as ORM;

class TurnoRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{
    public function getOrdered($filter=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB()->addOrderBy('turno.nombre','desc');
        return $this->filterQB($qb,$filter,$resultType);
    }
}