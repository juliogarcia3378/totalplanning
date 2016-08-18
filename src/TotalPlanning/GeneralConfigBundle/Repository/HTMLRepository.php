<?php

namespace TotalPlanning\GeneralConfigBundle\Repository;
use Doctrine\ORM\Mapping as ORM;

class HTMLRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{

    public function getPortada()
    {
        $portada_html = $this->getRepo("GeneralConfigBundle:InnerHTML")->findBy(array('denominacion' => "portada_html"));
        if (count($portada_html) > 0)
        {
            $portada_html = $portada_html[0];
            return $portada_html;
        }
            return null;
    }




}