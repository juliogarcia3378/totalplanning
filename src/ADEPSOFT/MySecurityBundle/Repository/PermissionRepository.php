<?php

namespace ADEPSOFT\MySecurityBundle\Repository;

use ADEPSOFT\ComunBundle\Util\ResultType;
use Doctrine\ORM\Mapping as ORM;

class PermissionRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{
    public function getByRoles($idRoles,$filters = array(),$order=null,$resultType=ResultType::IDSType){
        $qb = $this->getQB('grupos');
        if(count($idRoles) > 0)
        $filters['grupos.id']=array('in',$idRoles);
        $permsID =  $this->filterQB($qb,$filters,$resultType,$order);
        return array_unique($permsID);
    }
    public function getByUsuario($idUser,$filters = array(),$order=null,$resultType=ResultType::IDSType){
        $qb = $this->getQB('usuarios');
        $filters['usuarios.id']=$idUser;
        $permsID =  $this->filterQB($qb,$filters,$resultType,$order);
        return array_unique($permsID);
    }
}