<?php

namespace ADEPSOFT\MySecurityBundle\Controller;


use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends BaseController
{
    public function registerAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        $process = $formHandler->process($confirmationEnabled);
//        $request = $this->container->get('request');
//        ld($request->request);
//        ld($process);
//        ldd($form->getErrors());
        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_security_login';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

//            if ($authUser) {
//                $this->authenticateUser($user, $response);
//            }

            return $response;
        }
        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
        return $this->container->get('templating')->renderResponse('FOSUserBundle:Security:login.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
            'csrf_token' => $csrfToken,
            'registrationError'=>true,
            'error'=>false
        ));
    }
}