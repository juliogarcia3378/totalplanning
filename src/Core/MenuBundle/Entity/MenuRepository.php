<?php

namespace Core\MenuBundle\Entity;

use Core\ComunBundle\Util\NomencladoresRepository;
use Core\ComunBundle\Util\UtilRepository2;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Yaml\Yaml;

class MenuRepository extends NomencladoresRepository
{
    public function setPermisosForRoutes($securityYml)
    {
        $file = $securityYml;
        if($securityYml == null)
            $file = __DIR__.'/../../../../app/config/security.yml';

        $menus = $this->obtenerSinRutas();
        $parsed_file = Yaml::parse($file);
        foreach($menus as $menu){
            foreach( $parsed_file['security']['access_control'] as $array)
            {
                $array['path'] = str_replace("$","/",$array['path']);
                $array['path'] .= "^";
                if($menu->getRuta() != null) {
                    $ruta = UtilRepository2::getContainer()->get("router")->getGenerator()->generate($menu->getRuta());
//                ldd(preg_match("^/login/^","/login"));
                    if (preg_match($array['path'], $ruta)) {
                        $menu->setPermiso($array['role']);
                        $this->getEntityManager()->persist($menu);
                        break;
                    }
                }
            }
        }
        $this->getEntityManager()->flush();
    }
    public function obtenerPadres($ids=true)
    {
        if($ids)
        {
            $padresArray = $this->getQB("padre")->select("distinct padre.id")->getQuery()->getScalarResult();
            $padresId=array();
            foreach($padresArray as $padre)
                $padresId[$padre['id']]=$padre['id'];
            return $padresId;
        }
        else
            return  $this->getQB()->select()->andWhere('menu.padre is null')->getQuery()->getResult();
    }
    public function obtenerHojas()
    {
        $padresArray = $this->getQB("padre")->select("distinct padre.id")->getQuery()->getScalarResult();
        $padresId=array();
        foreach($padresArray as $padre)
            $padresId[]=$padre['id'];
        if(count($padresId) > 0)
            return $this->getQB()->andWhere("menu.id not in (:padres)")->setParameters(array('padres'=>$padresId))->getQuery()->getResult();
        else
            return $this->getQB()->getQuery()->getResult();
    }
    public function obtenerMenusPadresXUsuarioLogueado()
    {
        $markedPadres = array();
        $hojas = $this->obtenerHojas();
        for($i = 0; $i < count($hojas);$i++)
        {
//            ld($hojas[$i]->getId());
            if( UtilRepository2::getContainer()->get('security.context')->isGranted($hojas[$i]->getPermiso()) &&
                $hojas[$i]->getId() != -1 &&
                !array_key_exists($hojas[$i]->getPadre()->getId(),$markedPadres) )
            {
                $markedPadres[$hojas[$i]->getPadre()->getId()] = $hojas[$i]->getPadre()->getId();
                $padre = $hojas[$i]->getPadre();
                while($padre->getId() != -1 && !array_key_exists($padre->getPadre()->getId(),$markedPadres) )
                {
                    $markedPadres[$padre->getPadre()->getId()] = $padre->getPadre()->getId();
                    $padre = $padre->getPadre();
                }
            }
        }
        return array_keys($markedPadres);
//        UtilRepository2::getContainer()->get('security.context')->isGranted()
    }
    public function obtenerSinRutas()
    {
        return $this->createQueryBuilder("t")->where("t.ruta is not null")->getQuery()->getResult();
    }
}