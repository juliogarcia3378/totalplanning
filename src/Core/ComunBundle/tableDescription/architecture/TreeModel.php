<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Julio
 * Date: 1/10/14
 * Time: 23:32
 * To change this template use File | Settings | File Templates.
 */

namespace Core\ComunBundle\tableDescription\architecture;

use Core\ComunBundle\Util\UtilRepository2;
use Symfony\Component\DependencyInjection\ContainerAware;

abstract class TreeModel  extends ContainerAware{
    protected $entity;
    protected $idTree;
    /**
     * @var string Nombre del metodo utilizado como texto a mostrar en los nodos
     */
    protected $nodeText='getDenominacion';

    /**
     * @var string nombre de la entidad a mostrar
     */
    protected $name;
    protected $check=false;
    protected $portlet = true;
    protected $container ;
    protected $rootNode=null;
    protected $checkeds = array();
    protected $disableds = array();

    function __construct() {
        $this->idTree = uniqid("",false);
        $this->container = UtilRepository2::getContainer();
    }

    /**
     * @return array
     */
    public function getDisableds()
    {
        return $this->disableds;
    }

    /**
     * @param array $disableds
     */
    public function setDisableds($disableds)
    {
        $this->disableds = $disableds;

    }

    /**
     * @return array
     */
    public function getCheckeds()
    {
        return $this->checkeds;
    }

    /**
     * @param array $checkeds
     */
    public function setCheckeds($checkeds)
    {
        $this->checkeds = $checkeds;
        foreach($checkeds as $checked)
            $this->checkeds[] = $this->idTree."_".$checked;
    }

    /**
     * @return boolean
     */
    public function hasPortlet()
    {
        return $this->portlet;
    }
    /**
     * @param boolean $portlet
     */
    public function setPortlet($portlet)
    {
        $this->portlet = $portlet;
    }


    /**
     * @return string
     */
    public function getNodeText()
    {
        return $this->nodeText;
    }

    /**
     * @param string $nodeText
     */
    public function setNodeText($nodeText)
    {
        $this->nodeText = $nodeText;
    }


    /**
     * @return NomencladoresRepository
     */
    protected function getRepo($entity=null)
    {
        if(!$entity)
            return UtilRepository2::getContainer()->get('doctrine.orm.entity_manager')->getRepository($this->entity);
        else
            return UtilRepository2::getContainer()->get('doctrine.orm.entity_manager')->getRepository($entity);
    }
    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function hasCheck()
    {
        return $this->check;
    }

    /**
     * @param boolean $check
     */
    public function setCheck($check)
    {
        $this->check = $check;
    }

    /**
     * @return string
     */
    public function getIdTree()
    {
        return $this->idTree;
    }

    /**
     * @param string $idTree
     */
    public function setIdTree($idTree)
    {
        $this->idTree = $idTree;
    }
    public function getEncodedData()
    {
        return json_encode(array($this->getTransformedData()));
    }
    public function getTransformedData()
    {
        $parents = $this->getRepo()->getTreeRoots();
        $rootName = $this->rootNode == null ? $this->getName()."s" : $this->rootNode;
        $root=array('id'=>-1,'text'=>$rootName,'type'=>"root",'icon'=>"fa fa-folder");
        $i = 0;
        $disableds = 0;
        foreach($parents as $parent)
        {
            $i++;
            $tmpObj=array();
            $tmpObj['id']=$this->idTree."_".$parent->getId();
            $tmpObj['text']=$parent->{$this->nodeText}();
            if(count($parent->getHijos())) {

                if(in_array($parent->getId(),$this->disableds)) {
                    $tmpObj['state'] = array('opened' => true, 'disabled' => true);
                }
                else {
                    $disabled=false;
                    $tmpObj['children'] = $this->cargarHijos($parent->getHijos(), $disabled);

                    if($disabled) {
                        $tmpObj['state'] = array('opened' => true, 'disabled' => true);
                    }
                    else
                        $tmpObj['state'] = array('opened'=>true);
                }

                $tmpObj["icon"] = "fa fa-folder";
            }
            else {
                $tmpObj["icon"] = "glyphicon glyphicon-leaf";
                if(in_array($parent->getId(),$this->disableds)) {
                    $tmpObj['state'] = array('disabled' => true);
                }
            }
            if(array_key_exists('state',$tmpObj)  && array_key_exists('disabled',$tmpObj['state']))
                $disableds++;
            $root['children'][]=$tmpObj;
        }
        if($i == $disableds)
          $root['state']=array('opened'=>true,'disabled'=>true);
        else
            $root['state']=array('opened'=>true);

        return $root;
    }
    protected function cargarHijos($parents,&$disableParent=false)
    {
        $r = array();
        $i = 0;
        $disableds = 0;
        $disableParent = false;;
        foreach($parents as $parent)
        {
            $i++;
            $tmpObj=array();
            $tmpObj['id']=$this->idTree."_".$parent->getId();
            $tmpObj['text']=$parent->{$this->nodeText}();
            if(count($parent->getHijos())) {
                if(in_array($parent->getId(),$this->disableds))
                    $tmpObj['state'] = array('opened'=>true,'disabled'=>true);
                else {
                    $disabled=false;
                    $tmpObj['children'] = $this->cargarHijos($parent->getHijos(), $disabled);

                    if($disabled)
                        $tmpObj['state'] = array('opened'=>true,'disabled'=>true);
                    else
                        $tmpObj['state'] = array('opened'=>true);
                }

                $tmpObj["icon"] = "fa fa-folder";
            }
            else {
                $tmpObj["icon"] = "glyphicon glyphicon-leaf";
                if(in_array($parent->getId(),$this->disableds))
                    $tmpObj['state'] = array('disabled'=>true);
            }
            if(array_key_exists('state',$tmpObj)  && array_key_exists('disabled',$tmpObj['state']))
                $disableds++;
            $r[]=$tmpObj;
        }
        $disableParent = $i==$disableds;
//        ldd($r);
        return $r;
    }


}