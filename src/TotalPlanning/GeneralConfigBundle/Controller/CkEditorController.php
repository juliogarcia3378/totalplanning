<?php

namespace TotalPlanning\GeneralConfigBundle\Controller;

use ADEPSOFT\ComunBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use TotalPlanning\GeneralConfigBundle\Entity\InnerHTML;

class CkEditorController extends BaseController
{
    public function uploadImageAction()
    {
        if(isset($_FILES['upload'])){
        $filen = $_FILES['upload']['tmp_name'];
        $con_images = __DIR__.'/../../../../web/tmp/'.$_FILES['upload']['name'];
        move_uploaded_file($filen, $con_images );
        $funcNum = $_GET['CKEditorFuncNum'] ;
        $CKEditor = $_GET['CKEditor'] ;
        $langCode = $_GET['langCode'] ;
        $url = "http://localhost/totalplanning/web/tmp/".$_FILES['upload']['name'];
        $message = '';
          return new Response("<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>");
        }

    }
    public function saveAction()
    {
        $html = $this->getParameter('html');
        $denominacion = $this->getParameter('denominacion');
        $em = $this->get("doctrine.orm.entity_manager");

        $innerHTML = $em->getRepository("GeneralConfigBundle:InnerHTML")->findBy(array("denominacion"=>$denominacion));
        if (count($innerHTML)>0){
            $innerHTML = $innerHTML[0];
        $innerHTML->setHTML($html);
        $em->persist($innerHTML);
        $em->flush();
         return new JsonResponse(array("msg"=>"ok"));
        }
        else
        {
             $innerHTML = new InnerHTML();
             $innerHTML->setDenominacion($denominacion);
             $innerHTML->setHTML($html);
             $em->persist($innerHTML);
             $em->flush();
              return new JsonResponse(array("msg"=>"ok"));

        }
        return new JsonResponse(array("msg"=>"fail"));
    }


}
