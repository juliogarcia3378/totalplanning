<?php

namespace ADEPSOFT\MySecurityBundle\Form;

use ADEPSOFT\ComunBundle\Util\NomencladoresRepository;
use ADEPSOFT\ComunBundle\Util\UtilRepository2;
use STJ\BaseBundle\DependentEventSubscriber\JuzgadoDistritoSubscriber;
use STJ\BaseBundle\DependentEventSubscriber\JuzgadoMunicSubscriber;
use STJ\BaseBundle\DependentEventSubscriber\OficialiaDistritoSubscriber;
use STJ\BaseBundle\Repository\JuzgadoRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioInstanciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoInstancia','entity',array(
                'label'=>'Tipo de instancia:*',
                'property'=>'denominacion',
                'required'=>true,
//                'mapped'=>false,
                'class' => 'BaseBundle:TipoInstancia'
//                'attr'=>array('disabled'=>true)
            ))
            ->add('distrito','entity',array(
                'label'=>'Distrito:*',
                'property'=>'denominacion',
//                'mapped'=>false,
                'required'=>true,
                'class' => 'BaseBundle:Distrito',
                'query_builder' => function(NomencladoresRepository $er) use($options) {
                    return $er->filter(array('poderJudicial'=>UtilRepository2::getPoderJudicialLoged()));
                },
            ))
            ->add('juzgado','entity',array(
                'label'=>'Juzgado:*',
                'property'=>'denominacion',
//                'mapped'=>false,
                'required'=>true,
                'class' => 'BaseBundle:Juzgado',
                'query_builder' => function(JuzgadoRepository $er) use($options) {
                    $id = -1;
                    $qb = $er->getQB()->andWhere('juzgado.id = :id')->setParameter('id', $id)->setMaxResults(1);
                    return $qb;

                },
                'attr'=>array(
                    'parent' =>"#".$this->getName()."_distrito",
                    'path'=>UtilRepository2::getRoute('base_juzgado_json_read') ,
                    'param'=>$this->getName(),
                    'index'=>'distrito',
                    'query'=>'getByDistrito',
                    'entity'=>'BaseBundle:Juzgado',
                    'filter'=>'distrito.id')
            ))
            ->add('oficialia','entity',array(
                'label'=>'Oficialia:*',
//                'mapped'=>false,
                'property'=>'denominacion',
                'required'=>true,
                'class' => 'BaseBundle:Oficialia',
                'query_builder' => function($er) use($options) {
                    $id = -1;
                    $qb = $er->getQB('distrito')->andWhere('distrito.id = :id')->setParameter('id', $id);
                    return $qb;

                },
                'attr'=>array(
                    'parent' =>"#".$this->getName()."_distrito",
                    'path'=>UtilRepository2::getRoute('base_oficialia_json_read') ,
                    'param'=>$this->getName(),
                    'off'=>false,
                    'index'=>'distrito',
                    'entity'=>'BaseBundle:Oficialia',
                    'filter'=>'distrito.id')
            ))
        ;
        $factory = $builder->getFormFactory();
        $citySubscriber = new JuzgadoDistritoSubscriber($factory,$builder->get('juzgado'));
        $builder->addEventSubscriber($citySubscriber);

        $factory = $builder->getFormFactory();
        $citySubscriber = new OficialiaDistritoSubscriber($factory,$builder->get('oficialia'));
        $builder->addEventSubscriber($citySubscriber);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\MySecurityBundle\EP\UserInstanceEP'
        ));
    }

    public function getName()
    {
        return 'stj_basebundle_user_instancetype';
    }
}
