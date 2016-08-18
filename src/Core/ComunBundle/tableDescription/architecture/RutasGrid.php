<?php

namespace Core\ComunBundle\tableDescription\architecture;

class RutasGrid {

    protected $new;
    protected $delete;
    protected $edit;
    protected $list;
    protected $details;
    protected $next;
    protected $preview;
    protected $activar;
    protected $desactivar;
    protected $exportPDF;
    protected $exportEmail;
    protected $exportXls;
    /**
     * @return mixed
     */
    public function getExportEmail()
    {
        return $this->exportEmail;
    }

    /**
     * @param mixed $exportPDF
     */
    public function setExportXls($exportXls)
    {
        $this->exportXls = $exportXls;
    }

    public function getExportXls()
    {
        return $this->exportXls;
    }

    /**
     * @param mixed $exportPDF
     */
    public function setExportEmail($exportEmail)
    {
        $this->exportEmail = $exportEmail;
    }

    /**
     * @return mixed
     */
    public function getExportPDF()
    {
        return $this->exportPDF;
    }

    /**
     * @param mixed $exportPDF
     */
    public function setExportPDF($exportPDF)
    {
        $this->exportPDF = $exportPDF;
    }



    /**
     * @return mixed
     */
    public function getActivar()
    {
        return $this->activar;
    }

    /**
     * @param mixed $activar
     */
    public function setActivar($activar)
    {
        $this->activar = $activar;
    }

    /**
     * @return mixed
     */
    public function getDesactivar()
    {
        return $this->desactivar;
    }

    /**
     * @param mixed $desactivar
     */
    public function setDesactivar($desactivar)
    {
        $this->desactivar = $desactivar;
    }

    /**
     * @return mixed
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param mixed $edit
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;
    }
    /**
     * @return mixed
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param mixed $edit
     */
    public function setNext($next)
    {
        $this->next = $next;
    }

    /**
     * @return mixed
     */
    public function getEdit()
    {
        return $this->edit;
    }

    /**
     * @param mixed $edit
     */
    public function setEdit($edit)
    {
        $this->edit = $edit;
    }


    /**
     * @return mixed
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * @param mixed $delete
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param mixed $list
     */
    public function setList($list)
    {
        $this->list = $list;
    }

    /**
     * @return mixed
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * @param mixed $new
     */
    public function setNew($new)
    {
        $this->new = $new;
    }

}

?>
