<?php

namespace TotalPlanning\GeneralConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GeneralInformationController extends Controller
{
    public function indexAction()
    {
        return $this->render('GeneralConfigBundle:SystemInformation:index.html.twig');
    }

    
}
