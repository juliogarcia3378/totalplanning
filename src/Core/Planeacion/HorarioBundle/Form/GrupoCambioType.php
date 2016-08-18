<?php

namespace Core\Planeacion\HorarioBundle\Form;

use Core\Planeacion\AdminBundle\Form\GrupoDistribucionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GrupoCambioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anterior',new GrupoDistribucionType(),array('required'=>false,'label'=>'Grupo Anterior:','max_length'=> 50))
            ->add('actual',new GrupoDistribucionType(),array('required'=>false,'label'=>'Grupo Anterior:','max_length'=> 50));


    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\GrupoEstudiantesCambio'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_grupotype';
    }
}
