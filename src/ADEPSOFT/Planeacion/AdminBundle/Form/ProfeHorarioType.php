<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfeHorarioType extends AbstractType
{
    /**
     * @var Profesor
     */
    private $objProfe = null;

    public function __construct($objProfe=null)
    {
        $this->objProfe = $objProfe;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null,array('required'=>false,'label'=>'Catedrático:','max_length'=> 50))
            ->add('categoria','entity',array(
                'required'=>true,
                'label'=>'Categoría:',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Categoria'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\Planeacion\AdminBundle\Entity\Profesor'
        ));
    }

    public function getName()
    {
        return 'adepsoft_planeacion_adminbundle_profehorariotype';
    }
}
