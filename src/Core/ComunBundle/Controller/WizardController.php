<?php

namespace Core\ComunBundle\Controller;
use Core\ComunBundle\tableDescription\architecture\WizardGrid;

class WizardController extends MyCRUDController
{
    protected $rutasWizard = null;

    public static function createRutasWizard()
    {
        $rutas =new WizardGrid();
        $rutas->setNext('oficialia_homepage_listAjax');
        $rutas->setPreview('oficialia_registrar_partes_demanda');
        return $rutas;

    }
    /**
     * @return Response
     */
    public function renderMain()
    {
        $rutasWizard = $this->createRutasWizard();
        $model = $this->get($this->tableModelService);
        $entity = $model->getEntity();
        $obj = new $entity();
        $form = $this->createForm(new $this->type(),$obj );
        return $this->render($this->view,array('model'=>$model,'rutasWizard'=>$rutasWizard,'rutas'=> $model->defineRutas(),'form'=>$form->createView()));
    }


}
