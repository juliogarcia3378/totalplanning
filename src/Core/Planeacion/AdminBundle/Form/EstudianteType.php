<?php

namespace Core\Planeacion\AdminBundle\Form;

use Core\ComunBundle\Util\FechaUtil;
use Core\ComunBundle\Util\NomencladoresRepository;
use Core\ComunBundle\Util\ResultType;
use Core\Planeacion\AdminBundle\Entity\Profesor;
use Core\Planeacion\AdminBundle\Repository\PeriodoRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstudianteType extends AbstractType
{


    public function __construct()
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
        ->add('nombres',null,array('label'=>'Nombre:* ','max_length'=> 50))
        ->add('apellidos',null,array('label'=>'Apellidos:* ','max_length'=> 50))
        ->add('genero', 'choice', array('label'=>'Género:*',
            'multiple'=>false,
            'required'=>true,
//                'expanded'=>true,
            'choices' => array('2' => 'Masculino', '1' => 'Femenino'),
        ))
            ->add('correo',null,array('required'=>false,'label'=>'Correo:*','max_length'=> 150))
            ->add('facebook',null,array('required'=>false,'label'=>'Facebook:','max_length'=> 150))
            ->add('telCelular',new MobilePhoneType(),array('label'=>'Celular:','max_length'=> 50))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\Estudiante'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_estudiantetype';
    }
}
