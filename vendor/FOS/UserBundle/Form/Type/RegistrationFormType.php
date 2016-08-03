<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Form\Type;

use STJ\BaseBundle\Form\PersonaNaturalType;
use STJ\BaseBundle\Form\PersonaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cedula', "text", array(
                    'label'=>'Cédula',
                    'attr'=>
                        array('placeholder'=>'Cédula','autocomplete'=>'off')
                )
            )
            ->add('nombre', "text", array(
                    'label'=>'Nombre(s)',
                    'attr'=>
                        array('placeholder'=>'Nombre(s)','autocomplete'=>'off')
                )
            )
            ->add('apellidos',"text",array('attr'=>array('placeholder'=>'Apellidos','autocomplete'=>'off')) )
//            ->add('direccion', "text", array(
//                    'label'=>'Dirección de Contacto',
//                    'attr'=>
//                        array('placeholder'=>'Dirección de Contacto','autocomplete'=>'off')
//                )
//            )
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
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
            'data_class' => $this->class,
            'intention'  => 'registration',
        ));
    }

    public function getName()
    {
        return 'fos_user_registration';
    }
}