<?php

namespace Core\MySecurityBundle\Controller;


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

class UserController extends MyCRUDController
{
    protected $type = 'Core\MySecurityBundle\Form\UsuarioType';
    protected $editType = 'Core\MySecurityBundle\Form\UsuarioEditType';
    protected $createView='MySecurityBundle:Usuario:create.html.twig';
    protected $editView='MySecurityBundle:Usuario:create.html.twig';
    protected $view = "MySecurityBundle:Usuario:usuario_crud.html.twig";
    protected $textProperty = 'username';

    /**
     * @var string Servicio del table model
     */
    protected $tableModelService = 'security.usuario.tm';
    /**
     * @return Response
     */
    public function editAction()
    {
        $op = 'edit';
        $obj =$this->getEm()->find("MySecurityBundle:Usuario",$this->getParameter('id'));
        $form = $this->createForm(new $this->editType(), $obj);

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if($form->isValid()) {
                $this->get('fos_user.user_manager')->updateUser($obj);

                $this->getEm()->flush();
                $model  =$this->get($this->tableModelService);
                return new JsonResponse(array("success" => true, "sStatus" => "OK"));
            }
            else {
                return new JsonResponse(
                    array('form'=>
                        $this->renderView($this->editView,  array('form' => $form->createview(),'op'=>$op))
                    )
                );
            }
        }
        return new JsonResponse(
            array('form'=>
                $this->renderView($this->editView,  array('form' => $form->createview(),'op'=>$op))
            )
        );
    }
    public function newAction()
    {
        $op = 'registration';
        $obj =$this->get('fos_user.user_manager')->createUser();
        $form = $this->createForm(new $this->type(),$obj );
        if($obj->getId() != null && $this->editType != null) {
            $form = $this->createForm(new $this->editType(), $obj);
            $op='edit';
        }

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if($form->isValid()) {
                $this->get('fos_user.user_manager')->updateUser($obj);

                $this->getEm()->flush();
                $model  =$this->get($this->tableModelService);
                return new JsonResponse(array("success" => true, "sStatus" => "OK"));
            }
            else {
                return new JsonResponse(
                    array('form'=>
                        $this->renderView($this->createView,  array('form' => $form->createview(),'op'=>$op))
                    )
                );
            }
        }
        return new JsonResponse(
            array('form'=>
                $this->renderView($this->createView,  array('form' => $form->createview(),'op'=>$op))
            )
        );
    }
    public function setPassAction()
    {
        if($this->getRequest()->getMethod() == 'GET'){
            $user = $this->getRepo('MySecurityBundle:Usuario')->find($this->getParameter('id'));
            $type = new EstablishPassType();
            $form = $this->createForm($type,$user);

            return $this->render('@MySecurity/Usuario/establish_pass.html.twig',array('form'=>$form->createView(),'title'=>$user->getUsername()));
        }
        else{
            $id = $this->getParameter('id');
            $usuario = $this->getRepo('MySecurityBundle:Usuario')->find($id);
            $type = new EstablishPassType();
            $form = $this->createForm($type,$usuario);
            $form->bind($this->getRequest());
          //  ldd($form);
            if($form->isValid()) {

                $userManager = $this->container->get('fos_user.user_manager');
                $userManager->updateUser($usuario, true);
               // $this->getEm()->persist($usuario);
              //  $this->getEm()->flush();
                return new JsonResponse(array('success'=>true,'reload'=>false));
            }

            return new JsonResponse(array('success'=>false,'reload'=>false,'sMessage'=>'Existen campos con valores no válidos.'));
        }
    }
    public function permisosAction()
    {
        if($this->getRequest()->getMethod() == 'GET'){
            $permRepo =  $this->getRepo('MySecurityBundle:Permission');
            $user = $this->getRepo('MySecurityBundle:Usuario')->find($this->getParameter('id'));
            $model = new UserPermissionTree();

            $checkeds = $permRepo->getByUsuario($this->getParameter('id'));
            $disableds = $permRepo->getByRoles($user->getGroupsId());

            $model->setCheckeds(array_merge($checkeds,$disableds));
            $model->setDisableds($disableds);

            return $this->render('@MySecurity/Usuario/usuario_permission.html.twig',array('model'=>$model,'title'=>$user->getUsername()));
        }
        else{
            $permisos = $this->getParameter('checked');
            $id = $this->getParameter('id');
            $usuario = $this->getRepo('MySecurityBundle:Usuario')->find($id);
            $permisos = $this->getRepo('MySecurityBundle:Permission')->obtenerXArrayId($permisos);
            $usuario->getPermisos()->clear();

            foreach($permisos as $permiso) {
                $usuario->addPermiso($permiso);
            }

            $this->getEm()->persist($usuario);
            $this->getEm()->flush();

            return new JsonResponse(array('success'=>true,'reload'=>false));
        }
    }
    public function listRolesAction()
    {
        $model = new UserGroupTable();
        if($this->getParameter('firstPetition') != 'false')
            $model->setCheckeds($this->getRepo('MySecurityBundle:Usuario')->find($this->getParameter('id'))->getGroupsId());
        return new JsonResponse($this->getGrid($model));
    }
    public function assignRolesAction()
    {
        if($this->getRequest()->getMethod() == 'GET'){
            $user = $this->getRepo('MySecurityBundle:Usuario')->find($this->getParameter('id'));
            $form = $this->createForm(new UsuarioEditType(),$user);
            return $this->render('@MySecurity/Usuario/usuario_roles.html.twig',array('form'=>$form->createView(),'title'=>$user->getUsername()));
        }
        else{
            $id = $this->getParameter('id');
            $user = $this->getRepo('MySecurityBundle:Usuario')->find($id);
            $form = $this->createForm(new UsuarioEditType(),$user);
            $form->bind($this->getRequest());
            if($form->isValid())
            {
                $this->getEm()->persist($user);
                $this->getEm()->flush();
            }
            return new JsonResponse(array('success'=>true,'reload'=>false));
        }

    }
    public function checkUserNameExistanceAction()
    {
        $name = $this->getParameter('username');
        $user = $this->get('fos_user.user_manager')->findUserByUsername($name);

        $edit = $this->getParameter('edit');

        $userType = new UsuarioType();
        if($edit == true)
            $userType = new UsuarioEditType();

        $newUserParam = $this->getParameter($userType->getName())['username'];
        $newUser = $this->get('fos_user.user_manager')->findUserByUsername($newUserParam);

        if($newUser instanceof Usuario && Util::Canonicalize($name) != Util::Canonicalize($newUserParam) && $edit == true)
            return new JsonResponse("El usuario <b>$newUserParam</b> ya se encuentra en uso.");

        if($user instanceof Usuario && $newUser instanceof Usuario && $edit != true)
            return new JsonResponse("El usuario <b>$name</b> ya se encuentra en uso.");

        return new JsonResponse(true);

    }
    public function checkMailExistanceAction()
    {
        $name = $this->getParameter('email');
        $user = $this->get('fos_user.user_manager')->findUserByEmail($name);

        $edit = $this->getParameter('edit');

        $userType = new UsuarioType();
        if($edit == true)
            $userType = new UsuarioEditType();
        $newUserParam = $this->getParameter($userType->getName())['email'];
        $newUser = $this->get('fos_user.user_manager')->findUserByEmail($newUserParam);

        if($newUser instanceof Usuario && Util::Canonicalize($name) != Util::Canonicalize($newUserParam) && $edit == true)
            return new JsonResponse("El correo <b>$newUserParam</b> ya se encuentra en uso.");

        if($user instanceof Usuario && $newUser instanceof Usuario && $edit != true)
            return new JsonResponse("El correo <b>$name</b> ya se encuentra en uso.");

        return new JsonResponse(true);

    }

}
