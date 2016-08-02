<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MobilePhoneType extends AbstractType
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
        return 'mobile_phone';
    }
}
