<?php

namespace ADEPSOFT\Planeacion\AdminBundle\TableDescription;


use ADEPSOFT\ComunBundle\tableDescription\architecture\GridColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\RutasGrid;
use ADEPSOFT\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\TableModel;
use ADEPSOFT\ComunBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;

class PlanEstudioTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'ADEPSOFT\Planeacion\AdminBundle\Entity\PlanEstudio';
        $this->name="Planes de estudio";
        $this->editTitle="plan de estudio";
        $this->hasActive = true;
        $this->setIcon('fa fa-stack-overflow');
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Nombre", '18%','nombre');
        $licColumn = new GridColumn("Licenciatura", '18%','licenciatura');
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
        $filter->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Licenciatura")->findAll());
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
            $tmpArray[] = $row->getLicenciatura()->getNombre();
            $tmpArray[] = Util::boolean($row->getActivo());
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('nombre','licenciatura','activo');
    }
}
