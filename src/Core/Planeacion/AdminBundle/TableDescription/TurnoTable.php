<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Doctrine\ORM\Mapping as ORM;

class TurnoTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\Turno';
        $this->name="Turnos";
        $this->editTitle="turno";
//        $this->hasActive = true;
        $this->setIcon('fa fa-dashboard');
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Nombre", '25%','nombre');
//        $activa = new GridColumn("Activo", '5%','activo');

        $this->columns[] =$nameColumn;

    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_turno_new');
        $rutas->setDelete('planeacion_admin_crud_turno_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_turno_edit');
        $rutas->setList('planeacion_admin_crud_turno_listAjax');

//        $rutas->setActivar('planeacion_admin_crud_turno_activar');
//        $rutas->setDesactivar('planeacion_admin_crud_turno_desactivar');
        return $rutas;
    }
    public function constructData()
    {
        $order = $this->getTableSortByRequest();
        if(count($order) == 0)
            $order['id'] = 'asc';

        $this->datos= $this->getRepo()->filterObjects($this->getTableFiltersByRquest(),$order);

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getNombre();
//            $tmpArray[] = Util::boolean($row->getActivo());
//            $tmpArray[] = $row->getPermisionListString();
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('nombre');
    }
}