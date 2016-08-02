<?php

namespace TotalPlanning\GeneralConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GeneralConfigBundle:Default:index.html.twig');
    }

    public function mainScreenAction()
    {
        $content_portada = $this->getDoctrine()->getRepository("GeneralConfigBundle:InnerHTML")->getPortada();
        return $this->render('GeneralConfigBundle:mainScreen:mainScreen.html.twig',array("content_portada"=>$content_portada));
    }
}
