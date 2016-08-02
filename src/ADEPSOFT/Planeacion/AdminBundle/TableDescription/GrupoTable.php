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
use ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes;
use Doctrine\ORM\Mapping as ORM;

class GrupoTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes';
        $this->extraActions = "exportar_horario";
        $this->name="Grupos";
        $this->expandable=true;
        $this->editTitle="grupo";
        $this->hasExport=true;
        $this->hasXlsExport=true;
    }
    public function defineActions()
    {
        $actions = parent::defineActions();
        $actions[] = "ExportarHorario";
        return $actions;
    }
    public function getBotonExportarHorario($text = "Exportar horario")
    {
        return $this->makeButtonNoEvent($text,"fa-file","exportar_horario");
//        return '<a class="btn btn-large gestionar_permisos tooltips"  style="padding-bottom: 0px; padding-top: 0px"  action="gestionar_permisos" data-original-title="Gestioanr permisos" data-placement="top"> <i class="fa fa-lock" style="text-decoration: underline" action="gestionar_permisos"></i> </a>';
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Nombre", '5%','nombre');
        $nivelColumn = new GridColumn("Nivel", '5%','nivel');

//        ldd($this->getEm()->getRepository("PlaneacionAdminBundle:Semestre")->filterObjects(array()),array('id'=>'asc'));
        $semestreColumn = new GridColumn("Semestre", '1%','semestre','select');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Semestre")->filterObjects(array(),array('id'=>'asc')));
        $semestreColumn->setFilterData($filterData);

        $licColumn = new GridColumn("Licenciatura", '1%','licenciatura','select');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Licenciatura")->findAll());
        $licColumn->setFilterData($filterData);

        $turnoColumn = new GridColumn("Turno", '1%','turno','select');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Turno")->filterObjectsActivo());
        $turnoColumn->setFilterData($filterData);

        $periodoColumn = new GridColumn("Período", '1%','periodo','select');
        $periodoColumn->setDefaultOrder(true);
        $filterData = new SelectFilterColumn();
        $filterData->setShowValue('abreviado');
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Periodo")->findAll());
        $periodoColumn->setFilterData($filterData);

        $aulaColumn = new GridColumn("Aula", '1%','aula','select');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Aula")->filterObjectsActivo());
        $aulaColumn->setFilterData($filterData);

        $campusColumn = new GridColumn("Campus", '6%','campus','select');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Campus")->filterObjects());
        $campusColumn->setFilterData($filterData);

        $activoColumn = new GridColumn("Bilingüe", '1%','bilingue');

        $filter = new SelectFilterColumn();
        $filter->setData(array(
                array('id'=>1,'nombre'=>"Sí"),
                array('id'=>0,'nombre'=>"No")
            )
        );
        $activoColumn->setFilterType('select');
        $activoColumn->setFilterData($filter);

        $tercerosColumn = new GridColumn("Terceros", '1%','terceros');
        $filter = new SelectFilterColumn();
        $filter->setData(array(
                array('id'=>1,'nombre'=>"Sí"),
                array('id'=>0,'nombre'=>"No")
            )
        );
        $tercerosColumn->setFilterType('select');
        $tercerosColumn->setFilterData($filter);

        $paqueteColumn = new GridColumn("Paquete", '1%','paquete');
        $filter = new SelectFilterColumn();
        $filter->setData(array(
                array('id'=>1,'nombre'=>"Sí"),
                array('id'=>0,'nombre'=>"No")
            )
        );
        $paqueteColumn->setFilterType('select');
        $paqueteColumn->setFilterData($filter);

//        $activoColumn = new GridColumn("Activo", '5%','activo');
        $planEstudioColumn = new GridColumn("Plan Estudio", '1%','planEstudio','select');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:PlanEstudio")->filterObjectsActivo());
        $planEstudioColumn->setFilterData($filterData);

        $this->columns[] =$nameColumn;
        $this->columns[] =$nivelColumn;
        $this->columns[] =$semestreColumn;
        $this->columns[] =$licColumn;
        $this->columns[] =$turnoColumn;
        $this->columns[] =$periodoColumn;
        $this->columns[] =$aulaColumn;
        $this->columns[] =$campusColumn;

        $this->columns[] =$activoColumn;
        $this->columns[] =$tercerosColumn;
        $this->columns[] =$paqueteColumn;
        $this->columns[] =$planEstudioColumn;

    }
    public function detailData(){
        $result = array();
        foreach($this->datos as $row)
        {
            $detailData = array();
            $datosS = array();
            $periodo = $row->getPeriodo()->getId();
            $id = $row->getId();

            $detailData[] = array('name'=>'#twig','value'=>$this->container->get('templating')->render('@PlaneacionAdmin/Grupo/detail_grupo_periodo.twig',array(
                'datosS'=>$datosS,
                'periodo'=>$periodo,
                'id'=>$id
            )));
            $result[]=$detailData;
        }
        return $result;
    }
    public function getFilters(&$filters)
    {
//        $filters = UtilRepository2::getRequest()->request->all();
//        ldd($filters);
        $contextoBase=Array();
        $contextoBase['Fecha']= FechaUtil::toString(FechaUtil::getFechaActual());
        if(array_key_exists('nombre',$filters) && $filters['nombre']!=null && $filters['nombre']!=""){
            $contextoBase['Nombre']='Contiene: "'.$filters['nombre'].'"';
        }
        if(array_key_exists('nivel',$filters) && $filters['nivel']!=null && $filters['nivel']!=""){
            $contextoBase['Nivel']= $filters['nivel'];
        }

        if(array_key_exists('periodo',$filters) && $filters['periodo'] != null ){
            $contextoBase['Período'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Periodo')->find($filters['periodo'])->getAbreviado();
        }
        if(array_key_exists('semestre',$filters)  &&  $filters['semestre'] != null &&  $filters['semestre'] != ""){
            $contextoBase['Semestre'] = $filters['semestre'];
        }
        if(array_key_exists('licenciatura',$filters) &&  $filters['licenciatura'] != null &&  $filters['licenciatura'] != "" ){
            $contextoBase['Licenciatura'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Licenciatura')->find($filters['licenciatura'])->getNombre();
        }
        if(array_key_exists('aula',$filters) &&  $filters['aula'] != null &&  $filters['aula'] != "" ){
            $contextoBase['Aula'] =  $this->getEm()->getRepository('PlaneacionAdminBundle:Aula')->find($filters['aula'])->getNombre();
        }
        if(array_key_exists('bilingue',$filters) &&  $filters['bilingue'] != null &&  $filters['bilingue'] != "" ){
            $contextoBase['Bilingüe'] = $filters['bilingue'];
        }
        if(array_key_exists('terceros',$filters) &&  $filters['terceros'] != null &&  $filters['terceros'] != "" ){
            $contextoBase['Terceros'] = $filters['terceros'];
        }
        if(array_key_exists('paquete',$filters) &&  $filters['paquete'] != null &&  $filters['paquete'] != "" ){
            $contextoBase['Paquete'] = $filters['paquete'];
        }
        if(array_key_exists('turno',$filters) &&  $filters['turno'] != null &&  $filters['turno'] != "" ){
            $contextoBase['Turno'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Turno')->find($filters['turno'])->getNombre();
        }
        if(array_key_exists('campus',$filters) &&  $filters['campus'] != null &&  $filters['campus'] != "" ){
            $contextoBase['Campus'] = $filters['campus'];
        }


        return array('base'=>$contextoBase);
    }
    public function constructReportData($filters=Array(),$order=null)
    {
//        $order = $this->getTableSortByRequest();
        UtilRepository2Config::$paginate=false;
//        ld($order);
        if(array_key_exists('grupoEstudiantes.periodo',$order))
        {
            $order['grupoEstudiantes.semestre']='asc';
        }
        $objs = $this->getRepo()->filterObjects($filters,$order);
//        ldd($objs);
        return $objs;
    }
    public function getReportFields()
    {
        $nombre= new ReportField(true,'Nombre');
        $nivel = new ReportField(true,'Nivel');
        $aula =new ReportField(true,'Aula');
        $semestre = new ReportField(false,'Semestre');
        $licenciatura = new ReportField(false,'Licenciatura');
        $turno = new ReportField(false,'Turno');
        $periodo = new ReportField(false,'Periodo');
        $campus = new ReportField(false,'Campus');
        $bilingue = new ReportField(false,'Bilingüe');
        $terceros = new ReportField(false,'Terceros');
        $paquete = new ReportField(false,'Paquete');
        $planEstudio = new ReportField(false,'PlanEstudio');

        $aula->setValue("aulaString");
        $r=array();
        $r['nombre']=$nombre;
        $r['nivel']=$nivel;
        $r['aula']=$aula;
        $r['semestre']=$semestre;
        $r['licenciatura']=$licenciatura;
        $r['turno']=$turno;
        $r['periodo']=$periodo;
        $r['campusname']=$campus;
        $r['bilinguetext']=$bilingue;
        $r['terceros']=$terceros;
        $r['paquete']=$paquete;
        $r['planEstudio']=$planEstudio;

        return $r;
    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_grupo_new');
        $rutas->setDelete('planeacion_admin_crud_grupo_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_grupo_edit');
        $rutas->setList('planeacion_admin_crud_grupo_listAjax');
        $rutas->setExportPDF('planeacion_admin_crud_grupo_export_pdf');
        $rutas->setExportXLS('planeacion_admin_crud_grupo_export_xls');
        return $rutas;
    }
    public function constructData()
    {
        $order = $this->getTableSortByRequest();
//        ld($order);
        if(array_key_exists('grupoEstudiantes.periodo',$order))
        {
            $order['grupoEstudiantes.semestre']='asc';
        }
        $this->datos= $this->getRepo()->filterObjects($this->getTableFiltersByRquest(),$order);

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            /**
             * @var $row GrupoEstudiantes
             */
            $tmpArray[] = $row->getNombre();
            $tmpArray[] = $row->getNivel();
            $tmpArray[] = $row->getSemestre()->getNombre();
            $tmpArray[] = $row->getLicenciatura()->getNombre();
            $tmpArray[] = $row->getTurno()->getNombre();
            $tmpArray[] = $row->getPeriodo()->getAbreviado();
            $tmpArray[] = $row->getAula()->getNombre();
            $tmpArray[] = $row->getCampus()->getNombre();

           
            $tmpArray[] = Util::boolean($row->getBilingue());
            $tmpArray[] = Util::boolean($row->getTerceros());
            $tmpArray[] = Util::boolean($row->getPaquete());
             $tmpArray[] = $row->getPlanEstudio()->getNombre();
//            $tmpArray[] = $row->getA
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('nombre','nombre','nombre','nombre','nombre','nombre','nombre','nombre','nombre','nombre','nombre','nombre');
    }
}