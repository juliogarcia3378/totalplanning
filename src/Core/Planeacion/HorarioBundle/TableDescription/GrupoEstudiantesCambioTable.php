<?php

namespace Core\Planeacion\HorarioBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\ReportField;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Core\ComunBundle\Util\ResultType;
use Core\ComunBundle\Util\UtilRepository2Config;
use Doctrine\ORM\Mapping as ORM;

class GrupoEstudiantesCambioTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\GrupoEstudiantesCambio';
        $this->name="Distribucion con Cambios";
        $this->editTitle="Distribucion con Cambios";
        $this->hasExport=true;
        $this->hasXlsExport=true;
        $this->setIcon('fa fa-minus-square');
    }
    public function getReportFields()
    {
       // $semestreAc= new ReportField(true,'Semestre Actual');
        $periodo= new ReportField(false,'Periodo');
        $turno = new ReportField(true,'Turno');
        $licenciatura= new ReportField(true,'Licenciatura');
        $aula= new ReportField(true,'Aula');

        $r=array();
       // $r['semestre']=$semestreAc;
        $r['periodo']=$periodo;
        $r['turno']=$turno;
        $r['licenciatura']=$licenciatura;
        $r['aula']=$aula;
        return $r;
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Semestre 2/15", '5%','semestre','select',array('distribucionCambio.anterior.semestre','desc'));
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getRepo('PlaneacionAdminBundle:Semestre')->filterObjects(array(),array()));
        $nameColumn->setFilterType('select');
        $nameColumn->setFilterData($filterData);

        $nameColumn4 = new GridColumn("Semestre 1/16", '5%','semestre','select',array('distribucionCambio.actual.semestre','desc'));
        $filterData4 = new SelectFilterColumn();
        $filterData4->setData($this->getRepo('PlaneacionAdminBundle:Semestre')->filterObjects(array(),array()));
        $nameColumn4->setFilterType('select');
        $nameColumn4->setFilterData($filterData4);

        $nameColumn1 = new GridColumn("Turno", '5%','turno','select',array('distribucionCambio.turno','desc'));
        $filterData1 = new SelectFilterColumn();
        $filterData1->setData($this->getRepo('PlaneacionAdminBundle:Turno')->filterObjects(array(),array()));
        $nameColumn1->setFilterType('select');
        $nameColumn1->setFilterData($filterData1);

        $nameColumn2 = new GridColumn("Licenciatura", '20%','licenciatura','select',array('distribucionCambio.licenciatura','desc'));
        $filterData2 = new SelectFilterColumn();
        $filterData2->setData($this->getRepo('PlaneacionAdminBundle:Licenciatura')->filterObjects(array(),array()));
        $nameColumn2->setFilterType('select');
        $nameColumn2->setFilterData($filterData2);

        $nameColumn3 = new GridColumn("Aula 1/2015", '10%','aula','select',array('distribucionCambio.aula','desc'));
        $filterData3 = new SelectFilterColumn();
        $filterData3->setData($this->getRepo('PlaneacionAdminBundle:Aula')->filterObjects(array(),array()));
        $nameColumn3->setFilterType('select');
        $nameColumn3->setFilterData($filterData3);

        $nameColumn5 = new GridColumn("Aula 2/16", '10%','aula','select',array('distribucionCambio.aula','desc'));
        $filterData5 = new SelectFilterColumn();
        $filterData5->setData($this->getRepo('PlaneacionAdminBundle:Aula')->filterObjects(array(),array()));
        $nameColumn5->setFilterType('select');
        $nameColumn5->setFilterData($filterData5);

        $nameColumn6 = new GridColumn("Nivel 2/15", '10%','nivel','select',array('distribucionCambio.anterior.nivel','desc'));
        $filterData6 = new SelectFilterColumn();
      //  $filterData5->setData($this->getRepo('PlaneacionAdminBundle:Au')->filterObjects(array(),array()));
        $nameColumn6->setFilterType('text');
        $nameColumn6->setFilterData($filterData6);

        $nameColumn7 = new GridColumn("Baja", '10%','nivel','select',array('distribucionCambio.actual.nivel','desc'));
        $filterData7 = new SelectFilterColumn();
        $nameColumn7->setFilterType('text');

        $nameColumn8 = new GridColumn("Aula 2/16", '10%','aula','select',array('distribucionCambio.aula','desc'));
        $filterData8 = new SelectFilterColumn();
        $filterData8->setData($this->getRepo('PlaneacionAdminBundle:Aula')->filterObjects(array(),array()));
        $nameColumn8->setFilterType('text');
        $nameColumn8->setFilterData($filterData5);

        $this->columns[] =$nameColumn;
        $this->columns[] =$nameColumn4;
        $this->columns[] =$nameColumn1;
        $this->columns[] =$nameColumn2;
        $this->columns[] =$nameColumn3;
        $this->columns[] =$nameColumn5;
        $this->columns[] =$nameColumn6;
        $this->columns[] =$nameColumn7;
        $this->columns[] =$nameColumn8;

    }

    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_horario_crud_cambio_new');
        $rutas->setDelete('planeacion_horario_crud_cambio_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_horario_crud_cambio_edit');
        $rutas->setList('planeacion_horario_crud_cambio_listAjax');
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

            $tmpArray[] = $row->getAnterior()->getSemestre()->getNombre();
            $tmpArray[] = $row->getActual()->getSemestre()->getNombre();
            $tmpArray[] = $row->getActual()->getTurno()->getNombre();
            $tmpArray[] = $row->getActual()->getLicenciatura()->getNombre();
            $tmpArray[] = $row->getAnterior()->getAula()->getNombre();
            $tmpArray[] = $row->getActual()->getAula()->getNombre();
            $tmpArray[] = $row->getAnterior()->getNivel();
            $tmpArray[] = $row->getAnterior()->getNivel()-$row->getActual()->getNivel();
            $tmpArray[] = $row->getActual()->getNivel();
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        //return array('descargaAdministrativa.periodo','descargaAdministrativa.profesor');
    }

    public function constructReportData($filters=Array(),$order=null)
    {

        UtilRepository2Config::$paginate=false;
        $objs = $this->getRepo()->filterObjects($filters,$order);
        return $objs;
    }

}