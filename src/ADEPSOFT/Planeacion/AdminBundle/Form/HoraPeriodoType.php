<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use ADEPSOFT\ComunBundle\Util\NomencladoresRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HoraPeriodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        ld($options['data']);
        $builder
            ->add('horaTime',null,array('label'=>'Hora:*','max_length'=> 5,'required'=>true))
            ->add('turno', 'entity', array(
                'label' => 'Turno:*',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Turno'
            ))
            ->add('turno', 'entity', array(
                'label' => 'Turno:*',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Turno',
                'query_builder'=>function(NomencladoresRepository $er) {
                    return $er->filter(array('activo'=>true));
                }
            ))
            ->add('periodo','entity',array(
                'required'=>true,
                'label'=>'Período:*',
                'property'=>'abreviado',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Periodo',
                'query_builder'=>function(NomencladoresRepository $er) {
                    return $er->filter(array(),array('anno'=>'desc','periodo.tipoPeriodo'=>'desc'));
                }
            ))
//            ->add('dia', 'entity', array(
//                'label' => 'Días:*',
//                'property'=>'nombre',
//                'multiple'=>true,
//                'required'=>true,
//                'class' => 'PlaneacionAdminBundle:Dia',
//                'query_builder' => function(DiaRepository $er) {
//                    return $er->getEntreSemana(array(),ResultType::QueryBuilderType);
//                },
//            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\Planeacion\AdminBundle\Entity\HoraPeriodo'
        ));
    }

    public function getName()
    {
        return 'adepsoft_planeacion_adminbundle_horaperiodotype';
    }
}
