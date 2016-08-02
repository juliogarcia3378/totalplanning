<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use ADEPSOFT\ComunBundle\Util\FechaUtil;
use ADEPSOFT\ComunBundle\Util\NomencladoresRepository;
use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor;
use ADEPSOFT\Planeacion\AdminBundle\Repository\PeriodoRepository;
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
            'data_class' => 'ADEPSOFT\Planeacion\AdminBundle\Entity\Estudiante'
        ));
    }

    public function getName()
    {
        return 'adepsoft_planeacion_adminbundle_estudiantetype';
    }
}
