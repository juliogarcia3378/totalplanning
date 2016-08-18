<?php

namespace Core\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhoneType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('required'=>false,'type'=>'text')
        );
    }
    public function getParent()
    {
        return 'text';
    }
    public function getName()
    {
        return 'phone';
    }
}
