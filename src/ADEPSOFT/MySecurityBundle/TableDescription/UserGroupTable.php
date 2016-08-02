<?php

namespace ADEPSOFT\MySecurityBundle\TableDescription;


use ADEPSOFT\ComunBundle\tableDescription\architecture\GridColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\RutasGrid;
use ADEPSOFT\ComunBundle\tableDescription\architecture\TableModel;
use Doctrine\ORM\Mapping as ORM;

class UserGroupTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'ADEPSOFT\MySecurityBundle\Entity\Grupo';
        $this->name="Grupo";
        $this->allowAdd = false;
        $this->hasTitle = false;
        $this->hasGroupActions = false;
//        $this->tableId="grouptableid";
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Nombre", '50%','name');
        $nameColumn->setDefaultOrder(true);
        $this->columns[] =$nameColumn;
    }
    public function defineActions()
    {
        return array();
    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setList('security_crud_user_list_roles');
        return $rutas;
    }
    public function constructData()
    {
        $this->datos= $this->getRepo()->obtenerTodos($this->getTableFiltersByRquest(),$this->getTableSortByRequest());
//        $this->checkeds = $this->getRepo()->find($this->idUser)->getGroupsId();
        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getName();
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function mapSorts()
    {
        return array('name');
    }
}