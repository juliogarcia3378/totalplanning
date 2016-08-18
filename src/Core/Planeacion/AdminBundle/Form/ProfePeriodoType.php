<?php

namespace Core\Planeacion\AdminBundle\Form;

use Core\ComunBundle\Util\FechaUtil;
use Core\ComunBundle\Util\NomencladoresRepository;
use Core\ComunBundle\Util\ResultType;
use Core\Planeacion\AdminBundle\Entity\Profesor;
use Core\Planeacion\AdminBundle\Repository\PeriodoRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfePeriodoType extends AbstractType
{
    /**
     * @var Profesor
     */
    private $objProfe = null;

    public function __construct($objProfe=null)
    {
        $this->objProfe = $objProfe;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = null;
        if($this->objProfe->getFechaIngresoUanl() != null)
            $data = $this->objProfe->getFechaIngresoUanl();

        if($this->objProfe->getFechaIngresoFac() != null)
            $data = $this->objProfe->getFechaIngresoFac();

        $builder
            ->add('horasCubrir',null,array('required'=>true,'label'=>'Horas que debe cubrir:*','attr'=>array('data-rule-max'=> 40) ))
            ->add('antiguedad',null,array(
                'required'=>true,
                'label'=>'Antigüedad:',
                'data'=>FechaUtil::restarFechaNaturalAnnos(new \DateTime(),$data),
                'attr'=>array('data-rule-max'=>100)))
            ->add('horasAsignadas',null,array('required'=>false,'label'=>'Horas asignadas:','attr'=>array('data-rule-max'=> 40)))
            ->add('descargaAnt',null,array('required'=>false,'label'=>'Descarga ant.:','attr'=>array('data-rule-max'=> 40)))
            ->add('descargaADMVA',null,array('required'=>false,'label'=>'Descarga admva.:','attr'=>array('data-rule-max'=> 40)))
            ->add('categoria','entity',array(
                'required'=>true,
                'label'=>'Categoría:',
                'property'=>'nombre',
                'required'=>true,
                'data'=>$this->objProfe->getCategoria(),
                'class' => 'PlaneacionAdminBundle:Categoria'
            ))
            ->add('materia','entity',array(
                'required'=>true,
                'label'=>'Materias asignadas:*',
                'property'=>'textoConSemestre',
                'multiple'=>true,
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Materia',
                'query_builder'=>function(NomencladoresRepository $er) {
                    return $er->filter(array('activo'=>true));
                }
            ))
            ->add('periodo','entity',array(
                'required'=>true,
                'label'=>'Período:*',
                'property'=>'abreviado',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Periodo',
                'query_builder'=>function(PeriodoRepository $er) use($options){
                    if($options['data']->getId() != null)
                        return  $er->filter(array('id'=>$options['data']->getPeriodo()->getId()),null,ResultType::QueryBuilderType);
                    else
                        return  $er->getNotByProfe($this->objProfe->getId(),array(),ResultType::QueryBuilderType);
                }
            ))
        ;
        if($options['data']->getAsistenciaSemAnterior() === null)
           $builder->add('asistenciaSemAnterior',null,array('required'=>false,'label'=>'Porcentaje asistencia del semestre anterior:','data'=>100,'attr'=>array('data-rule-max'=> 100)));
        else
            $builder->add('asistenciaSemAnterior',null,array('required'=>false,'label'=>'Porcentaje asistencia del semestre anterior:','data'=>$options['data']->getAsistenciaSemAnterior(),'attr'=>array('data-rule-max'=> 100)));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\ProfePeriodo'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_profeperiodotype';
    }
}
