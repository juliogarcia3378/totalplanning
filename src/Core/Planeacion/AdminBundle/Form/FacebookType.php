<?php

namespace Core\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FacebookType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('type'=>'text')
        );
    }
    public function getParent()
    {
        return 'text';
    }
    public function getName()
    {
        return 'facebook';
    }
}
