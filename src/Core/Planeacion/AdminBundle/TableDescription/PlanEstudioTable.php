<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Core\ComunBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;

class PlanEstudioTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\PlanEstudio';
        $this->name="Planes de estudio";
        $this->editTitle="plan de estudio";
        $this->hasActive = true;
        $this->setIcon('fa fa-stack-overflow');
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Nombre", '18%','nombre');
        $licColumn = new GridColumn("Carrera", '18%','carrera');
        $activoColumn = new GridColumn("Activo", '5%','activo');

        $filter = new SelectFilterColumn();
        $filter->setData(array(
                                array('id'=>1,'nombre'=>"Si"),
                                array('id'=>0,'nombre'=>"No")
                              )
                        );
        $activoColumn->setFilterType('select');
        $activoColumn->setFilterData($filter);

        $licColumn->setFilterType('select');
        $filter = new SelectFilterColumn();
        $filter->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Carrera")->findAll());
        $licColumn->setFilterData($filter);

        $this->columns[] =$nameColumn;
        $this->columns[] =$licColumn;
        $this->columns[] =$activoColumn;

    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_planEstudio_new');
        $rutas->setDelete('planeacion_admin_crud_planEstudio_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_planEstudio_edit');
        $rutas->setList('planeacion_admin_crud_planEstudio_listAjax');

        $rutas->setActivar('planeacion_admin_crud_planEstudio_activar');
        $rutas->setDesactivar('planeacion_admin_crud_planEstudio_desactivar');
        return $rutas;
    }
    public function constructData()
    {
        $this->datos= $this->getRepo()->filterObjects($this->getTableFiltersByRquest(),$this->getTableSortByRequest());

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getNombre();
            $tmpArray[] = $row->getCarrera()->getNombre();
            $tmpArray[] = Util::boolean($row->getActivo());
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('nombre','carrera','activo');
    }
}
