<?php

namespace ADEPSOFT\MySecurityBundle\Form;

use STJ\BaseBundle\Form\PersonaNaturalType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstablishPassType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct()
    {
        $this->class = "ADEPSOFT\MySecurityBundle\Entity\Usuario";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class
        ));
    }

    public function getName()
    {
        return 'mysecurity_user_establish_pass';
    }
}
