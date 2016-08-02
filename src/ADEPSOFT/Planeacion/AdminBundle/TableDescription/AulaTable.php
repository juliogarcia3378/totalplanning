<?php

namespace ADEPSOFT\Planeacion\AdminBundle\TableDescription;


use ADEPSOFT\ComunBundle\tableDescription\architecture\GridColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\ReportField;
use ADEPSOFT\ComunBundle\tableDescription\architecture\RutasGrid;
use ADEPSOFT\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\TableModel;
use ADEPSOFT\ComunBundle\Util\FechaUtil;
use ADEPSOFT\ComunBundle\Util\Util;
use ADEPSOFT\ComunBundle\Util\UtilRepository2Config;
use Doctrine\ORM\Mapping as ORM;

class AulaTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'ADEPSOFT\Planeacion\AdminBundle\Entity\Aula';
        $this->name="Aulas";
        $this->editTitle="aula";
        $this->hasActive = true;
        $this->hasExport=true;
        $this->hasXlsExport=true;
        $this->advancedSearchView = 'planeacion_admin_crud_aula_filtro_avanzado_view';
        $this->setIcon('fa fa-th');
    }
    public function getReportFields()
    {
        $nombre= new ReportField(true,'Aula');
        $numeroEmpleado = new ReportField(true,'Capacidad');
        $activo = new ReportField(true,'Activa');
        $enlinea = new ReportField(true,'En Línea');

        $r=array();
        $r['nombre']=$nombre;
        $r['capacidad']=$numeroEmpleado;
        $r['disponible']=$activo;
        $r['distancia']=$enlinea;
        return $r;
    }
    public function getFilters(&$filters)
    {
//        $filters = UtilRepository2::getRequest()->request->all();
//        ldd($filters);
        $contextoBase=Array();
        $contextoBase['Fecha']= FechaUtil::toString(FechaUtil::getFechaActual());
        if(array_key_exists('activo',$filters) && $filters['activo']!=null)
        {
            if($filters['activo'] == false) {
                $contextoBase['Habilitada']='No';
            }
            else
                $contextoBase['Habilitada']='Si';
        }
        if(array_key_exists('nombre',$filters) && $filters['nombre']!=null && $filters['nombre']!=""){
            $contextoBase['Nombre']='Contiene: "'.$filters['nombre'].'"';
        }
        if(array_key_exists('capacidad',$filters) && $filters['capacidad']!=null && $filters['capacidad']!=""){
            $contextoBase['Capacidad']= $filters['capacidad'];
        }

        $contextoDisponibilidad=array();
        if(array_key_exists('filtro_periodo',$filters) && $filters['filtro_periodo'] != null ){
            $contextoDisponibilidad['Período'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Periodo')->find($filters['filtro_periodo'])->getAbreviado();
        }
        if(array_key_exists('dia_clase',$filters)  &&  $filters['dia_clase'] != null &&  $filters['dia_clase'] != ""){
            $contextoDisponibilidad['Día'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Dia')->find($filters['dia_clase'])->getNombre();
        }
        if(array_key_exists('hora_clase',$filters) &&  $filters['hora_clase'] != null &&  $filters['hora_clase'] != "" ){
            $contextoDisponibilidad['Hora'] = $filters['hora_clase'];
        }

        if(array_key_exists('libre_ocupado',$filters) && $filters['libre_ocupado'] != null && $filters['libre_ocupado'] != ""){
            if( (array_key_exists('filtro_periodo',$filters) && $filters['filtro_periodo'] != null &&  $filters['filtro_periodo'] != "" )||
                (array_key_exists('dia_clase',$filters) && $filters['dia_clase'] != null &&  $filters['dia_clase'] != "") ||
                (array_key_exists('hora_clase',$filters) && $filters['hora_clase'] != null &&  $filters['hora_clase'] != "") )
                $contextoDisponibilidad['Se encuentran'] = $filters['libre_ocupado']==1?"Disponibles":"Ocupadas";
        }

        $r=array();
        if(count($contextoBase))
            $r['base']=$contextoBase;
        if(count($contextoDisponibilidad))
            $r['Disponibilidad']=$contextoDisponibilidad;
        return $r;
    }
    public function constructReportData($filters=Array(),$order=null)
    {
//        $order = $this->getTableSortByRequest();
        UtilRepository2Config::$paginate=false;
//        ld($order);
        $filters['aula.id']=array('!=',65);
        $objs = $this->getRepo()->listTable($filters,$order);
//        ldd($objs);
        return $objs;
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Aula", '25%','nombre');
        $nameColumn->setDefaultOrder(true);

        $capacidad = new GridColumn("Capacidad", '15%','capacidad');
        $activa = new GridColumn("Activa", '5%','activo');
        $filter = new SelectFilterColumn();
        $filter->setData(array(
                array('id'=>1,'nombre'=>"Sí"),
                array('id'=>0,'nombre'=>"No")
            )
        );
        $activa->setFilterType('select');
        $activa->setFilterData($filter);

        $enlinea = new GridColumn("En línea", '5%','enlinea');
        $filter2 = new SelectFilterColumn();
        $filter2->setData(array(
                array('id'=>1,'nombre'=>"Sí"),
                array('id'=>0,'nombre'=>"No")
            )
        );
        $enlinea->setFilterType('select');
        $enlinea->setFilterData($filter2);

        $this->columns[] =$nameColumn;
        $this->columns[] =$capacidad;
        $this->columns[] =$activa;
        $this->columns[] =$enlinea;
    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_aula_new');
        $rutas->setDelete('planeacion_admin_crud_aula_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_aula_edit');
        $rutas->setList('planeacion_admin_crud_aula_listAjax');

        $rutas->setActivar('planeacion_admin_crud_aula_activar');
        $rutas->setDesactivar('planeacion_admin_crud_aula_desactivar');
        $rutas->setExportPDF('planeacion_admin_crud_aula_export_pdf');
        $rutas->setExportXls('planeacion_admin_crud_aula_export_xls');
        return $rutas;
    }
    public function constructData()
    {
        $this->datos= $this->getRepo()->listTable($this->getTableFiltersByRquest(),$this->getTableSortByRequest());

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getNombre();
            $tmpArray[] = $row->getCapacidad();
            $tmpArray[] = Util::boolean($row->getActivo());
            $tmpArray[] = Util::boolean($row->getEnLinea());
//            $tmpArray[] = $row->getPermisionListString();
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('nombre','capacidad','activo');
    }
}