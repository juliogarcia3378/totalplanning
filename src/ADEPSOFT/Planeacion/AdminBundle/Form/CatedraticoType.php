<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatedraticoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nombre',null,array('label'=>'Catedrático:','max_length'=> 50))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor'
        ));
    }

    public function getName()
    {
        return 'adepsoft_planeacion_adminbundle_catedraticotype';
    }
}
