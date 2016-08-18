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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends \FOS\UserBundle\Controller\SecurityController
{
    public function loginAction()
    {

        if ( $this->container->get('request')->isXmlHttpRequest()) {
            return new Response("",401,array());
        }
        $request = $this->container->get('request');
        $session = $request->getSession();
       
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        $form = $this->container->get('fos_user.registration.form');
        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
            'form'=>$form->createView()
        ));
    }
    public function checkValidUserAction()
    {
        $request = $this->container->get('request');
//        ldd($_REQUEST);
        $username = $request->get('fos_user_registration_form');
        $username= $username['username'];
        $user = $this->container->get('fos_user.user_manager')->findUserByUsername($username);
        if($user == null)
            return new JsonResponse(true);
        return new JsonResponse("El usuario <b>$username</b> ya se encuentra en uso.");
    }

}
