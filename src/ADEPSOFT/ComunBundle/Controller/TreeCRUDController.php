<?php

namespace ADEPSOFT\ComunBundle\Controller;

use ADEPSOFT\ComunBundle\tableDescription\architecture\RutasGrid;
use ADEPSOFT\ComunBundle\tableDescription\architecture\RutasTree;
use ADEPSOFT\ComunBundle\Util\UtilRepository2;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TreeCRUDController extends BaseController
{
    protected $type = null;
    protected $view = '@Comun/architecture/components/CRUD/generic_tree_crud.html.twig';
    protected $treeModelService = null;
    protected $createView='@Comun/architecture/components/CRUD/new_content.html.twig';
    protected $editView='@Comun/architecture/components/CRUD/edit_content.html.twig';
    protected $detailsView='@Comun/architecture/components/CRUD/details_content.html.twig';

   
    public function mainAction()
    {
        $rutas = $this->defineRutas();
        return $this->renderMain($rutas);

    }
    
    public function moveNodeAction()
    {

        $nodeId = $this->getParameter("node");
        if(!is_numeric($nodeId)) {
            $array = explode("_", $nodeId);
            $nodeId = $array[count($array)-1];
        }

        $parentId = $this->getParameter("parent");
        if(!is_numeric($parentId )) {
            $array = explode("_", $parentId);
            $parentId = $array[count($array)-1];
        }

        $em = $this->getEm();
        $repo = $this->getRepo($this->get($this->treeModelService)->getEntity());

        $parent=null;
        if(is_numeric($nodeId)) {
            $node = $repo->find($nodeId);
            if(!is_numeric($parentId))
                $parentId = -1;
            $parent = $repo->find($parentId);
            $node->setPadre($parent);
            $em->persist($node);
            $em->flush();
            return new JsonResponse(array("success"=>true,'paco'=>false));
        }
        return new JsonResponse(array("success"=>false));
    }
    /**
     * @return Response
     */
    public function renderMain($rutas)
    {
        $model = $this->get($this->treeModelService);
        return $this->render($this->view,array('model'=>$model,'rutas'=> $rutas));
    }
   
    public function listAction()
    {
        $records = $this->getTree($this->treeModelService);
        return new JsonResponse($records);
    }
    public function getTree($modelService)
    {
        $data = $this->get($modelService)->getTransformedData();
        return $data;
    }

     protected function defineRutas(){
         $rutas =new RutasTree();
         $rutas->setNew('security_tree_crud_new');
         $rutas->setDelete('security_tree_crud_delete');
         $rutas->setEdit('security_tree_crud_edit');
         $rutas->setList('security_tree_crud_list');
         $rutas->setDetails('security_tree_crud_details');
     }
    
    public function deleteAction()
    {
        $result = array();
        $result['success']=false;
        $entity = $this->get($this->treeModelService)->getEntity();
        $id = $this->getParameter('id');
        if(!is_numeric($id )) {
            $array = explode("_", $id);
            $id = $array[count($array)-1];
        }

        if($id && is_numeric($id)) {
            if(!is_array($id))
                $id=array($id);
            if(count($id)>0) {
                $q = UtilRepository2::getEntityManager()->createQuery("delete from $entity t where t.id in (:ids)")->setParameter('ids', $id);
                $q->execute();
                $result["success"] = true; // pass custom message(useful for getting status of group actions)
                if(count($id) == 1)
                    $result["sMessage"] = "Elemento eliminado satisfactoriamente.";
                else
                    $result["sMessage"] = "Elementos eliminados satisfactoriamente.";
            }
        }
        return new JsonResponse($result);
    }
   
    public function newAction()
    {
        $tableModel = $this->get($this->treeModelService);
        $entity = $tableModel->getEntity();
        $obj = new $entity();
        return $this->creadeUpdate($obj,$this->createView);
    }
    
    public function detailsAction()
    {
        $tableModel = $this->get($this->treeModelService);

        $id = $this->getParameter('id');
        if(!is_numeric($id )) {
            $array = explode("_", $id);
            $id = $array[count($array)-1];
        }
        $entity = $this->getEm()->getRepository($tableModel->getEntity())->find($id);
        $fields = UtilRepository2::getFields($this->getEm(),$tableModel->getEntity());
        $r = array();
        foreach($fields as $field) {
            if(!is_array($entity->{"get" . ucfirst($field)}()))
                $r[] = array('key' => $field, 'value' => $entity->{"get" . ucfirst($field)}());
        }
        return $this->render($this->detailsView,array('obj'=>$r));
    }
    
    public function editAction()
    {
        $tableModel = $this->get($this->treeModelService);
        $entity = $tableModel->getEntity();
        $id = $this->getParameter('id');
        if(!is_numeric($id )) {
            $array = explode("_", $id);
            $id = $array[count($array)-1];
        }
        if($id) {
            $obj = $this->getEm()->find($entity, $id);
            return $this->creadeUpdate($obj, $this->editView, "Elemento modificado satisfactoriamente.");
        }
        else
            return new JsonResponse(array("success" => false, "sMessage" => "Elemento inexistente."));
    }
    protected function creadeUpdate($obj,$view,$msg =  "Elemento creado satisfactoriamente.")
    {
        $form = $this->createForm(new $this->type(),$obj );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest());
//            ldd($form->getErrorsAsString());
            if($form->isValid()) {
                $em = $this->getEm();
                if($obj->getPadre() == null) {

                    $parent = $this->getParameter('parent',-1);
                    if(!is_numeric($parent )) {
                        $array = explode("_", $parent);
                        $parent = $array[count($array)-1];
                    }

                    $obj->setPadre($em->find($this->get($this->treeModelService)->getEntity(), $parent));
                }
                $em->persist($obj);
                $em->flush();
                $method = $this->get($this->treeModelService)->getNodeText();
                return new JsonResponse(array("success" => true, "sStatus" => "OK", "sMessage" =>$msg,"text"=>$obj->$method(),"id"=>$obj->getId()));
            }
            return new JsonResponse(
                array('form'=>
                        $this->renderView($view,  array('form' => $form->createview()))
                     )
            );
        }
        elseif($this->getParameter('id') != null)
            return new JsonResponse(
                array('form'=>
                    $this->renderView($view,  array('form' => $form->createview()))
                )
            );
        return $this->render($view, array(
            'form' => $form->createview(),
        ));
    }

}
