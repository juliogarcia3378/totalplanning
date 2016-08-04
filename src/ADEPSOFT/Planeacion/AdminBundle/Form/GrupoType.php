<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use ADEPSOFT\ComunBundle\Util\NomencladoresRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GrupoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null,array('required'=>true,'label'=>'Nombre:*','max_length'=> 15))
            ->add('nivel',null,array('label'=>'Nivel:*','max_length'=> 3))
            ->add('semestre','entity',array(
                'label'=>'Semestre:',
                'property'=>'nombre',
                'required'=>true,
//                'attr'=>array('data-rule-required'=>"#adepsoft_planeacion_adminbundle_materiatype_tipoMateria_2:not(:checked)"),
                'class' => 'PlaneacionAdminBundle:Semestre',
                'query_builder'=>function(NomencladoresRepository $er) {
                    return $er->filter(array(),array('id'=>'asc'));
                }
            ))
            ->add('carrera','entity',array(
                'required'=>true,
                'label'=>'Carrera:*',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Carrera'
            ))
            ->add('turno','entity',array(
                'required'=>true,
                'label'=>'Turno:*',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Turno'
            ))
            ->add('periodo','entity',array(
                'required'=>true,
                'label'=>'Período:',
                'property'=>'abreviado',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Periodo',
                'query_builder'=>function(NomencladoresRepository $er) {
                    return $er->filter(array(),array('anno'=>'desc','periodo.tipoPeriodo'=>'desc'));
                }
            ))
            ->add('aula','entity',array(
                'required'=>true,
                'label'=>'Aula:*',
                'property'=>'nombre',
//                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Aula'
            ))
            ->add('campus','entity',array(
                'required'=>true,
                'label'=>'Campus:*',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Campus'
            ))
            ->add('planEstudio','entity',array(
                'required'=>true,
                'label'=>'Plan Estudio:*',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:PlanEstudio'
            ))
        ;
        if($options['data']->getBilingue() === null)
            $builder->add('bilingue','checkbox',array('label'=>'Bilingüe:','data'=>false,'required'=>false));
        else
            $builder->add('bilingue','checkbox',array('label'=>'Bilingüe:','data'=>$options['data']->getBilingue(),'required'=>false));

        if($options['data']->getPaquete() === null)
            $builder->add('paquete','checkbox',array('label'=>'Paquete:','data'=>false,'required'=>false));
        else
            $builder->add('paquete','checkbox',array('label'=>'Paquete:','data'=>$options['data']->getPaquete(),'required'=>false));

        if($options['data']->getTerceros() === null)
            $builder->add('terceros','checkbox',array('label'=>'Terceros:','data'=>false,'required'=>false));
        else
            $builder->add('terceros','checkbox',array('label'=>'Terceros:','data'=>$options['data']->getTerceros(),'required'=>false));

        if($options['data']->getEnLinea() === null)
            $builder->add('enlinea','checkbox',array('label'=>'En línea:','data'=>false,'required'=>false));
        else
            $builder->add('enlinea','checkbox',array('label'=>'En línea:','data'=>$options['data']->getEnLinea(),'required'=>false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\Planeacion\AdminBundle\Entity\GrupoEstudiantes'
        ));
    }

    public function getName()
    {
        return 'adepsoft_planeacion_adminbundle_grupotype';
    }
}
