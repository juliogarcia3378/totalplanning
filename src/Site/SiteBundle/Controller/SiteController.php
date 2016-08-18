<?php

namespace Site\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Core\ComunBundle\Controller\MyCRUDController;

class SiteController extends MyCRUDController
{
    public function indexAction()
    {
        return $this->render('SiteBundle:Site:index.html.twig');
    }

    public function mailSentAction()
    {
		return $this->render('SiteBundle:email:mailSent.html.twig');
    }

     public function newContactAction()
    {
		return $this->render('SiteBundle:Site:newContact.html.twig');
    }

      public function newInstitutionAction()
    {
        $positions = $this->getEm()->getRepository("GeneralConfigBundle:Position")->findBy(array(), array('position'=>'ASC'));
        $countries = $this->getEm()->getRepository("GeneralConfigBundle:Country")->findBy(array(), array('country_name'=>'ASC'));

		return $this->render('SiteBundle:Site:institutionDetails.html.twig',array('countries'=>$countries,'positions'=>$positions));
    }
}
