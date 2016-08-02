<?php

namespace ADEPSOFT\ComunBundle\tableDescription\architecture;

class SelectFilterColumn {

    private $showValue='nombre';
    private $multiSelect = false;
    private $idValue='id';
    private $data=array();
    private $grouped = false;

    function __construct($idValue='id', $showValue='nombre')
    {
        $this->idValue = $idValue;
        $this->showValue = $showValue;
    }

    /**
     * @return boolean
     */
    public function isGrouped()
    {
        return $this->grouped;
    }

    /**
     * @param boolean $grouped
     */
    public function setGrouped($grouped)
    {
        $this->grouped = $grouped;
    }


    /**
     * @return boolean
     */
    public function isMultiSelect()
    {
        return $this->multiSelect;
    }

    /**
     * @param boolean $multiSelect
     */
    public function setMultiSelect($multiSelect)
    {
        $this->multiSelect = $multiSelect;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getIdValue()
    {
        return $this->idValue;
    }

    /**
     * @param string $idValue
     */
    public function setIdValue($idValue)
    {
        $this->idValue = $idValue;
    }

    /**
     * @return string
     */
    public function getShowValue()
    {
        return $this->showValue;
    }

    /**
     * @param string $showValue
     */
    public function setShowValue($showValue)
    {
        $this->showValue = $showValue;
    }

}

?>
