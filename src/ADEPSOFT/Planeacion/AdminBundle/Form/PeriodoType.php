<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PeriodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('nombre',null,array('label'=>'Nombre:*','max_length'=> 50))
            ->add('anno',null,array('label'=>'Año:*',
                    'max_length'=> 4,
                    'required'=>true,
                    'attr'=>array('data-rule-range'=> "1900, ".(date('Y')+1)))
            )
            ->add('tipoPeriodo','entity',array(
                'required'=>true,
                'label'=>'Número:*',
                'property'=>'id',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:TipoPeriodo'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\Planeacion\AdminBundle\Entity\Periodo'
        ));
    }

    public function getName()
    {
        return 'adepsoft_planeacion_adminbundle_periodotype';
    }
}
