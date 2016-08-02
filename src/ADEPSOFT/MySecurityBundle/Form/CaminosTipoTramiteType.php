<?php

namespace ADEPSOFT\MySecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CaminosTipoTramiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anterior')
            ->add('evento')
            ->add('biometria')
            ->add('siguiente');
     }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'STJ\BaseBundle\Entity\CaminosTipoTramite'
        ));
    }

    public function getName()
    {
        return 'mysecuritybundle_caminostipotramitetype';
    }
}
