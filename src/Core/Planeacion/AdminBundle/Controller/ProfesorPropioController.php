<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\Planeacion\AdminBundle\Entity\GradoAcademico;

class ProfesorPropioController extends ProfesorController
{
    protected $editView='@PlaneacionAdmin/Profesor/hoja_propia.html.twig';
     public function editAction()
     {
         return parent::editAction();
     }
}
