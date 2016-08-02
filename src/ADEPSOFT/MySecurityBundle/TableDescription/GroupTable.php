<?php

namespace ADEPSOFT\MySecurityBundle\TableDescription;


use ADEPSOFT\ComunBundle\tableDescription\architecture\GridColumn;
use ADEPSOFT\ComunBundle\tableDescription\architecture\TableModel;
use Doctrine\ORM\Mapping as ORM;

class GroupTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'ADEPSOFT\MySecurityBundle\Entity\Grupo';
        $this->name="Roles";
        $this->editTitle="rol";
        $this->extraActions = implode(",",array("gestionar_permisos"));
//        $this->tableId="grouptableid";
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Nombre", '50%','name');
        $nameColumn->setDefaultOrder(true);
//        $nameColumn->setFilterType('check');
        $this->columns[] =$nameColumn;

//        $permisoColumn = new GridColumn("Permisos", '30%','permiso.id');
//        $permisoColumn->setSortable(false);
//        $filterData = new SelectFilterColumn();
//        $filterData->setData($this->getPermisoFilterData());
//        $permisoColumn->setFilterType('select');
//        $permisoColumn->setFilterData($filterData);
//        $this->columns[] = $permisoColumn;
    }
    public function getPermisoFilterData()
    {
        return $this->getRepo('MySecurityBundle:Permission')->filterObjects();
    }
    public function defineActions()
    {
        $actions = parent::defineActions();
//        $actions = array();
        $actions[] = "GestionarPermisos";
        return $actions;
//        return array();
    }
    public function defineRutas()
    {
        $rutas =new GroupRutas();
        $rutas->setNew('security_crud_group_new');
        $rutas->setDelete('security_crud_group_delete');
//        $rutas->setDetails('security_crud_group_details');
        $rutas->setEdit('security_crud_group_edit');
        $rutas->setList('security_crud_group_listAjax');
        $rutas->setPermisos('security_crud_group_permisos');
        return $rutas;
    }
    public function constructData()
    {
        $this->datos= $this->getRepo()->obtenerTodos($this->getTableFiltersByRquest(),$this->getTableSortByRequest());

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getName();
//            $tmpArray[] = $row->getPermisionListString();
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function getBotonGestionarPermisos($text = "Gestionar permisos")
    {
        return $this->makeButton($text, "fa-tasks","gestionar_permisos");
//        return '<a class="btn btn-large gestionar_permisos tooltips" action="gestionar_permisos" data-original-title="Gestionar permisos" style="padding-bottom: 0px; padding-top: 0px" data-placement="top"> <i action="gestionar_permisos" class="fa fa-lock" style="text-decoration: underline"></i> </a>';
    }
    public function mapSorts()
    {
        return array('name');
    }
}