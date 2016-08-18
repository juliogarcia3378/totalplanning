<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;

class CategoryProfessorController extends MyCRUDController
{
    protected $type = 'Core\Planeacion\AdminBundle\Form\CategoryProfessorType';
    protected $textProperty = 'nombre';    
//    /**
//     * @var string Servicio del table model
//     */
    protected $tableModelService = 'planeacion.admin.category_professor.tm';
}