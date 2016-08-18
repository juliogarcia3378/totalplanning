<?php

namespace Core\Planeacion\AdminBundle\Form;

use Core\ComunBundle\Util\NomencladoresRepository;
use Core\ComunBundle\Util\UtilRepository2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MateriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null,array('label'=>'Nombre:*','max_length'=> 100))
            ->add('clave',null,array('label'=>'Clave:*','max_length'=> 10))
            ->add('frecuenciaSemanal','text',array('label'=>'Frecuencia:*','max_length'=> 2,'attr'=>array('data-rule-digits'=>true)))
            ->add('semestre','entity',array(
                'label'=>'Semestre:',
                'property'=>'nombre',
                'attr'=>array('data-rule-required'=>"#Core_planeacion_adminbundle_materiatype_tipoMateria_2:not(:checked)"),
                'class' => 'PlaneacionAdminBundle:Semestre',
                'query_builder'=>function(NomencladoresRepository $er) {
                    return $er->filter(array(),array('id'=>'asc'));
                }
            ))
            ->add('planEstudio','entity',array(
                'label'=>'Plan de estudio:*',
                'property'=>'texto',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:PlanEstudio'
            ));
        if($options['data']->getActivo() === null)
            $builder->add('activo','checkbox',array('label'=>'Activa:','data'=>true,'required'=>false));
        else
            $builder->add('activo','checkbox',array('label'=>'Activa:','data'=>$options['data']->getActivo(),'required'=>false));

        if($options['data']->getHorasExtra() === null)
            $builder->add('horasextra','checkbox',array('data'=>false, 'label'=>'Horas Extra:', 'required'=>false));
        else
            $builder->add('horasextra','checkbox',array('data'=>$options['data']->getHorasExtra(), 'label'=>'Horas Extra:', 'required'=>false));

        $default = 1;
        if($options['data']->getTipoMateria() != null)
            $default = $options['data']->getTipoMateria()->getId();
        $builder->add('tipoMateria','entity',array(
            'label'=>'Tipo de materia:*',
            'property'=>'nombre',
            'required'=>true,
            'data'=>UtilRepository2::getEntityManager()->find("PlaneacionAdminBundle:TipoMateria",$default),
            'expanded'=>true,
            'class' => 'PlaneacionAdminBundle:TipoMateria',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\Materia'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_materiatype';
    }
}
