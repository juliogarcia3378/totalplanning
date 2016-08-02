<?php

namespace ADEPSOFT\MySecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'Nombre:*', 'translation_domain' => 'FOSUserBundle',
            'attr'=>array('data-rule-required'=>true,'data-rule-minlength'=>3,'data-rule-maxlength'=>50)));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\MySecurityBundle\Entity\Grupo'
        ));
    }

    public function getName()
    {
        return 'mysecuritybundle_grouptype';
    }
}
