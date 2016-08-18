<?php

namespace Core\Planeacion\AdminBundle\Repository;


use Core\ComunBundle\Util\ResultType;
use Core\Planeacion\AdminBundle\Enums\EDia;
use Doctrine\ORM\Mapping as ORM;

class DiaRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{
    public function getEntreSemana($fitlers=array(),$resultType=ResultType::ObjectType)
    {
        $qb = $this->getQB()->andWhere('dia.id >= '.EDia::Lunes.' and dia.id <='.EDia::Sabado);
        return $this->filterQB($qb,$fitlers,$resultType);
    }
}