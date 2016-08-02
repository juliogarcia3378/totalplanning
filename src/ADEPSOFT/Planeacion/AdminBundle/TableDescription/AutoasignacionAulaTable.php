<?php

namespace ADEPSOFT\Planeacion\AdminBundle\TableDescription;

use ADEPSOFT\ComunBundle\tableDescription\architecture\GridColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\RutasGrid;
use ADEPSOFT\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\TableModel;
use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\ComunBundle\Util\UtilRepository2Config;
use Doctrine\ORM\Mapping as ORM;

class AutoasignacionAulaTable extends TableModel
{
    function __construct()
    {
        parent::__construct();
        $this->entity = 'ADEPSOFT\Planeacion\AdminBundle\Entity\AutoasignacionAula';
        $this->name = "Aulas de asignación directa";
        $this->editTitle = "Aulas de asignación directa";
        $this->hasExport = false;
        $this->hasXlsExport = false;
        $this->setIcon('fa fa-random');
    }

    public function getReportFields()
    {
        return null;
    }

    public function defineColumns()
    {
        $nameColumn = new GridColumn("Aula", '20%', 'aula', 'select', array('autoasignacionaula.aula', 'desc'));
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getRepo('PlaneacionAdminBundle:Aula')->filterObjectsActivo());
        $nameColumn->setFilterType('select');
        $nameColumn->setFilterData($filterData);

        $nameColumn1 = new GridColumn("Materia", '20%', 'materia', 'select', array('autoasignacionaula.materia', 'desc'));
        $filterData1 = new SelectFilterColumn();
        $filterData1->setData($this->getRepo('PlaneacionAdminBundle:Materia')->filterObjectsActivo());
        $nameColumn1->setFilterType('select');
        $nameColumn1->setFilterData($filterData1);

        $nameColumn2 = new GridColumn("Comentario", '20%', 'comentario', 'text', array('autoasignacionaula.comentario', 'desc'));
        $filterData2 = new SelectFilterColumn();
        $filterData2->setData($this->getRepo('PlaneacionAdminBundle:AutoasignacionAula')->filterObjects(array(), array()));
        $nameColumn2->setFilterType('text');
        $nameColumn2->setFilterData($filterData2);

        $this->columns[] = $nameColumn;
        $this->columns[] = $nameColumn1;
        $this->columns[] = $nameColumn2;
    }

    public function defineRutas()
    {
        $rutas = new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_autoasignacion_aula_new');
        $rutas->setDelete('planeacion_admin_crud_autoasignacion_aula_delete');
        $rutas->setEdit('planeacion_admin_crud_autoasignacion_aula_edit');
        $rutas->setList('planeacion_admin_crud_autoasignacion_aula_listAjax');
        return $rutas;
    }

    public function constructData()
    {
        $order = $this->getTableSortByRequest();
        $filters = $this->getTableFiltersByRquest();

        $qb = $this->getRepo()->getQB();

        $this->datos = $this->getRepo()->filterQB($qb, $filters, ResultType::ObjectType, $order);

        $result = array();
        foreach ($this->datos as $row) {

            $tmpArray = array();

            $tmpArray[] = $row->getAula()->getNombre();
            $tmpArray[] = $row->getMateria()->getclaveNombreCarrera();
            $tmpArray[] = $row->getComentario();
            $result[] = $tmpArray;
        }
        return $result;

    }

    public function mapSorts()
    {
        return array('descargaAdministrativa.periodo', 'descargaAdministrativa.profesor');
    }

    public function constructReportData($filters = Array(), $order = null)
    {

        UtilRepository2Config::$paginate = false;
        $objs = $this->getRepo()->filterObjects($filters, $order);
        return $objs;
    }

}