<?php

namespace Core\MenuBundle\Controller;

use Core\ComunBundle\Controller\BaseController;
use Core\MenuBundle\Entity\Menu;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController
{
    public function indexAction(Request $request)
    {
//        ldd($this->getEm()->getRepository("BaseBundle:EventoCalendario")->obtenerEventosANotificar());
        die(1);
        return $this->render("CoreMenuBundle:Default:index.html.twig");
    }
    public function copyNodeAction(Request $request)
    {

        $nodeId = $request->request->get("node");
        $parentId = $request->request->get("parent");
        $em = $this->get("doctrine.orm.entity_manager");
        $repo = $em->getRepository("CoreMenuBundle:Menu");

        if(is_numeric($nodeId)) {
            $node = $repo->find($nodeId);
            $newNode = new Menu();
            $newNode->setDenominacion($node->getDenominacion());
            $newNode->setRuta($node->getRuta());
            $newNode->setPermiso($node->getPermiso());
            if(is_numeric($parentId)) {
                $parent = $repo->find($parentId);
                $newNode->setPadre($parent);
            }
            $em->persist($newNode);
            $em->flush();
            return new JsonResponse(array("success"=>true,"id"=>$newNode->getId()));
        }
        return new JsonResponse(array("success"=>false));
    }
    public function createNodeAction(Request $request)
    {
        try {
            $em = $this->get("doctrine.orm.entity_manager");

            $denominacion = $request->request->get("denominacion");
            $ruta = $request->request->get("ruta");
            $id = $request->request->get("id");

            $parentId = $request->request->get("parent");
            $repo = $em->getRepository("CoreMenuBundle:Menu");
            $menu = null;
            if($id !=null)
                $menu = $repo->find($id);
            else
                $menu = new Menu();
            $menu->setDenominacion($denominacion);
            $menu->setRuta($ruta);
            if($parentId != null && is_numeric($parentId) && $parentId != $id)
                $menu->setPadre($repo->find($parentId));

            $em->persist($menu);
            $em->flush();
            return new JsonResponse(array("success" => true,"id"=>$menu->getId()));
        }
        catch(\Exception $e)
        {
            throw $e;
            return new JsonResponse(array("success" => false));
        }
    }
//    public function renameNodeAction(Request $request)
//    {
//
//        $nodeId = $request->request->get("node");
//        $newName = $request->request->get("newName");
//        $em = $this->get("doctrine.orm.entity_manager");
//        $repo = $em->getRepository("CoreMenuBundle:Menu");
//
//        if(is_numeric($nodeId)) {
//            $node = $repo->find($nodeId);
//            $node->setDenominacion($newName);
//            $em->persist($node);
//            $em->flush();
//            return new JsonResponse(array("success"=>true));
//        }
//        return new JsonResponse(array("success"=>false));
//    }
    public function deleteNodeAction(Request $request)
    {

        $nodeId = $request->request->get("node");
        $em = $this->get("doctrine.orm.entity_manager");
        $repo = $em->getRepository("CoreMenuBundle:Menu");

        if(is_numeric($nodeId)) {
            $node = $repo->find($nodeId);
            $em->remove($node);
            $em->flush();
            return new JsonResponse(array("success"=>true));
        }
        return new JsonResponse(array("success"=>false));
    }
    public function moveNodeAction(Request $request)
    {

        $nodeId = $request->request->get("node");
        $parentId = $request->request->get("parent");
        $em = $this->get("doctrine.orm.entity_manager");
        $repo = $em->getRepository("CoreMenuBundle:Menu");

        $parent=null;
        if(is_numeric($nodeId)) {
            $node = $repo->find($nodeId);
            if(is_numeric($parentId))
              $parent = $repo->find($parentId);
            $node->setPadre($parent);
            $em->persist($node);
            $em->flush();
            return new JsonResponse(array("success"=>true));
        }
        return new JsonResponse(array("success"=>false));
    }
    public function getNodeAction(Request $request)
    {
        $nodeId = $request->request->get("node");
        $em = $this->get("doctrine.orm.entity_manager");
        $repo = $em->getRepository("CoreMenuBundle:Menu");
        $node = $repo->find($nodeId);
        return new JsonResponse(array("success"=>true,"denominacion"=>$node->getDenominacion(),"ruta"=>$node->getRuta(),"id"=>$node->getId()));
    }
    public function config2Action()
    {
        $menus = $this->get('doctrine.orm.entity_manager')->getRepository("CoreMenuBundle:Menu")->findAll() ;
        $menu=array("id"=>"root_node","text"=>"Men&uacute;","state"=>array('opened'=>true),'parent'=>null);
        foreach($menus as $menu_row)
        {
            $tmpMenu=array();
            $tmpMenu['id']=$menu_row->getId();
            $tmpMenu['text']=$menu_row->getDenominacion();
            if($menu_row->getPadre() != null)
                $tmpMenu['parent']=$menu_row->getPadre()->getId();
            else
                $tmpMenu['parent']="root_node";
            $menu[]=$tmpMenu;

        }
        return new JsonResponse($menu);
    }

    public function configAction()
    {
        $menuParents = $this->get('doctrine.orm.entity_manager')->getRepository("CoreMenuBundle:Menu")->obtenerPadres(false) ;
        $menu=array("id"=>"root_node","text"=>"Men&uacute;","state"=>array('opened'=>true),"icon"=>"fa fa-folder");
        foreach($menuParents as $parent)
        {
            $tmpMenu=array();
            $tmpMenu['id']=$parent->getId();
            $tmpMenu['text']=$parent->getDenominacion();
            if($parent->getRuta())
                $tmpMenu['text'].="(".$parent->getRuta().")";
            if(count($parent->getHijos())) {
                $tmpMenu['state'] = array('opened'=>true);
                $tmpMenu['children'] = $this->cargarHijos($parent->getHijos());
                $tmpMenu["icon"] = "fa fa-folder";
            }
            else
                $tmpMenu["icon"] = "glyphicon glyphicon-leaf";
            $menu['children'][]=$tmpMenu;
        }
        return new JsonResponse($menu);
    }
    protected function cargarHijos($menuParents)
    {
        $menu = array();
        foreach($menuParents as $parent)
        {
            $tmpMenu=array();
            $tmpMenu['id']=$parent->getId();
            $tmpMenu['text']=$parent->getDenominacion();
            if($parent->getRuta())
                $tmpMenu['text'].="(".$parent->getRuta().")";
            if(count($parent->getHijos())) {
                $tmpMenu["icon"] = "fa fa-folder";
                $tmpMenu['state'] = array('opened'=>true);
                $tmpMenu['children'] = $this->cargarHijos($parent->getHijos());
            }
            else
                $tmpMenu["icon"] = "glyphicon glyphicon-leaf";
            $menu[]=$tmpMenu;
        }
        return $menu;
    }
}
