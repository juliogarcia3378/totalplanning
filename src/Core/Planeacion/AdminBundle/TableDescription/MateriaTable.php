<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\ReportField;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Core\ComunBundle\Util\Util;
use Core\ComunBundle\Util\UtilRepository2Config;
use Doctrine\ORM\Mapping as ORM;

class MateriaTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\Materia';
        $this->name="Materias";
        $this->editTitle="materia";
        $this->hasActive = true;
        $this->hasExport=true;
        $this->expandable=false;
        $this->advancedSearchView = 'planeacion_admin_crud_materia_filtro_avanzado_view';
        $this->hasXlsExport=true;
        $this->setIcon('fa fa-book');
    }
    public function defineColumns() {
        $claveColumn = new GridColumn("Clave", '6%','clave');
        $nameColumn = new GridColumn("Nombre", '25%','nombre');
        $planEstudio = new GridColumn("Plan Estudio", '15%','planEstudio');
        $frecuenciaColumn = new GridColumn("Frec.", '5%','frecuenciaSemanal');

        $tipoColumn = new GridColumn("Tipo", '5%','tipoMateria','select','tipoMateria.nombre');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getRepo('PlaneacionAdminBundle:TipoMateria')->filterObjects(array(),array('id'=>'asc')));
        $tipoColumn->setFilterData($filterData);

        $semestreColumn = new GridColumn("Semestre", '5%','materia.semestre');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getRepo('PlaneacionAdminBundle:Semestre')->filterObjects(array(),array('id'=>'asc')));
        $semestreColumn->setFilterType('select');
        $semestreColumn->setFilterData($filterData);
        $semestreColumn->setDefaultOrder(true);

        $filterData = new SelectFilterColumn();
        $filterData->setShowValue('texto');
        $filterData->setData($this->getRepo('PlaneacionAdminBundle:PlanEstudio')->filterObjects());
        $planEstudio->setFilterType('select');
        $planEstudio->setFilterData($filterData);

        $activoColumn = new GridColumn("Activa", '1%','activo');

        $filter = new SelectFilterColumn();
        $filter->setData(array(
                array('id'=>1,'nombre'=>"Sí"),
                array('id'=>0,'nombre'=>"No")
            )
        );
        $activoColumn->setFilterType('select');
        $activoColumn->setFilterData($filter);

        $this->columns[] =$claveColumn;
        $this->columns[] =$nameColumn;
        $this->columns[] =$planEstudio;
        $this->columns[] =$semestreColumn;
        $this->columns[] =$frecuenciaColumn;
        $this->columns[] =$tipoColumn;
        $this->columns[] =$activoColumn;

    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_materia_new');
        $rutas->setDelete('planeacion_admin_crud_materia_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_materia_edit');
        $rutas->setList('planeacion_admin_crud_materia_listAjax');
        $rutas->setActivar('planeacion_admin_crud_materia_activar');
        $rutas->setDesactivar('planeacion_admin_crud_materia_desactivar');
        $rutas->setExportPDF('planeacion_admin_crud_materia_export_pdf');
        $rutas->setExportXLS('planeacion_admin_crud_materia_export_xls');
        return $rutas;
    }

    public function constructReportData($filters=Array(),$order=null)
    {
        UtilRepository2Config::$paginate=false;
        $objs = $this->getRepo()->listTable($filters,$order);
       // $objs = $this->getRepo()->filterObjects($filters,$order);
        return $objs;
    }
    public function getReportFields()
    {
        $clave= new ReportField(true,'Clave');
        $nombre = new ReportField(true,'Nombre');
        $planEstudio =new ReportField(true,'Plan de Estudio');
        $semestre = new ReportField(false,'Semestre');
        $frecuencia= new ReportField(false,'Frecuencia');
        $tipo = new ReportField(false,'Tipo');
        
        $r=array();
        $r['nombre']=$nombre;
        $r['clave']=$clave;
        $r['planEstudio']=$planEstudio;
        $r['semestre']=$semestre;
        $r['frecuenciaSemanal']=$frecuencia;
        $r['tipoMateria']=$tipo;
        
        return $r;
    }
    public function constructData()
    {
        $this->datos= $this->getRepo()->listTable($this->getTableFiltersByRquest(),$this->getTableSortByRequest());
        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getClave();
            $tmpArray[] = $row->getNombre();
            if($row->getPlanEstudio() != null)
                $tmpArray[] = $row->getPlanEstudio()->getTexto();
            else
                $tmpArray[] = Util::text(null);
            if($row->getSemestre() == null)
                $tmpArray[] = Util::text(null);
            else
                $tmpArray[] = $row->getSemestre()->getNombre();
            $tmpArray[] = $row->getFrecuenciaSemanal();
            $tmpArray[] = $row->getTipoMateria()->getNombre();
            $tmpArray[] = Util::boolean($row->getActivo());
//            $tmpArray[] = $row->getPermisionListString();
            $result[]=$tmpArray;
        }
        return $result;

    }


    public function mapSorts()
    {
        return array('materia.clave','materia.nombre','materia.planEstudio','materia.semestre','materia.frecuenciaSemanal','materia.tipoMateria.nombre','materia.activo');
    }
}
