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

use Core\ComunBundle\Controller\BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller managing the password change
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ChangePasswordController extends BaseController
{
    /**
     * Change user password
     */
    public function changePasswordAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('No posee los permisos necesarios.');
        }
        if($this->getRequest()->getMethod() == 'GET'){
            $form = $this->container->get('fos_user.change_password.form');

            return $this->render('@MySecurity/Usuario/change_pass.html.twig',array('form'=>$form->createView()));
        }
        else{

//            return new JsonResponse(array('success'=>false,'reload'=>false,'sMessage'=>'Existen campos con valroes no válidos.'));

            $form = $this->container->get('fos_user.change_password.form');
            $formHandler = $this->container->get('fos_user.change_password.form.handler');

            $process = $formHandler->process($user);
            if ($process) {
//                $this->setFlash('fos_user_success', 'change_password.flash.success');
                return new JsonResponse(array('success'=>true,'reload'=>false));
//                return new RedirectResponse($this->getRedirectionUrl($user));
            }
            return new JsonResponse(
                array('form' =>
                    $this->renderView('@MySecurity/Usuario/change_pass.html.twig', array('form' => $form->createview()))
                )
            );
//            return new JsonResponse(array('success'=>false,'reload'=>false,'sMessage'=>'Existen campos con valores no válidos.'));
        }
    }

    /**
     * Generate the redirection url when the resetting is completed.
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     *
     * @return string
     */
    protected function getRedirectionUrl(UserInterface $user)
    {
        return $this->container->get('router')->generate('fos_user_profile_show');
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}