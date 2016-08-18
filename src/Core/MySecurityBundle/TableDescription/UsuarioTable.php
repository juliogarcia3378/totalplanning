<?php

namespace Core\MySecurityBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Core\ComunBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;

class UsuarioTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\MySecurityBundle\Entity\Usuario';
        $this->name="Usuarios";
        $this->editTitle="usuario";
//        $this->modal=false;
        $this->extraActions = "gestionar_permisos,gestionar_roles,establecer_pass";
        $this->icon = 'fa fa-user';
        $this->hasActive = true;
        $this->activoFeld="enabled";
//        $this->tableId="usuariotableid";
    }
    /**
     * Metodo Obligatorio de sobreescribir
     * @return RutasGrid
     */
    public function defineRutas()
    {
        $rutas =new UsuarioRutas();
        $rutas->setNew('security_crud_user_new');
        $rutas->setDelete('security_crud_user_delete');
//        $rutas->setDetails('security_crud_user_details');
        $rutas->setEdit('security_crud_user_edit');
        $rutas->setList('security_crud_user_listAjax');
        $rutas->setPermisos('security_crud_user_permisos');
        $rutas->setRoles('security_crud_user_roles');
        $rutas->setEstablecerPass("security_crud_user_set_pass");
        $rutas->setActivar('security_crud_user_change_pass_activar');
        $rutas->setDesactivar('security_crud_user_change_pass_desactivar');
//        $rutas->setInstancias('security_crud_user_assign_instancia');

        return $rutas;
    }
    public function defineColumns() {
        $nameColumn = new GridColumn("Usuario", '10%','username');
//        $nameColumn->setDefaultOrder(true);
        $this->columns[] =$nameColumn;

        $nameColumn = new GridColumn("Identificación", '10%','cedula');
        $this->columns[] =$nameColumn;

        $nameColumn = new GridColumn("Nombre completo", '20%','nombre');
        $this->columns[] =$nameColumn;

        $nameColumn = new GridColumn("Correo", '10%','emailCanonical');
        $this->columns[] =$nameColumn;

        $activoColumn = new GridColumn("Activo", '1%','enabled');

        $filter = new SelectFilterColumn();
        $filter->setData(array(
                array('id'=>1,'nombre'=>"Sí"),
                array('id'=>0,'nombre'=>"No")
            )
        );
        $activoColumn->setFilterType('select');
        $activoColumn->setFilterData($filter);

        $this->columns[]=$activoColumn;


    }
    public function defineActions()
    {
        $actions = parent::defineActions();
        $actions[] = "GestionarPermisos";
        $actions[] = "GestionarRoles";
        $actions[] = "EstablecerPass";
        return $actions;
    }
    public function constructData()
    {
        $order = $this->getTableSortByRequest();
//        ldd($order);
        if(count($order) == 0)
            $order['id']='desc';
        $this->datos= $this->getRepo()->listAllFiltered($this->getTableFiltersByRquest(),$order);

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getUserName();
            $tmpArray[] = $row->getCedula();
            $tmpArray[] = $row->getNombre();
            $tmpArray[] = $row->getEmail();
            $tmpArray[] = Util::boolean($row->isEnabled());
            $result[]=$tmpArray;
        }
        return $result;

    }
    public function getBotonGestionarPermisos($text = "Asignación de permisos")
    {
        return $this->makeButton($text,"fa-tasks","gestionar_permisos");
//        return '<a class="btn btn-large gestionar_permisos tooltips"  style="padding-bottom: 0px; padding-top: 0px"  action="gestionar_permisos" data-original-title="Gestioanr permisos" data-placement="top"> <i class="fa fa-lock" style="text-decoration: underline" action="gestionar_permisos"></i> </a>';
    }
    public function getBotonEstablecerPass($text = "Establecer contraseña")
    {
        return $this->makeButton($text,"fa-lock","establecer_pass");
//        return '<a class="btn btn-large gestionar_roles tooltips" style="padding-bottom: 0px; padding-top: 0px"  action="gestionar_roles" data-original-title="Gestionar roles" data-placement="top"> <i class="fa fa-group" style="text-decoration: underline" action="gestionar_roles" ></i> </a>';
    }
    public function getBotonGestionarRoles($text = "Asignación de roles")
    {
        return $this->makeButton($text,"fa-group","gestionar_roles");
//        return '<a class="btn btn-large gestionar_roles tooltips" style="padding-bottom: 0px; padding-top: 0px"  action="gestionar_roles" data-original-title="Gestionar roles" data-placement="top"> <i class="fa fa-group" style="text-decoration: underline" action="gestionar_roles" ></i> </a>';
    }
    public function mapSorts()
    {
        return array('username','cedula','canonic_name','emailCanonical','enabled');
    }
}
