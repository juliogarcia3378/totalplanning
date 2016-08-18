<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Core\ComunBundle\Util\ResultType;
use Core\ComunBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;

class CategoryProfessorTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\Categoria';
        $this->name="Categoria de los Profesores";
        $this->editTitle="Categoria";
        $this->setIcon('fa fa-clock-o');
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Nombre", '25%','nombre','text');
        $nameColumn->setDefaultOrder(true);

        
        
        $this->columns[] =$nameColumn;

    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_category_professor_new');
        $rutas->setDelete('planeacion_admin_crud_category_professor_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_category_professor_edit');
        $rutas->setList('planeacion_admin_crud_category_professor_listAjax');
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