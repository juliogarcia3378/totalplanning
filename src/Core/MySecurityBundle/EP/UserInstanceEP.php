<?php
namespace Core\MySecurityBundle\EP;

use STJ\BaseBundle\Entity\Distrito;
use STJ\BaseBundle\Entity\Juzgado;
use STJ\BaseBundle\Entity\Oficialia;
use STJ\BaseBundle\Entity\TipoInstancia;

class UserInstanceEP {

    /**
     * @var TipoInstancia
     */
    protected $tipoInstancia;

    /**
     * @var Distrito
     */
    protected $distrito;


    /**
     * @var Oficialia
     */
    protected $oficialia;

    /**
     * @var Juzgado
     */
    protected $juzgado;

    /**
     * @return Distrito
     */
    public function getDistrito()
    {
        return $this->distrito;
    }

    /**
     * @param Distrito $distrito
     */
    public function setDistrito($distrito)
    {
        $this->distrito = $distrito;
    }

    /**
     * @return Juzgado
     */
    public function getJuzgado()
    {
        return $this->juzgado;
    }

    /**
     * @param Juzgado $juzgado
     */
    public function setJuzgado($juzgado)
    {
        $this->juzgado = $juzgado;
    }

    /**
     * @return Oficialia
     */
    public function getOficialia()
    {
        return $this->oficialia;
    }

    /**
     * @param Oficialia $oficialia
     */
    public function setOficialia($oficialia)
    {
        $this->oficialia = $oficialia;
    }

    /**
     * @return TipoInstancia
     */
    public function getTipoInstancia()
    {
        return $this->tipoInstancia;
    }

    /**
     * @param TipoInstancia $tipoInstancia
     */
    public function setTipoInstancia($tipoInstancia)
    {
        $this->tipoInstancia = $tipoInstancia;
    }


} 