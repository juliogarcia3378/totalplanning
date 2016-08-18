<?php

namespace Core\MySecurityBundle\Repository;

use Core\ComunBundle\Util\ResultType;
use Core\ComunBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;
use STJ\BaseBundle\Enums\ETipoInstancia;

class UsuarioRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{
    public function listAllFiltered($filters = array(),$order=null,$resultType=ResultType::ObjectType){
        $qb = $this->getQB();
        if(array_key_exists('nombre',$filters) && $filters['nombre'] != null) {
            $param = Util::makeCanonic($filters['nombre']);
            $qb->andWhere('usuario.canonic_name like :nombre')
                ->setParameter('nombre',"%$param%")
                /*->setParameter('apellidos',"%$param%")*/;
        }
        /*if(is_array($order) && array_key_exists('nombre',$order)) {
            $order[]=array('apellidos'=>$order[1]);
        }*/
        return $this->filterQB($qb,$filters,$resultType,$order);
    }
    public function getInstances($idUser,$filters = array())
    {
        $user = $this->find($idUser);
        unset($filters['idUser']);
        $centroAdmin = $user->getTribunalSupremo();
        $r=array();
        if($centroAdmin) {
            $tipoIns = $this->getRepo('BaseBundle:TipoInstancia')->find(ETipoInstancia::CentroAdministracion);
            $r[] = array('id' => "#stj_".ETipoInstancia::CentroAdministracion . "#" . $user->getTribunalSupremo()->getId(), 'tipoInstancia' =>$tipoIns->getDenominacion(),'instancia' => $user->getTribunalSupremo()->getDenominacion());
        }
        if(count($user->getOficialia()))
        {
            $tipoIns = $this->getRepo('BaseBundle:TipoInstancia')->find(ETipoInstancia::Oficialia);
            foreach($user->getOficialia() as $oficialia) {
                $r[] = array('id' => "#oficialia_".ETipoInstancia::Oficialia . "#" . $oficialia->getId(), 'tipoInstancia' => $tipoIns->getDenominacion(), 'instancia' => $oficialia->getString());
            }
        }
        if(count($user->getJuzgado()))
        {
            $tipoIns = $this->getRepo('BaseBundle:TipoInstancia')->find(ETipoInstancia::Juzgado);
            foreach($user->getJuzgado() as $juzgado) {
                $r[] = array('id' => "#juzgado_".ETipoInstancia::Juzgado. "#" . $juzgado->getId(), 'tipoInstancia' => $tipoIns->getDenominacion(), 'instancia' => $juzgado->getString());
            }
        }
        return $r;
    }
}
