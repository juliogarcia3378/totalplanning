<?php

namespace Core\Planeacion\AdminBundle\Repository;


use Core\ComunBundle\Util\ResultType;
use Doctrine\ORM\Mapping as ORM;

class PlanEstudioRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{
    public function obtenerPorPreferenciaProfesor($idProfe,$licenciatura, $filters=array(),$resultType=ResultType::ObjectType){
        $filters['preferenciaProfeMateria.profe']=$idProfe;
        $filters['licenciatura']=$licenciatura;
        $filters['activo']=true;
        $qb = $this->getQB(array('materias','materias.preferenciaProfeMateria'));
        return $this->filterQB($qb,$filters,$resultType);
    }
}