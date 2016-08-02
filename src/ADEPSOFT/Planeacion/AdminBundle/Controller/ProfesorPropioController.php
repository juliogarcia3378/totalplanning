<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Controller;

use ADEPSOFT\Planeacion\AdminBundle\Entity\GradoAcademico;

class ProfesorPropioController extends ProfesorController
{
    protected $editView='@PlaneacionAdmin/Profesor/hoja_propia.html.twig';
     public function editAction()
     {
         return parent::editAction();
     }
}
