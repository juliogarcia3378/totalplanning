<?php

namespace Core\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutoasignacionAulaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aula', 'entity', array(
                'required' => true,
                'label' => 'Aula*:',
                'property' => 'nombre',
                'required' => true,
                'class' => 'PlaneacionAdminBundle:Aula'
            ))
            ->add('materia', 'entity', array(
                'required' => true,
                'label' => 'Materia*:',
                'property' => 'claveNombreCarrera',
                'required' => true,
                'class' => 'PlaneacionAdminBundle:Materia'
            ))
            ->add('comentario', null, array('label' => 'Comentario:', 'max_length' => 500));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\AutoasignacionAula'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_autoasignacionaulatype';
    }
}