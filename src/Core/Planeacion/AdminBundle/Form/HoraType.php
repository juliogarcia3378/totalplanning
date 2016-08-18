<?php

namespace Core\Planeacion\AdminBundle\Form;

use Core\ComunBundle\Util\ResultType;
use Core\Planeacion\AdminBundle\Repository\DiaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HoraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        ld($options['data']->getHora() == null ? null: array('hour'=>$options['data']->getHora()->format('H'),'minute'=>$options['data']->getHora()->format('i')));
        $builder
            ->add('hora',null,array('label'=>'Hora:*','max_length'=> 5))
//                   'data'=>$options['data']->getHora() == null ? null: array('hour'=>$options['data']->getHora()->format('H'),'minute'=>$options['data']->getHora()->format('i'))))
            ->add('dia', 'entity', array(
                'label' => 'Días:*',
                'property'=>'nombre',
                'multiple'=>true,
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Dia',
                'query_builder' => function(DiaRepository $er) {
                    return $er->getEntreSemana(array(),ResultType::QueryBuilderType);
                },
            ));

        if($options['data']->getActivo() === null)
            $builder->add('activo','checkbox',array('label'=>'Activa:','data'=>true,'required'=>false));
        else
            $builder->add('activo','checkbox',array('label'=>'Activa:','data'=>$options['data']->getActivo(),'required'=>false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\Hora'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_horatype';
    }
}
