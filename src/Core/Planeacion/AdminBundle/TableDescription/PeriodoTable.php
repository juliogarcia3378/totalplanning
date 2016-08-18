<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Doctrine\ORM\Mapping as ORM;

class PeriodoTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\Periodo';
        $this->name="Períodos";
        $this->editTitle="período";
//        $this->hasActive = true;
        $this->setIcon('fa fa-calendar');
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Nombre", '25%','nombre');

        $numColumn = new GridColumn("Número", '5%','periodo.tipoPeriodo','select');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:TipoPeriodo")->findAll());
        $filterData->setShowValue('id');
        $numColumn->setFilterData($filterData);

        $anno = new GridColumn("Año", '10%','anno');
        $anno->setDefaultOrder(true);
        $anno->setSortOrder('desc');


        $this->columns[] =$nameColumn;
        $this->columns[] =$numColumn;
        $this->columns[] =$anno;

    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_periodo_new');
        $rutas->setDelete('planeacion_admin_crud_periodo_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_periodo_edit');
        $rutas->setList('planeacion_admin_crud_periodo_listAjax');

        return $rutas;
    }
    public function constructData()
    {
        $sort = $this->getTableSortByRequest();
        if(array_key_exists('anno',$sort))
            $sort['periodo.tipoPeriodo']='desc';
        $this->datos= $this->getRepo()->filterObjects($this->getTableFiltersByRquest(),$sort);

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getNombre();
            $tmpArray[] = $row->getTipoPeriodo()->getId();
            $tmpArray[] = $row->getAnno();
//            $tmpArray[] = $row->getPermisionListString();
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('nombre','periodo.tipoPeriodo','anno');
    }
}