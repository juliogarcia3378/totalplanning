<?php

namespace ADEPSOFT\Planeacion\AdminBundle\TableDescription;


use ADEPSOFT\ComunBundle\tableDescription\architecture\GridColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\ReportField;
use ADEPSOFT\ComunBundle\tableDescription\architecture\RutasGrid;
use ADEPSOFT\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\TableModel;
use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\ComunBundle\Util\UtilRepository2Config;
use Doctrine\ORM\Mapping as ORM;

class DescargaAdministrativaTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'ADEPSOFT\Planeacion\AdminBundle\Entity\DescargaAdministrativa';
        $this->name="Descargas";
        $this->editTitle="Descargas";
        $this->hasExport=true;
        $this->hasXlsExport=true;
        $this->setIcon('fa fa-minus-square');
    }
    public function getReportFields()
    {
        $nombre= new ReportField(true,'Nombre y apellidos');
        $periodo = new ReportField(true,'Período');
        $tipoDescarga = new ReportField(true,'Tipo de Descarga');
        $comentario = new ReportField(true,'Comentarios');

        $r=array();
        $r['profesor']=$nombre;
        $r['periodo']=$periodo;
        $r['tipoDescarga']=$tipoDescarga;
        $r['comentario']=$comentario;
        return $r;
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Período", '20%','periodo','select',array('descarga.periodo','desc'));
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getRepo('PlaneacionAdminBundle:Periodo')->filterObjects(array(),array()));
        $nameColumn->setFilterType('select');
        $nameColumn->setFilterData($filterData);


        $nameColumn1 = new GridColumn("Profesor", '20%','profesor','select',array('descarga.profesor','desc'));
        $filterData1 = new SelectFilterColumn();
        $filterData1->setData($this->getRepo('PlaneacionAdminBundle:Profesor')->filterObjects(array(),array()));
        $nameColumn1->setFilterType('select');
        $nameColumn1->setFilterData($filterData1);

        $nameColumn2 = new GridColumn("Tipo de Descarga", '20%','tipoDescarga','select',array('descarga.tipodescarga','desc'));
        $filterData2 = new SelectFilterColumn();
        $filterData2->setData($this->getRepo('PlaneacionAdminBundle:TipoDescargaAdministrativa')->filterObjects(array(),array()));
        $nameColumn2->setFilterType('select');
        $nameColumn2->setFilterData($filterData2);

        $this->columns[] =$nameColumn;
        $this->columns[] =$nameColumn1;
        $this->columns[] =$nameColumn2;

    }

    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_descargas_new');
        $rutas->setDelete('planeacion_admin_crud_descargas_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_descargas_edit');
        $rutas->setList('planeacion_admin_crud_descargas_listAjax');
        $rutas->setExportPDF('planeacion_admin_crud_descargas_export_pdf');
        $rutas->setExportXLS('planeacion_admin_crud_descargas_export_xls');
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

        $this->datos = $this->getRepo()->filterQB($qb,$filters,ResultType::ObjectType,$order);

        $result = array();
        foreach ($this->datos as $row) {

            $tmpArray=array();

            $tmpArray[] = $row->getPeriodo()->getAbreviado();
            $tmpArray[] = $row->getProfesor()->getNombre();
            $tmpArray[] = $row->getTipoDescarga()->getNombre();
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('descargaAdministrativa.periodo','descargaAdministrativa.profesor');
    }

    public function constructReportData($filters=Array(),$order=null)
    {

        UtilRepository2Config::$paginate=false;
        $objs = $this->getRepo()->filterObjects($filters,$order);
        return $objs;
    }

}