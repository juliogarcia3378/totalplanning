<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Core\ComunBundle\Util\FechaUtil;
use Core\ComunBundle\Util\ResultType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;

class HoraPeriodoTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\HoraPeriodo';
        $this->name="Horas por período";
        $this->editTitle="elemento";
        $this->setIcon('fa fa-tasks');
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Hora", '10%','horaTime','time');
//        $filterData = new SelectFilterColumn();
//        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Hora")->filterObjects(array(),array('nombre'=>'asc')));
//        $nameColumn->setFilterData($filterData);

        $periodoColumn = new GridColumn("Período", '10%','horaPeriodo.periodo','select');
        $periodoColumn->setDefaultOrder(true);
        $filterData = new SelectFilterColumn();
        $filterData->setShowValue('abreviado');
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Periodo")->getOrdered());
        $periodoColumn->setFilterData($filterData);

        $turno = new GridColumn("Turno", '10%','horaPeriodo.turno','select');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Turno")->filterObjects());
        $turno->setFilterData($filterData);

//        $diaColumn = new GridColumn("Días", '30%','dia.nombre','select');
//        $diaColumn->setFilterName('dia.id');
//        $diaColumn->setSortable(false);
//        $filterData = new SelectFilterColumn();
//        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Dia")->getEntreSemana());
//        $diaColumn->setFilterData($filterData);

        $this->columns[] =$nameColumn;
        $this->columns[] =$turno;
        $this->columns[] =$periodoColumn;
//        $this->columns[] =$diaColumn;

    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_hora_periodo_new');
        $rutas->setDelete('planeacion_admin_crud_hora_periodo_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_hora_periodo_edit');
        $rutas->setList('planeacion_admin_crud_hora_periodo_listAjax');
        return $rutas;
    }
    public function constructData()
    {
        $order = $this->getTableSortByRequest();
        $filters = $this->getTableFiltersByRquest();
//        ldd($order);
        /**
         * @var $qb QueryBuilder
         */
        $qb =  $this->getRepo()->getQB();
//        if(array_key_exists('hora.nombre',$filters) && $filters['hora.nombre'] != "")
//        {
//            $filters['hora.nombre'] = array('=',$filters['hora.nombre']);
//        }
        if(array_key_exists('horaPeriodo.periodo',$order))
        {
            $qb->join('horaPeriodo.periodo','periodo');
            $qb->select('horaPeriodo,periodo');
            $order['periodo.anno']='desc';
            $order['periodo.tipoPeriodo']='desc';
            $order['horaPeriodo.turno']='asc';
            $order['horaTime']='asc';
            unset($order['horaPeriodo.periodo']);
        }
//        if(array_key_exists('dia.nombre',$order))
//        {
//            $qb->join('horaPeriodo.dia','dia');
//        }
//        ldd($filters);
        $this->datos = $this->getRepo()->filterQB($qb,$filters,ResultType::ObjectType,$order);

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] =  $row->getHoraTime()->format(FechaUtil::getTimeFormat());
            $tmpArray[] = $row->getTurno()->getNombre();
            $tmpArray[] = $row->getPeriodo()->getAbreviado();
//            $tmpArray[] = $row->getDiaStringList();
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('horaTime','horaPeriodo.turno','horaPeriodo.periodo');
    }
}