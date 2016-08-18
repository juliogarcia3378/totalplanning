<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\MySecurityBundle\Controller;

use Core\ComunBundle\Controller\MyCRUDController;
use Core\MySecurityBundle\Entity\Usuario;
use Core\MySecurityBundle\EP\UserInstanceEP;
use Core\MySecurityBundle\Form\UsuarioInstanciaType;
use STJ\BaseBundle\Entity\Configuracion;
use STJ\BaseBundle\Entity\TribunalSupremo;
use STJ\BaseBundle\Enums\ETipoInstancia;
use Symfony\Component\HttpFoundation\JsonResponse;

class AssignInstanciaUserController extends MyCRUDController
{
    protected $type = 'Core\MySecurityBundle\Form\UsuarioInstanciaType';
    protected $view = "MySecurityBundle:Usuario:assign_instancia.html.twig";
    protected $createView = "MySecurityBundle:Usuario:assign_instancia_new_form.html.twig";
    /**
     * @var string Servicio del table model
     */
    protected $tableModelService = 'security.instancia_usuario.tm';
    /**
     * @return Response
     */
    public function renderMain()
    {
        $model = $this->get($this->tableModelService);
        $model->setExtraParams(array(array('name'=>'idUser','value'=>$this->getParameter('id'))));

//        $entity = $model->getEntity();
//        $obj = new $entity();
        $form = $this->createForm(new $this->type());
        $idUser = $this->getParameter('id');
        $user= $this->getRepo('MySecurityBundle:Usuario')->find($idUser);
        $model->setName('Instancias del usuario: '.$user->getusername());
        return $this->render($this->view,array('model'=>$model,'rutas'=> $model->defineRutas(),'form'=>$form->createView()));
    }
    /**
     * @return Response
     */
    public function newAction()
    {
        $obj = new UserInstanceEP();
        $form = $this->createForm(new UsuarioInstanciaType(),$obj);
        if ('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if($form->isValid()) {
                try {
                    if ($obj->getTipoInstancia()->getId() == ETipoInstancia::CentroAdministracion) {
                        /**
                         * @var $user Usuario
                         */
                        $user = $this->getRepo('MySecurityBundle:Usuario')->find($this->getParameter('idUser'));
                        $stj = $this->getRepo('BaseBundle:TribunalSupremo')->findAll();
                        $stj = $stj[0];
                        $stj->addUsuario($user);
                        $em = $this->getEm();
                        $em->persist($stj);
                        $em->flush();
                    } else if ($obj->getTipoInstancia()->getId()  == ETipoInstancia::Juzgado) {
                        $user = $this->getRepo('MySecurityBundle:Usuario')->find($this->getParameter('idUser'));
                        $user->addJuzgado($obj->getJuzgado());
                        $em = $this->getEm();
                        $em->persist($user);
                        $em->flush();
                    } else if ($obj->getTipoInstancia()->getId()  == ETipoInstancia::Oficialia) {
                        $user = $this->getRepo('MySecurityBundle:Usuario')->find($this->getParameter('idUser'));
                        $user->addOficialia($obj->getOficialia());
                        $em = $this->getEm();
                        $em->persist($user);
                        $em->flush();
                    }
                    return new JsonResponse(array("success" => true, "sStatus" => "OK"));
                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array("success" => false, "sMessage" => "Este usuario ya tiene asignada esta instancia."));
                }
            }
            return new JsonResponse(
                array('form'=>
                    $this->renderView($this->createView,  array('form' => $form->createview()))
                )
            );
        }
        else{
            return new JsonResponse(
                array('form'=>
                    $this->renderView($this->createView,  array('form' => $form->createview()))
                )
            );
        }
    }
    /**
     * @return array
     */
    public function deleteAction()
    {
        $id = $this->getParameter('selected');
        try {
            $result = array();
            if ($id != null) {
                if (!is_array($id))
                    $id = array($id);
                if (count($id) > 0) {
                    $tmp = array();
                    /**
                     * @var $user Usuario
                     */
                    $user = $this->getRepo('MySecurityBundle:Usuario')->find($this->getParameter('idUser'));
                    $em = $this->getEm();
                    foreach($id as $compound)
                    {
                        $tmp = explode('#',$compound);
                        if($tmp[0] == ETipoInstancia::CentroAdministracion){
                            /**
                             * @var $tsp TribunalSupremo
                             */
                            $tsp = $this->getRepo('BaseBundle:TribunalSupremo')->find($tmp[1]);
                            $tsp->removeUsuario($user);
                            $em->persist($tsp);
                        }
                        if($tmp[0] == ETipoInstancia::Juzgado){
                            $tsp = $this->getRepo('BaseBundle:Juzgado')->find($tmp[1]);
                            $user->removeJuzgado($tsp);
                            $em->persist($user);

                        }
                        if($tmp[0] == ETipoInstancia::Oficialia){
                            $tsp = $this->getRepo('BaseBundle:Oficialia')->find($tmp[1]);
                            $user->removeOficialia($tsp);
                            $em->persist($user);
                        }
                    }
                    $em->flush();
                }
                $result['success']=true;
                if(count($id) == 1)
                    $result['sMessage']='Elemento eliminado satisfactoriamente.';
                else
                    $result['sMessage']='Elementos eliminados satisfactoriamente.';
            }
            $data = $this->get($this->tableModelService)->getTransformedData();
            return new JsonResponse(array_merge($result, $data));
        }
        catch(DBALException $e)
        {
            //23503 FOREIGN Key Violation
//            ldd($e);
            $data = $this->get($this->tableModelService)->getTransformedData();
            return new JsonResponse(array_merge_recursive(array('success'=>false,'sMessage'=>'No se pudo eliminar el elemento.','code'=>$e->getMessage(),'exception'=>$e->getMessage()),$data));
        }
    }

}
