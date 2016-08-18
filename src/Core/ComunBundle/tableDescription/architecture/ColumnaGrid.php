<?php

namespace Core\ComunBundle\tableDescription\architecture;

class ColumnaGrid {

    private $nombre;
    private $oculta;
    private $ancho;
    private $alineacion;
    private $marcartodos;
    protected $filterName=null;
    protected $filterType='text';
    protected $filterData=array();


    function __construct($pNombre, $pOculta = false, $pAncho = null, $filterName=null,$pAlineacion = null, $pMarcarTodos = false) {
        $this->nombre = $pNombre;
        $this->oculta = $pOculta;
        if ($pAncho != null)
            $this->ancho = $pAncho;
        if ($pAlineacion != null)
            $this->alineacion = $pAlineacion;
        else $this->alineacion = 'izq';
        $this->marcartodos = $pMarcarTodos;
        $this->filterName = $filterName;
    }

    /**
     * @return array
     */
    public function getFilterData()
    {
        return $this->filterData;
    }

    /**
     * @param array $filterData
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

    public function getOculta() {
        return $this->oculta;
    }

    public function setOculta($oculta) {
        $this->oculta = $oculta;
    }

    public function getAncho() {
        return $this->ancho;
    }

    public function setAncho($ancho) {
        $this->ancho = $ancho;
    }

    public function getAlineacion() {
        return $this->alineacion;
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
