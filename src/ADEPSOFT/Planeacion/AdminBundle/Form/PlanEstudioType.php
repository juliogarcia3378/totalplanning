<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanEstudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null,array('required'=>true,'label'=>'Nombre:*','max_length'=> 50))
            ->add('licenciatura','entity',array(
                'required'=>true,
                'label'=>'Licenciatura*:',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Licenciatura'
            ));
            if($options['data']->getActivo() === null)
                $builder->add('activo','checkbox',array('label'=>'Activo:','data'=>true,'required'=>false));
            else
                $builder->add('activo','checkbox',array('label'=>'Activo:','data'=>$options['data']->getActivo(),'required'=>false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\Planeacion\AdminBundle\Entity\PlanEstudio'
        ));
    }

    public function getName()
    {
        return 'adepsoft_planeacion_adminbundle_planestudiotype';
    }
}
