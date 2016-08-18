<?php

namespace Core\ComunBundle\tableDescription\architecture;

class WizardGrid {

    protected $cancel;
    protected $accept;
    protected $next;
    protected $preview;
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
    public function geCancel()
    {
        return $this->cancel;
    }

    /**
     * @param mixed $cancel
     */
    public function setCancel($cancel)
    {
        $this->cancel = $cancel;
    }

    /**
     * @return mixed
     */
    public function getAccept()
    {
        return $this->accept;
    }

    /**
     * @param mixed $details
     */
    public function setAccept($acept)
    {
        $this->accept = $acept;
    }

}

?>
