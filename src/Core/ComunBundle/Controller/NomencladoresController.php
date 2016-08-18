<?php

namespace Core\ComunBundle\Controller;

use Core\ComunBundle\Util\UtilRepository2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NomencladoresController extends Controller
{

    protected $entity = "ComunBundle:Bufete";
    public function readAction()
    {
        $em = UtilRepository2::getEntityManager();
        $repo = $this->getDoctrine()->getRepository("BaseBundle:Litigante");
        $tramite = $repo->obtenerXEscritoDemanda(18);
        ldd($tramite);
//        $this->get('comunes.motorgtr')->registrarTramite($tramite);
//        $em->flush();
//        $em->persist($tramite);
//        $em->flush();
        die('paco');
//        $this->parameters = UtilRepository2::createFiltersFromRequest($this->getRequest());
//        $method = $this->method;
//        $result = $repo->$method($this->parameters);
//        return new \Symfony\Component\HttpFoundation\Response(json_encode($result));
//        $obj = $repo->generateEnumFromCollection($repo->filterObjects(array('tipoEstado'=> \Core\ComunBundle\Enums\ETipoEstado::Tramite)),'EEstadoTramite');
//        $obj = $repo->generateEnumToEntity();
//        $var['total']= UtilRepository2::getSession()->get('total');
//        ld($table);
//        ldd(\Core\ComunBundle\Util\UtilRepository2::getEntityManager()->getRepository('ComunBundle:'.$table)->filterObjects());
//        ldd(\Core\BiomexpressServicesBundle\Manager\BiomexpressServiceManager::authenticate(1, 1));
//       ldd($obj);
    }
}
