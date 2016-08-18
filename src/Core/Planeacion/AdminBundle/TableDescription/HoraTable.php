<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Core\ComunBundle\Util\ResultType;
use Core\ComunBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;

class HoraTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\Hora';
        $this->name="Horas";
        $this->editTitle="hora";
        $this->setIcon('fa fa-clock-o');
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Hora", '25%','hora','time');
        $nameColumn->setDefaultOrder(true);

        $diaColumn = new GridColumn("Días", '40%','dia.nombre','select');
        $diaColumn->setFilterName('dia.id');
        $diaColumn->setSortable(false);
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Dia")->getEntreSemana());
        $diaColumn->setFilterData($filterData);

        $activa = new GridColumn("Activa", '5%','activo');
        $filter = new SelectFilterColumn();
        $filter->setData(array(
                array('id'=>1,'nombre'=>"Sí"),
                array('id'=>0,'nombre'=>"No")
            )
        );
        $activa->setFilterType('select');
        $activa->setFilterData($filter);

        $this->columns[] =$nameColumn;
        $this->columns[] =$diaColumn;
        $this->columns[] =$activa;

    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_hora_new');
        $rutas->setDelete('planeacion_admin_crud_hora_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_hora_edit');
        $rutas->setList('planeacion_admin_crud_hora_listAjax');
        $rutas->setActivar('planeacion_admin_crud_hora_activar');
        $rutas->setDesactivar('planeacion_admin_crud_hora_desactivar');
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
        if(array_key_exists('dia.id',$filters) && $filters['dia.id'] != "")
        {
            $qb->join('hora.dia','dia');
        }
        $this->datos = $this->getRepo()->filterQB($qb,$filters,ResultType::ObjectType,$order);

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getNombre();
            $tmpArray[] = $row->getDiaStringList();
            $tmpArray[] = Util::boolean($row->getActivo());
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('nombre','dia.id','activo');
    }
}