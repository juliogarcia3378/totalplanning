<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Listener;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\ContainerAware;
class LoginListener
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $session=  $this->container->get('session');
    //    $user = $event->getAuthenticationToken()->getUser();
        $userSession = $this->container->get('security.context')->getToken()->getUser();
        $userSession->setToken($session->getId());
        $this->container->get('doctrine.orm.entity_manager')->persist($userSession);
        $this->container->get('doctrine.orm.entity_manager')->flush();
       //->migrate(true,0);
      //  $session->setId($userSession->getId());
      //  $session->save();
    }
}