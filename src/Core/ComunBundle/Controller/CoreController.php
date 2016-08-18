<?php

namespace Core\ComunBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ADEPCRUDController extends Controller
{
    protected $entity;
    protected $type;
    protected $searchType;
    protected $view;
    protected $gtr;

    protected function pageHelper($result){

        $defaultTable = new $this->table();
        $defaultTable->constructData($result);
        $response['data'] = $defaultTable->getModel();
        return $response;
    }
    protected function getGestor()
    {
        return $this->get($this->gtr);

    }

    protected function getRepository($entity = null)
    {
        if($entity == null)
            return $this->getDoctrine()->getRepository($this->entity);
        else
            return $this->getDoctrine()->getRepository($entity);
    }

    public function showAction($id)
    {
        return $this->getRepository()->find($id);
    }
    public function indexAction()
    {
        return $this->render($this->view.'/index.html.twig');
    }

    public function advancedSearchAction()
    {
        $form   = $this->createForm(new $this->searchType());
        return $this->render($this->view.'/advanceSearch.html.twig', array(
            'form'   => $form->createView(),
        ));
    }
    public function newAction()
    {
        $entity = new $this->entity();
        $form   = $this->createForm(new $this->type(), $entity);
        return $this->render($this->view.'/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function editAction($entity)
    {
    }

    public function deleteAction($id)
    {
    }



    public function listAction($entity)
    {
    }
    public function saveToSession($key,$value)
    {
        $this->getRequest()->getSession()->save($key,$value);
    }
    public function loadFromSession($key)
    {
        return $this->getRequest()->getSession()->get($key);
    }
    public function listAjaxAction()
    {
        $page = $this->getRequest()->request->get('page');
        $size = $this->getRequest()->request->get('size');
        $filter=$this->getRequest()->request->get('filter');
        $val = $this->getDoctrine()->getRepository($this->entity)->findAll();
        $response['total'] = count($val);
        $result = array_slice($val,$page*$size,$size);
        $defaultTable = new $this->table();
        $defaultTable->constructData($result);
        $response['data']=$defaultTable->getModel();
        return new Response(json_encode($response));
    }

}
