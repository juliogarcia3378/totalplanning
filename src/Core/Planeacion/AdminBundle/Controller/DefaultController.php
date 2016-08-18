<?php

namespace Core\Planeacion\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $content_portada = $this->getDoctrine()->getRepository("GeneralConfigBundle:InnerHTML")->getPortada();
        return $this->render('PlaneacionAdminBundle:Default:index.html.twig',array("content_portada"=>$content_portada));

    }
}
