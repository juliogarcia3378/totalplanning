<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Core\ComunBundle\Util\UtilRepository2;
use Core\Planeacion\AdminBundle\Entity\ProfePeriodo;
use Core\Planeacion\AdminBundle\Enums\ECategoria;
use Doctrine\ORM\Mapping as ORM;

class ProfesorHorariosTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\ProfePeriodo';
        $this->extraActions = "exportar_horario";
        $this->name="Horarios";
        $this->editTitle="horario";
        $this->modal = false;
        $this->expandable = true;
        $this->setIcon('fa fa-calendar');
    }
    public function defineActions()
    {
        $actions = parent::defineActions();
        $actions[] = "ExportarHorario";
     //   $actions[] = "DescargarProfesor";
        return $actions;
    }
    public function getBotonExportarHorario($text = "Exportar horario")
    {
        return $this->makeButtonNoEvent($text,"fa-file","exportar_horario");
//        return '<a class="btn btn-large gestionar_permisos tooltips"  style="padding-bottom: 0px; padding-top: 0px"  action="gestionar_permisos" data-original-title="Gestioanr permisos" data-placement="top"> <i class="fa fa-lock" style="text-decoration: underline" action="gestionar_permisos"></i> </a>';
    }
    public function getBotonDescargarProfesor($text = "Descargar Profesor")
    {
        return $this->makeButtonNoEvent($text,"fa-file","descargar_profesor");
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Período", '20%','periodo','select',array('profePeriodo.periodo','desc'));

//        $claveColumn = new GridColumn("Horario", '20%');
//        $claveColumn->setSortable(false);

        $materias = new GridColumn("Materias asignadas", '25%','materia.id');
        $materias->setSortable(false);

        $nameColumn->setDefaultOrder(true);

        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getRepo('PlaneacionAdminBundle:Periodo')->filterObjects(array(),array('anno'=>'desc','periodo.tipoPeriodo'=>'asc')));
        $nameColumn->setFilterType('select');
        $filterData->setShowValue('abreviado');
        $nameColumn->setFilterData($filterData);

        $filterData = new SelectFilterColumn();
        $filterData->setShowValue('texto');
        $filterData->setData($this->getRepo('PlaneacionAdminBundle:Materia')->filterObjects());
        $materias->setFilterType('select');
        $materias->setFilterData($filterData);

        $this->columns[] =$nameColumn;
        $this->columns[] =$materias;
//        $this->columns[] =$claveColumn;

    }
    public function detailData(){
        $result = array();
//        return $result;
    //  ldd($this->datos );
        foreach($this->datos as $row)
        {
            /**
             * @var $row ProfePeriodo
             */
            $detailData = array();
            $datosS = array();
            $datosS['Asistencia semestre anterior'] = $row->getAsistenciaSemAnterior();
            $datosS['Horas que debe cubrir'] = $row->getHorasCubrir();
            if($row->getProfesor()->getCategoria()->getId() == ECategoria::TiempoCompleto)
                $datosS['Descarga antigüedad'] = $row->getDescargaAnt();
            $datosS['Descarga administrativa'] = $row->getDescargaADMVA();
            $datosS['Horas asignadas'] = $row->getHorasAsignadas();

            $periodo = $row->getPeriodo()->getId();
            $id = $row->getId();

            $detailData[] = array('name'=>'#twig','value'=>$this->container->get('templating')->render('@PlaneacionAdmin/ProfesorHorario/detail_profe_periodo.twig',array(
                'datosS'=>$datosS,
                'periodo'=>$periodo,
                'id'=>$id
            )));
            $result[]=$detailData;
        }
        return $result;
    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_profesor_horario_new');
        $rutas->setDelete('planeacion_admin_crud_profesor_horario_delete');
     //  $rutas->setDetails('planeacion_admin_crud_profesor_horario_details');
        $rutas->setEdit('planeacion_admin_crud_profesor_horario_edit');
        $rutas->setList('planeacion_admin_crud_profesor_horario_listAjax');
        return $rutas;
    }
    public function constructData()
    {
        $filters= $this->getTableFiltersByRquest();
        $filters['profesor'] = UtilRepository2::getContainer()->get('request')->get('idProfe');
        $this->datos= $this->getRepo()->datosTabla($filters,$this->getTableSortByRequest());

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray = array();
            $tmpArray[] = $row->getPeriodo()->getAbreviado();
            $tmpArray[] = $row->getMateriaStringList();
            $result[] = $tmpArray;
        }
        return $result;
    }

    public function mapSorts()
    {
        return array('profePeriodo.periodo','horasAsignadas');
    }
}