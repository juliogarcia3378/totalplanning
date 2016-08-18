<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Doctrine\ORM\Mapping as ORM;

class IdiomaTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\Idioma';
        $this->name="Idiomas";
        $this->editTitle="idioma";
        $this->setIcon('fa fa-comment');
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Nombre", '50%','nombre');
        $nameColumn->setDefaultOrder(true);
        $this->columns[] =$nameColumn;

    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_idioma_new');
        $rutas->setDelete('planeacion_admin_crud_idioma_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_idioma_edit');
        $rutas->setList('planeacion_admin_crud_idioma_listAjax');
        return $rutas;
    }
    public function constructData()
    {
        $this->datos= $this->getRepo()->filterObjects($this->getTableFiltersByRquest(),$this->getTableSortByRequest());

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getNombre();
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('nombre');
    }
}