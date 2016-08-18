<?php

namespace Core\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanEstudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null,array('required'=>true,'label'=>'Nombre:*','max_length'=> 50))
            ->add('carrera','entity',array(
                'required'=>true,
                'label'=>'Carrera*:',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Carrera'
            ));
            if($options['data']->getActivo() === null)
                $builder->add('activo','checkbox',array('label'=>'Activo:','data'=>true,'required'=>false));
            else
                $builder->add('activo','checkbox',array('label'=>'Activo:','data'=>$options['data']->getActivo(),'required'=>false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\PlanEstudio'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_planestudiotype';
    }
}
