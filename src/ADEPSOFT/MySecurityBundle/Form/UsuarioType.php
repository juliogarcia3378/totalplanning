<?php

namespace ADEPSOFT\MySecurityBundle\Form;

use ADEPSOFT\ComunBundle\Util\NomencladoresRepository;
use STJ\BaseBundle\Form\PersonaNaturalType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
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
            ->add('nombre', "text", array(
                    'label'=>'Nombre completo:*',
                    'required'=>true,
                    'attr'=>
                        array('autocomplete'=>'off')
                )
            )
            ->add('cedula',"text",array('label' => 'Número de empleado:*') )
            ->add('email', 'email', array('label' => 'Correo:*'))
//            ->add('telefono',"text",array('label' => 'Teléfono:','required'=>false,'attr'=>array('autocomplete'=>'off','class'=>'col-md-offset-4 col-md-4')) )
            ->add('username', null, array('label' => 'Nombre de usuario:*','required'=>true))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options' => array('label' => 'Contraseña:*'),
                'second_options' => array('label' => 'Confirmar contraseña:*'),
                'invalid_message' => 'Las contraseñas no coinciden.',
            ))
            ->add('profesor', 'entity', array(
                'label' => 'Profesor:*',
                'property'=>'nombreNumEmpleado',
                'class' => 'PlaneacionAdminBundle:Profesor',
                'query_builder' => function(NomencladoresRepository $er) {
                    return $er->filter();
                },
            ))
            ->add('groups', 'entity', array(
                'label' => 'Roles:*',
                'property'=>'name',
                'multiple'=>true,
                'required'=>true,
                'class' => 'MySecurityBundle:Grupo',
                'query_builder' => function(NomencladoresRepository $er) {
                    return $er->filter(array(),'name');
                },
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
        return 'mysecurity_user_registration';
    }
}
