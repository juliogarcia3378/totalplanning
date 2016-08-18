<?php

namespace Core\MySecurityBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Doctrine\ORM\Mapping as ORM;

class PermissionTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\MySecurityBundle\Entity\Permission';
        $this->name="Permiso";
    }
    public function defineColumns() {
        $this->columns[] = new GridColumn("Denominación", '30%','denominacion');
        $this->columns[] = new GridColumn("Permiso", '30%','permiso');
    }
    public function constructData()
    {
        $this->datos= $this->getRepo()->filterObjects($this->getTableFiltersByRquest());

        $result = array();
        foreach ($this->datos as $row) {
            $tmpArray=array();
            $tmpArray[] = $row->getDenominacion();
            $tmpArray[] = $row->getPermiso();
            $result[]=$tmpArray;
        }
        return $result;

    }
}