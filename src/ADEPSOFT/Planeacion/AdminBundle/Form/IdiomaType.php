<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdiomaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nombre',null,array('required'=>true,'label'=>'Nombre:*','max_length'=> 50))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\Planeacion\AdminBundle\Entity\Idioma'
        ));
    }

    public function getName()
    {
        return 'adepsoft_planeacion_adminbundle_idiomatype';
    }
}
