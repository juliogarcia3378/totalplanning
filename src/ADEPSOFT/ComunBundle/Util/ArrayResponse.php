<?php

namespace ADEPSOFT\ComunBundle\Util;

use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @author Franklin Rivero <frrivero@uci.cu>
 */
class ArrayResponse extends Response
{
    protected $data = array();

    function __construct($data)
    {
        parent::__construct();
        $this->data=$data;
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

}
