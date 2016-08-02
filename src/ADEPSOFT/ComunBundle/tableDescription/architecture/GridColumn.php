<?php

namespace ADEPSOFT\ComunBundle\tableDescription\architecture;

class GridColumn {

    private $nombre;
    private $ancho;
    private $alineacion=null;
    private $marcartodos;
    protected $filterName=null;
    private $hidden=false;
    protected $filterType='text';
    protected $sortable=true;
    protected $sortName=null;
    protected $sortOrder='asc';
    protected $defaultOrder = false;
    /**
     * @var SelectFilterColumn
     */
    protected $filterData=null;


    function __construct($pNombre, $pAncho = null, $filterName=null,$filterType='text',$order=null, $hidden = false,$pAlineacion = null, $pMarcarTodos = false) {
        $this->nombre = $pNombre;
        $this->hidden = $hidden;
        if ($pAncho != null)
            $this->ancho = $pAncho;
        if ($pAlineacion != null)
            $this->alineacion = $pAlineacion;
        $this->setFilterType($filterType);
        $this->marcartodos = $pMarcarTodos;
        $this->filterName = $filterName;

        if($order == null)
            $this->sortName = $filterName;
        elseif(!is_array($order))
            $this->sortName = $order;
        else{
            $this->sortName = $order[0];
            $this->sortOrder = $order[1];
        }
    }

    /**
     * @return boolean
     */
    public function isDefaultOrder()
    {
        return $this->defaultOrder;
    }

    /**
     * @param boolean $defaultOrder
     */
    public function setDefaultOrder($defaultOrder)
    {
        $this->defaultOrder = $defaultOrder;
    }


    /**
     * @return boolean
     */
    public function isSortable()
    {
        return $this->sortable;
    }

    /**
     * @param boolean $sortable
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;
    }

    /**
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param string $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return null
     */
    public function getSortName()
    {
        return $this->sortName;
    }

    /**
     * @param null $sortName
     */
    public function setSortName($sortName)
    {
        $this->sortName = $sortName;
    }

    /**
     * @return mixed
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param mixed $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return SelectFilterColumn
     */
    public function getFilterData()
    {
        return $this->filterData;
    }

    /**
     * @param SelectFilterColumn $filterData
     */
    public function setFilterData($filterData)
    {
        $this->filterData = $filterData;
    }

    /**
     * @return string
     */
    public function getFilterType()
    {
        return $this->filterType;
    }

    /**
     * @param string $filterType
     */
    public function setFilterType($filterType)
    {
        $this->filterType = $filterType;
    }
    /**
     * @return null
     */
    public function getFilterName()
    {
        return $this->filterName;
    }

    /**
     * @param null $filterName
     */
    public function setFilterName($filterName)
    {
        $this->filterName = $filterName;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }


    public function getAncho() {
        return $this->ancho;
    }

    public function setAncho($ancho) {
        $this->ancho = $ancho;
    }

    public function getAlineacion() {
        if($this->alineacion != null) {
            $aligns = array('center' => 'text-center');
            return $aligns[$this->alineacion];
        }
        return null;
    }

    public function setAlineacion($orientacion) {
        $this->alineacion = $orientacion;
    }

    public function getMarcarTodos() {
        return $this->marcartodos;
    }

    public function setMarcarTodos($marcarTodos) {
        $this->marcartodos = $marcarTodos;
    }

}

?>
