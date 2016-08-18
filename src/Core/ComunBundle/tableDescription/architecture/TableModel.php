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
use Core\ComunBundle\Util\UtilRepository2Config;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAware;

abstract class TableModel  extends ContainerAware{
    /**
     * Id de la fila/objeto
     */
    CONST ROW_ID = "DT_RowId";
    /**
     * @var string Nombre del campo Identificador de los resultados (id normalmente para las entidades)
     */
    protected $id;
    /**
     * @var bool sin uso aun pero debe ser pra desactivar el ajax completo en las tablas
     */
    protected $ajax=true;
    /**
     * @var bool Indicar si las acciones de new y editar seran en modal o no (hacer mecanismo para las extra_actions)
     */
    protected $modal=true;
    protected $entity;
    protected $columns=array();
    protected $datos;
    protected $tableId;
    protected $expandable = false;
    protected $hasFilters = true;
    /**
     * @var string nombre de la entidad a mostrar
     */
    protected $name;
    protected $check=true;
    protected $rowNumberColumn = false;
    protected $container ;
    protected $extraActions = "";
    protected $icon = 'fa fa-group';
    protected $width = '100%';
    protected $allowAdd = true;
    protected $hasTitle = true;
    protected $hasGroupActions = true;
    protected $checkeds = array();
    protected $editTitle=null;
    protected $extraParams=array();
    protected $hasActive=false;
    protected $activoFeld="activo";
    protected $hasExport=false;
    protected $advancedSearchView=null;

    /**
     * @return null
     */
    public function getAdvancedSearchView()
    {
        return $this->advancedSearchView;
    }

    /**
     * @param null $advancedSearchView
     */
    public function setAdvancedSearchView($advancedSearchView)
    {
        $this->advancedSearchView = $advancedSearchView;
    }


    public function getReportFields()
    {
        return array();
    }
    /**
     * @return boolean
     */
    public function hasExport()
    {
        return $this->hasExport;
    }

    /**
     * @param boolean $hasExport
     */
    public function setHasExport($hasExport)
    {
        $this->hasExport = $hasExport;
    }


    /**
     * @return string
     */
    public function getActivoField()
    {
        return $this->activoFeld;
    }

    /**
     * @param string $activoFeld
     */
    public function setActivoFeld($activoFeld)
    {
        $this->activoFeld = $activoFeld;
    }

    /**
     * @return array
     */
    public function getHasActive()
    {
        return $this->hasActive;
    }

    /**
     * @param array $hasActive
     */
    public function setHasActive($hasActive)
    {
        $this->hasActive = $hasActive;
    }

    function __construct() {
        $this->id = "id";
        $this->tableId = uniqid("",false);
        $this->container = UtilRepository2::getContainer();
    }
    public function hasFilters()
    {
        return $this->hasFilters;
    }
    /**
     * @return boolean
     */
    public function isAjax()
    {
        return $this->ajax;
    }

    /**
     * @param boolean $ajax
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;
    }

    /**
     * @return boolean
     */
    public function isModal()
    {
        return $this->modal;
    }

    /**
     * @param boolean $modal
     */
    public function setModal($modal)
    {
        $this->modal = $modal;
    }

    public function getRutas()
    {
        return $this->defineRutas();
    }
    /**
     * @return array
     */
    public function getExtraParams()
    {
        return json_encode($this->extraParams);
    }

    /**
     * @param array $extraParam
     */
    public function setExtraParams($extraParams)
    {
        $this->extraParams = $extraParams;
    }


    /**
     * @return boolean
     */
    public function isExpandable()
    {
        return $this->expandable;
    }

    /**
     * @param boolean $expandable
     */
    public function setExpandable($expandable)
    {
        $this->expandable = $expandable;
    }

    /**
     * @return EntityManager
     * @throws \Exception
     */
    public function getEm()
    {
        return $this->container->get('doctrine.orm.entity_manager');
    }
    /**
     * @return null
     */
    public function getEditTitle()
    {
        return $this->editTitle;
    }

    /**
     * @param null $editTitle
     */
    public function setEditTitle($editTitle)
    {
        $this->editTitle = $editTitle;
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
    }

    /**
     * @return boolean
     */
    public function isHasGroupActions()
    {
        return $this->hasGroupActions;
    }

    /**
     * @param boolean $hasGroupActions
     */
    public function setHasGroupActions($hasGroupActions)
    {
        $this->hasGroupActions = $hasGroupActions;
    }


    /**
     * @return boolean
     */
    public function isHasTitle()
    {
        return $this->hasTitle;
    }

    /**
     * @param boolean $hasTitle
     */
    public function setHasTitle($hasTitle)
    {
        $this->hasTitle = $hasTitle;
    }


    /**
     * @return boolean
     */
    public function isAllowAdd()
    {
        return $this->allowAdd;
    }

    /**
     * @param boolean $allowAdd
     */
    public function setAllowAdd($allowAdd)
    {
        $this->allowAdd = $allowAdd;
    }

    /**
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param string $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }


    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }


    /**
     * @return array
     */
    public function getExtraActions()
    {
        return $this->extraActions;
    }

    /**
     * @param array $extraActions
     */
    public function setExtraActions($extraActions)
    {
        $this->extraActions = $extraActions;
    }

    /**
     * @return string
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * @param string $tableId
     */
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }
    protected function defineRutas()
    {
        return array();
    }
    public function detailData(){
        return array();
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
     * @return boolean
     */
    public function isRowNumberColumn()
    {
        return $this->rowNumberColumn;
    }

    /**
     * @param boolean $rowNumberColumn
     */
    public function setRowNumberColumn($rowNumberColumn)
    {
        $this->rowNumberColumn = $rowNumberColumn;
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

    public function getColumns() {
        if (count($this->columns) == 0) {
            $this->defineColumns();
        }
        return $this->columns;
    }
    public function getCheckBox($id)
    {
        return '<p class="text-center" style="margin: 0"><input type="checkbox" name="selected[]" value="'.$id.'"></p>';
    }
    public function getBotonEditar($text = "Modificar")
    {
        return '<a class="btn btn-large editar_elemento tooltips" style="padding-bottom: 0px; padding-top: 0px"  data-original-title="Modificar" data-placement="top"><i class="fa fa-edit " style="text-decoration: underline"></i> </a>';
//        return '<a class="btn btn-xs default editar_elemento" data-target="#ajax" data-toggle="modal"><i class="fa fa-edit"></i> '.$text.'</a>';
    }
    public function getBotonEliminar($text = "Eliminar")
    {
        return '<a class="btn btn-large  eliminar_elemento tooltips" style="padding-bottom: 0px; padding-top: 0px"  data-original-title="Eliminar" data-placement="top"><i class="fa fa-trash-o " style="text-decoration: underline"></i> </a>';
    }
    public function getBotonDetalles($text = "Detalles")
    {
        return '<a class="btn btn-large detalles_elemento tooltips"  style="padding-bottom: 0px; padding-top: 0px" data-original-title="Detalles" data-placement="top"> <i class="fa fa-eye" style="text-decoration: underline"></i> </a>';
    }
    public function makeButton($text, $icon, $action,$route=null,$params=Array())
    {
        if($route) {
            $url =  UtilRepository2::getRoute($route);
            return '<a noEvent="false"  url="'.$url.'" class="btn btn-large ' . $action . ' tooltips" action="' . $action . '"  style="padding-bottom: 0px; padding-top: 0px" data-original-title="' . $text . '" data-placement="top"> <i class="fa ' . $icon . '" style="text-decoration: underline"></i> </a>';
        }
        return '<a noEvent="false" class="btn btn-large '.$action.' tooltips" action="'.$action.'"  style="padding-bottom: 0px; padding-top: 0px" data-original-title="'.$text.'" data-placement="top"> <i class="fa '.$icon.'" style="text-decoration: underline"></i> </a>';
    }
    public function makeButtonNoEvent($text, $icon, $action,$route=null,$params=Array())
    {
        if($route) {
            $url =  UtilRepository2::getRoute($route);
            return '<a noEvent="true" url="'.$url.'" class="btn btn-large ' . $action . ' tooltips" action="' . $action . '"  style="padding-bottom: 0px; padding-top: 0px" data-original-title="' . $text . '" data-placement="top"> <i class="exportar_hoja fa ' . $icon . '" style="text-decoration: underline"></i> </a>';
        }
        return '<a noEvent="true" class="btn btn-large '.$action.' tooltips" action="'.$action.'"  style="padding-bottom: 0px; padding-top: 0px" data-original-title="'.$text.'" data-placement="top"> <i class="fa '.$icon.'" style="text-decoration: underline"></i> </a>';
    }
    public function defineActions()
    {
        $actions = array();
        $rutas = $this->defineRutas();
        if(!is_null($rutas->getDetails()))
            $actions[]=RowActions::Detalles;
        if(!is_null($rutas->getEdit()))
            $actions[]=RowActions::Editar;
//        if(!is_null($rutas->getDelete()))
//            $actions[]=RowActions::Eliminar;
        return $actions;

    }
    public function actionsWidth()
    {
        $def =  4*count($this->defineActions());
        if($this->expandable)
            $def+=4;

        return $def > 10 ? $def : 10;
    }
    public function getRowActions()
    {
        $actions = $this->defineActions();
        $result = '<div class="text-center">';
        if($this->expandable)
            $result .= $this->getBotonDetalles();
//            $result .= '<span class="row-details row-details-close"></span>';
        for($i = 0; $i < count($actions); $i++)
        {
            $funcName=$actions[$i];
//            $array = explode(" ",$funcName);
//            array_walk($array,"ucfirst");
//            $funcName = implode("",$array);
            $method =  "getBoton".$funcName;
            $result .= $this->$method();
        }

        return $result.'</div>';

    }
    public function getDatos() {
        if (count($this->datos) == 0) {
            //        throw new \LogicException('No hay datos en la tabla.');
        }
        return $this->datos;
    }

    public function setDatos($datos) {
        $this->datos = $datos;
    }


    public function getId() {
        return $this->id;
    }

    public abstract function constructData();
    public  function constructReportData($filters=array(),$order=null){return array();}
    public abstract function defineColumns();
    public function mapSorts()
    {
        return array();
    }
    public function getTotalElements(){
        return UtilRepository2::getTotalElements();
    }
    public function getReportHeaders(&$filters){
        $r=array();
        $fields = $this->getReportFields();
      //  ldd($fields);
//        $headers[] = UtilRepository2::getContainer()->get('request')->get('report_field_0');
//        $headers[] = UtilRepository2::getContainer()->get('request')->get('report_field_1');
//        $headers[] = UtilRepository2::getContainer()->get('request')->get('report_field_2');
        $i=0;

        while(array_key_exists('report_field_'.$i,$filters))
        {
            $header = $filters['report_field_'.$i];
            $f = $fields[$header];
            if( is_null($f->getValue()))
                $f->setValue($header);
            $r[]=$f;
            unset($filters['report_field_'.$i]);
            $i++;
        }
//        unset($filters['report_field_'.$i]);
//        ld(count($r));
//        ldd($r);
        return $r;
    }
    public function getFilters(&$filters)
    {
        return array();
//        $filters = $this->getTableFiltersByRquest();
    }
    public function getReportData(&$filters,&$order)
    {
        return $this->constructReportData($filters,$order);
    }
    public function getExportData()
    {
//        ldd($this->getTableFiltersByRquest());
        UtilRepository2Config::$paginate=false;
        $order=$this->getTableSortByRequest();
        $filters = UtilRepository2::getRequest()->request->all();
        $headers = $this->getReportHeaders($filters);
//        ldd($headers);
        $filtros= $this->getFilters($filters);
//        ldd($filtros);
        unset($filters['iSortCol_0']);
        unset($filters['sSortDir_0']);
//        ldd($filters);
        $data= $this->getReportData($filters,$order);
        $r = array('headers'=>$headers,'data'=>$data,'filters'=>$filtros);
        return $r;
    }
    public function getTransformedData($rowActions=array(RowActions::Editar,RowActions::Eliminar,RowActions::Detalles))
    {
        $records= $this->constructData();

        $iTotalRecords = $this->getTotalElements();
        $iDisplayStart = $this->container->get('request')->get('iDisplayStart');
        $iDisplayLength = $this->container->get('request')->get('iDisplayLength');
        $iDisplayLength = $iDisplayLength == -1 ? UtilRepository2::getTotalElements() : $iDisplayLength;

        $end = $iDisplayStart + $iDisplayLength;
        $end = count($this->datos);

//        $cant = $end > $iTotalRecords ? $iTotalRecords : $end;
        $cant=$end;

        $start = $iDisplayStart;
        $result = array();
        $result["aaData"] = array();
        for($i = 0; $i < $cant; $i++) {
            $row = ($start + $i)+1;
            $tmpArray = array();

            if($this->rowNumberColumn)
                $tmpArray[]=$row;

            if($this->hasCheck())
                if(is_array($this->datos[$i]))
                    $tmpArray[]=$this->getCheckBox($this->datos[$i][$this->id]);
                else
                    $tmpArray[]=$this->getCheckBox($this->datos[$i]->getId());

            $tmpArray=array_merge($tmpArray,$records[$i]);

            if(count($rowActions) > 0)
                $tmpArray[]=$this->getRowActions($rowActions);

            if(is_array($this->datos[$i]))
                $tmpArray["DT_RowId"] = $this->datos[$i]['id'];
            else {
                $list = "_";
                for ($j = 0; $j < $cant; $j++) {
                    $list.=$this->datos[$j]->getId();
                    if ($j != $cant-1){
                        $list.=".";
                    }
                }
                $tmpArray["DT_RowId"] = $this->tableId . $list . "_" . $this->datos[$i]->getId();
            }

            $result["aaData"][]=$tmpArray;
        }
        $result["iTotalDisplayRecords"] = $iTotalRecords;
        $result["iTotalRecords"] = $iTotalRecords;

        $result["checkeds"] = $this->checkeds;
        UtilRepository2Config::$paginate=false;
        $result["extraData"] = $this->detailData();
        return $result;
    }
    public function getTableFiltersByRquest()
    {
        $r = array();
        $filter = json_decode($this->container->get('request')->get('filter'));
        if($filter && is_array(get_object_vars($filter))) {
            foreach ($filter as $key => $value) {
                if(!is_array($value) && $value != -1)
                    $r[$key] = $value;
                elseif(is_array($value) && count($value) > 0 && $value[0] != '') {
                    $r[$key] = array('in', $value);
                }
            }
        }
        return $r;
    }
    public function getTableSortByRequest()
    {
        $sortMap = $this->mapSorts();
        $sortArray = array();
        $sortColIndex = $this->container->get('request')->get('iSortCol_0');
        if($sortColIndex != null) {
            if($this->hasCheck())
                $sortColIndex--;
            if($this->rowNumberColumn)
                $sortColIndex--;

            $sortDir = $this->container->get('request')->get('sSortDir_0');
            $sortArray[$sortMap[$sortColIndex]] = $sortDir;
        }
//        ldd($sortArray);
        return $sortArray;
    }
    public function getTableSortByRequestOld()
    {
        $sortMap = $this->mapSorts();
        $sortArray = array();
        foreach($sortMap as $key=>$sort)
        {
            $sortColIndex = $this->container->get('request')->get('iSortCol_'.$key);
            if($sortColIndex != null) {
                $sortDir = $this->container->get('request')->get('sSortDir_'.$key);
                $sortArray[$sortMap[$key]] = $sortDir;
            }
        }
        ldd($sortArray);
        return $sortArray;
    }
    protected function getModel(){

        return array("columns"=>$this->getColumns(),"datos"=>$this->getDatos());

    }


}