<?php

namespace Core\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AulaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null,array('label'=>'Nombre:*','max_length'=> 10))
            ->add('capacidad',null,array('label'=>'Capacidad:*','max_length'=> 2,'required'=>false));

        if($options['data']->getActivo() === null)
            $builder->add('activo','checkbox',array('label'=>'Activa:','data'=>true,'required'=>false));
        else
            $builder->add('activo','checkbox',array('label'=>'Activa:','data'=>$options['data']->getActivo(),'required'=>false));

        if($options['data']->getEnLinea() === null)
            $builder->add('enlinea','checkbox',array('label'=>'En Línea:','data'=>false,'required'=>false));
        else
            $builder->add('enlinea','checkbox',array('label'=>'En Línea:','data'=>$options['data']->getEnLinea(),'required'=>false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\Aula'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_aulatype';
    }
}
