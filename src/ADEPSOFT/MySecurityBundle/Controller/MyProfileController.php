<?php

namespace ADEPSOFT\MySecurityBundle\Controller;


use ADEPSOFT\ComunBundle\Controller\BaseController;
use ADEPSOFT\ComunBundle\Controller\MyCRUDController;
use ADEPSOFT\ComunBundle\Util\Util;
use ADEPSOFT\MySecurityBundle\Entity\Usuario;
use ADEPSOFT\MySecurityBundle\Form\EstablishPassType;
use ADEPSOFT\MySecurityBundle\Form\UsuarioEditType;
use ADEPSOFT\MySecurityBundle\Form\UsuarioType;
use ADEPSOFT\MySecurityBundle\TableDescription\UserGroupTable;
use ADEPSOFT\MySecurityBundle\TreeDescription\UserPermissionTree;
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
