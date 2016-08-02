<?php

namespace ADEPSOFT\ComunBundle\tableDescription\architecture;

class RutasTree{

    protected $new;
    protected $delete;
    protected $edit;
    protected $list;
    protected $details;
    protected $move;

    /**
     * @return mixed
     */
    public function getMove()
    {
        return $this->move;
    }

    /**
     * @param mixed $move
     */
    public function setMove($move)
    {
        $this->move = $move;
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
