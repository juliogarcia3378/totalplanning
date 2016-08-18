<?php

namespace Core\MySecurityBundle\Controller;


use Core\ComunBundle\Controller\BaseController;
use Core\ComunBundle\Controller\MyCRUDController;
use Core\ComunBundle\Util\Util;
use Core\MySecurityBundle\Entity\Usuario;
use Core\MySecurityBundle\Form\EstablishPassType;
use Core\MySecurityBundle\Form\UsuarioEditType;
use Core\MySecurityBundle\Form\UsuarioType;
use Core\MySecurityBundle\TableDescription\UserGroupTable;
use Core\MySecurityBundle\TreeDescription\UserPermissionTree;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MyProfileController extends BaseController

{


    //render the view profile's main view
    public function indexAction()
    {
        return $this->render('MySecurityBundle:MyProfile:index.html.twig');
    }

    //render the view profile's usser account
    public function detailsAction()
    {
        return $this->render('MySecurityBundle:MyProfile:account_details.html.twig');
    }


}
