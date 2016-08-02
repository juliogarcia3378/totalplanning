<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ADEPSOFT\MySecurityBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\MyCRUDController;
use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\ComunBundle\Util\Util;
use ADEPSOFT\MySecurityBundle\Entity\Grupo;
use ADEPSOFT\MySecurityBundle\Form\GroupType;
use ADEPSOFT\MySecurityBundle\TreeDescription\GroupPermissionTree;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupController extends MyCRUDController
{
    protected $type = 'ADEPSOFT\MySecurityBundle\Form\GroupType';
    protected $editView='MySecurityBundle:Group:edit_content.html.twig';
    protected $view = "MySecurityBundle:Group:group_crud.html.twig";
    protected $textProperty = 'name';
    /**
     * @var string Servicio del table model
     */
    protected $tableModelService = 'security.group.tm';
    public function permisosAction()
    {
        if($this->getRequest()->getMethod() == 'GET'){
//            $form = $this->renderView('@MySecurity/Group/group_permission.html.twig',array('model'=>new GroupPermissionTree()));
            $model = new GroupPermissionTree();
            $qb = $this->getRepo('MySecurityBundle:Permission')->getQB('grupos')->andWhere('grupos.id = :grupo')->setParameter('grupo',$this->getParameter('id'));
            $checkeds = $this->getRepo('MySecurityBundle:Permission')->filterQB($qb,array(),ResultType::IDSType);
//            ldd($checkeds);
            $model->setCheckeds($checkeds);
            $grupo = $this->getRepo('MySecurityBundle:Grupo')->find($this->getParameter('id'));
            return $this->render('@MySecurity/Group/group_permission.html.twig',array('model'=>$model,'title'=>$grupo->getName()));
        }
        else{
            $permisos = $this->getParameter('checked');
            $id = $this->getParameter('id');
            $grupo = $this->getRepo('MySecurityBundle:Grupo')->find($id);
            $permisos = $this->getRepo('MySecurityBundle:Permission')->obtenerXArrayId($permisos);
            $grupo->getPermisos()->clear();

            foreach($permisos as $permiso)
                $grupo->addPermiso($permiso);

            $this->getEm()->persist($grupo);
            $this->getEm()->flush();

            return new JsonResponse(array('success'=>true));
//            ldd($this->getRequest()->request->all());
        }
    }
    public function checkExistanceAction()
    {
        $groupType = new GroupType();
        $newGroupParam = $this->getParameter($groupType->getName())['name'];
        $newGroup = $this->get('fos_user.group_manager')->findGroupByName($newGroupParam);

        $name = $this->getParameter('name');
        $group = $this->get('fos_user.group_manager')->findGroupByName($name);

        $edit = $this->getParameter('edit');

        if($newGroup instanceof Grupo && Util::Canonicalize($name) != Util::Canonicalize($newGroupParam) && $edit == true)
            return new JsonResponse("El grupo <b>$newGroupParam</b> ya se encuentra en uso.");

        if($group instanceof Grupo && $newGroup instanceof Grupo && $edit != true)
            return new JsonResponse("El grupo <b>$name</b> ya se encuentra en uso.");


        return new JsonResponse(true);


    }
}
