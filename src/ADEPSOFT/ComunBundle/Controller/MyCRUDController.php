<?php

namespace ADEPSOFT\ComunBundle\Controller;

use ADEPSOFT\ComunBundle\Util\UtilRepository2;
use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class MyCRUDController extends BaseController
{
    protected $type = null;
    protected $editType = null;
    protected $view = '@Comun/architecture/components/CRUD/generic_crud.html.twig';
    protected $tableModelService = null;
    protected $createView='@Comun/architecture/components/CRUD/new_content.html.twig';
    protected $editView='@Comun/architecture/components/CRUD/edit_content.html.twig';
    protected $detailsView='@Comun/architecture/components/CRUD/details_content.html.twig';
    protected $textProperty = 'nombre';
    protected $extra_params=array();
    protected $exportTwig = '@Comun/architecture/components/CRUD/export.html.twig';
    protected $headerTwig = '@Comun/architecture/components/CRUD/export_header.html.twig';
    protected $footerTwigt='@Comun/architecture/components/CRUD/export_footer.html.twig';
    /**
     * @return Response
     */
    public function mainAction()
    {
//$horas = $this->getRepo('PlaneacionAdminBundle:Hora')->findAll();
//        $dias = $this->getRepo('PlaneacionAdminBundle:Dia')->findAll();
//        foreach($horas as $hora)
//            foreach($dias as $dia){
//                if($hora->getNombre() != '17:50' && $dia->getId() != EDia::Sabado && $dia->getId() != EDia::Domingo)
//                    $hora->addDia($dia);
//                if($hora->getNombre() <= '17:50' && $dia->getId() == EDia::Sabado)
//                    $hora->addDia($dia);
//                $this->getEm()->persist($hora);
//            }
//        $this->getEm()->flush();
//        die;
        return $this->renderMain();

    }
    /**
     * @return Response
     */
    public function renderMain()
    {

        $model = $this->get($this->tableModelService);
        $entity = $model->getEntity();
//        $obj = new $entity();
//        $form = $this->createForm(new $this->type(),$obj );
        return $this->render($this->view,array('model'=>$model,'rutas'=> $model->defineRutas()));
    }
    public function getMainViewHtml($form=null)
    {
        $model = $this->get($this->tableModelService);
        $model->setExtraParams($this->getExtraParams());
        if(!is_null($form))
            $view =$this->renderView($this->view,array('model'=>$model,'rutas'=> $model->defineRutas(),'form'=>$form->createView()));
        else
            $view =$this->renderView($this->view,array('model'=>$model,'rutas'=> $model->defineRutas()));

        return $view;
    }
    public function getCheckeds()
    {
        return array();
    }
    public function reportHeaderAction()
    {
//        return new Response($this->renderView($this->headerTwig),200,
//               array('Content-Type' => 'text/html' )
//        );
//        ldd('apco');
        return $this->render($this->headerTwig, array(
        ));
    }
    public function reportFooterAction()
    {
        return $this->render($this->footerTwigt , array(
        ));
//        ldd('apco');
    }
    public function exportPdfAction()
    {
        $model = $this->get($this->tableModelService);

        $data=$model->getExportData();

        $html = $this->renderView($this->exportTwig, array(
            'headers'  => $data['headers'],
            'data'=>$data['data'],
            'filters'=>$data['filters']
        ));
        $headerHtml = $this->renderView($this->headerTwig);
        $footerHtml = $this->renderView($this->footerTwigt);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html,array('lowquality'=>false,'encoding'=>'UTF-8',
                'header-html'=>$headerHtml,'footer-html'=>$footerHtml,'header-spacing'=>5,'margin-top'=>40,'footer-spacing'=>5)),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="'.$this->exportFileName.'.pdf"'
            )
        );
    }

    public function exportXlsAction()
    {
        $model = $this->get($this->tableModelService);

        $data=$model->getExportData();

        $html = $this->renderView($this->exportTwigExcel, array(
            'headers'  => $data['headers'],
            'data'=>$data['data'],
            'filters'=>$data['filters']
        ));
        return new Response(
           $html,
            200,
            array(
                'Content-Type'          => 'application/xls',
                'encoding'=>'UTF-8',
                'Content-Disposition'   => 'attachment; filename="'.$this->exportFileName.'.xls"'
            )
        );
    }

    public function exportAction()
    {

        try {
            $model = $this->get($this->tableModelService);
//            ldd(UtilRepository2::getContainer()->get('request')->get('report_field_0'));
            $data = $model->getExportData();
//            ldd($data['headers']);
            return $this->render($this->exportTwig, array(
                'headers'  => $data['headers'],
                'data'=>$data['data']
            ));

        }
        catch(\Exception $e)
        {
            return new JsonResponse($e->getMessage());
        }
    }
    /**
     * @return Response
     */
    public function listAjaxAction()
    {
        $model =$this->get($this->tableModelService);
        if($this->getParameter('firstPetition'))
            $model->setCheckeds($this->getCheckeds());
        //ldd($this->getGrid($model));
        return new JsonResponse($this->getGrid($model));
    }
    public function getGrid($model)
    {
        $data = $model->getTransformedData();
        return $data;
    }

    /**
     * @return array
     */
    public function activarAction()
    {
        $id = $this->getParameter('selected');
        $result = array();
        $entity = $this->get($this->tableModelService)->getEntity();
        if ($id != null) {
            if (!is_array($id))
                $id = array($id);
            if (count($id) > 0) {
                $activo = $this->get($this->tableModelService)->getActivoField();
                $q = UtilRepository2::getEntityManager()->createQuery("update $entity m set m.$activo = true  where m.id in (:ids)")->setParameter('ids', $id);
                $q->execute();
                $result["success"] = true; // pass custom message(useful for getting status of group actions)
                if (count($id) == 1)
                    $result["sMessage"] = "Elemento activado satisfactoriamente.";
                else
                    $result["sMessage"] = "Elementos activados satisfactoriamente.";
            }
        }
        $data = $this->get($this->tableModelService)->getTransformedData();
        return new JsonResponse(array_merge($result, $data));
    }
    /**
     * @return array
     */
    public function desactivarAction()
    {
        $id = $this->getParameter('selected');
        $result = array();
        $entity = $this->get($this->tableModelService)->getEntity();
        if ($id != null) {
            if (!is_array($id))
                $id = array($id);
            if (count($id) > 0) {
                $activo = $this->get($this->tableModelService)->getActivoField();
                $q = UtilRepository2::getEntityManager()->createQuery("update $entity m set m.$activo = false  where m.id in (:ids)")->setParameter('ids', $id);
                $q->execute();
                $result["success"] = true; // pass custom message(useful for getting status of group actions)
                if (count($id) == 1)
                    $result["sMessage"] = "Elemento deactivado satisfactoriamente.";
                else
                    $result["sMessage"] = "Elementos deactivados satisfactoriamente.";
            }
        }
        $data = $this->get($this->tableModelService)->getTransformedData();
        return new JsonResponse(array_merge($result, $data));
    }
    /**
     * @return array
     */
    public function deleteAction()
    {
        $id = $this->getParameter('selected');
        try {
            $result = array();
            $entity = $this->get($this->tableModelService)->getEntity();
            if ($id != null) {
                if (!is_array($id))
                    $id = array($id);
                if (count($id) > 0) {
                    $q = UtilRepository2::getEntityManager()->createQuery("delete from $entity t where t.id in (:ids)")->setParameter('ids', $id);
                    $q->execute();
                    $result["success"] = true; // pass custom message(useful for getting status of group actions)
                    if (count($id) == 1)
                        $result["sMessage"] = "Elemento eliminado satisfactoriamente.";
                    else
                        $result["sMessage"] = "Elementos eliminados satisfactoriamente.";
                }
            }
//        return new ArrayResponse($result);
            $data = $this->get($this->tableModelService)->getTransformedData();
            return new JsonResponse(array_merge($result, $data));
        }
        catch(DBALException $e)
        {
            //23503 FOREIGN Key Violation
//            ldd($e);
            $data = $this->get($this->tableModelService)->getTransformedData();
            return new JsonResponse(array_merge_recursive(array('success'=>false,'sMessage'=>'No se puede eliminar un elemento referenciado.','code'=>$e->getMessage()),$data));
        }
    }
    /**
     * @return Response
     */
    public function newAction()
    {
        $tableModel = $this->get($this->tableModelService);
        $entity = $tableModel->getEntity();
        $obj=null;
        if($entity)
            $obj = new $entity();
        return $this->creadeUpdate($obj,$this->createView);
    }
    /**
     * @return Response
     */
    public function detailsAction()
    {
        $tableModel = $this->get($this->tableModelService);
        $entity = $this->getEm()->getRepository($tableModel->getEntity())->find($this->getParameter('id'));
        $fields = UtilRepository2::getFields($this->getEm(),$tableModel->getEntity());
        $r = array();
        foreach($fields as $field) {
            if(!is_array($entity->{"get" . ucfirst($field)}()))
                $r[] = array('key' => $field, 'value' => $entity->{"get" . ucfirst($field)}());
        }
        return $this->render($this->detailsView,array('obj'=>$r));
    }
    /**
     * @return Response
     */
    public function editAction()
    {
        $tableModel = $this->get($this->tableModelService);
        $entity = $tableModel->getEntity();
        $id = $this->getParameter('id');
        if($id) {
            $obj = $this->getEm()->find($entity, $id);
            return $this->creadeUpdate($obj, $this->editView, "Elemento modificado satisfactoriamente.");
        }
        else
            return new JsonResponse(array("success" => false, "sStatus" => "ERROR", "sMessage" => "Elemento inexistente."));
    }
    protected function getExtraParams()
    {
        return $this->extra_params;
    }
    protected function creadeUpdate($obj,$view,$msg =  "Elemento creado satisfactoriamente.",$extra_params=array())
    {
//        ldd($_SERVER);
//        $extra_params['local'] = $_SERVER['SERVER_ADDR'] == '127.0.0.1';
//        ldd($obj->getNombre());
        $form = null;
        $redirect = true;
        if(array_key_exists('redirect',$extra_params)) {
            $redirect= $extra_params['redirect'] ;
            unset($extra_params['redirect'] );
        }
        if(array_key_exists('_constructor_params',$extra_params)) {
            $form = $this->createForm(new $this->type($extra_params['_constructor_params']), $obj);
            unset($extra_params['_constructor_params']);
        }
        else
            $form = $this->createForm(new $this->type(),$obj );
        if($obj != null && $obj->getId() != null && $this->editType != null)
            $form = $this->createForm(new $this->editType(),$obj );
        $title= '';
        if($this->getParameter('id') != null && $this->textProperty != null) {
            $method = "get".ucfirst($this->textProperty);
            $title = $obj->$method();
        }

        if ('POST' === $this->getRequest()->getMethod()) {
//            ld($obj);
            $this->extraData($obj);
            $form->bind($this->getRequest());
//            ldd($obj);
//            ldd($obj->getHoraTime());
//            ldd($obj->getSede());
//            ldd($this->getRequest()->get('stj_basebundle_distritotype'));
//            ldd($form->isValid());
            if($form->isValid()) {
                $this->extraData($obj);
                $em = $this->getEm();
                $em->persist($obj);
                $em->flush();
                if($this->get($this->tableModelService)->isModal())
                    return new JsonResponse(array("success" => true, "sStatus" => "OK", "sMessage" =>$msg));
                else{
                    $html = $this->getMainViewHtml();
                    return new JsonResponse(array("success" => true, "sStatus" => "OK","html"=>$html));
                }
            }
            if($this->get($this->tableModelService)->isModal()) {
//                ldd($form->getErrorsAsString());
                return new JsonResponse(
                    array('form' =>
                        $this->renderView($view, array('form' => $form->createview(), 'title' => $title))
                    )
                );
            }
            elseif($redirect == false){
                return new JsonResponse(array("success" => false, "reload" => false, "sMessage" => "Existen campos con valores no válidos."));
            }
            else {
                return $this->render($this->createView, array_merge(array('form' => $form->createview(), 'model' => $this->get($this->tableModelService)), $extra_params));
            }
        }
        if($this->get($this->tableModelService)->isModal())
            return new JsonResponse(
                array('form'=>
                             $this->renderView($view,  array('form' => $form->createview())),
                     'title'=>$title
                     )
            );
        else
            return $this->render($this->createView,  array_merge(array('form' => $form->createview(),'model'=>$this->get($this->tableModelService)),$extra_params));
    }
    public function extraData($obj)
    {
    }

}
