<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use ADEPSOFT\Planeacion\AdminBundle\Entity\MaestriaDoctorado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MaestriaDoctoradoType extends AbstractType
{
    /**
     * @var MaestriaDoctorado
     */
    private $obj = null;

    public function __construct($obj=null)
    {
        $this->obj = $obj;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data=null;
        if(!is_null($this->obj) && $this->obj->getPasante())
            $data = 1;
        elseif(!is_null($this->obj) && $this->obj->getTitulado())
            $data = 2;
//        ldd($data);
        $builder
            ->add('nombre',null,array('required'=>false, 'label'=>'Nombre:*','max_length'=> 150,'data'=>!is_null($this->obj)?$this->obj->getNombre():''))
            ->add('tipo','choice',array(
                'data'=>$data,
                'label'=>false,
                'required'=>false,
                'multiple'=>false,
                'expanded'=>true,
                'choices'  => array('1' => 'Pasante', '2' => 'Titulado')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ADEPSOFT\Planeacion\AdminBundle\Entity\MaestriaDoctorado'
        ));
    }

    public function getName()
    {
        return 'adepsoft_planeacion_adminbundle_maestriadoctoradotype';
    }
}
