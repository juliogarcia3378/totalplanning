<?php

namespace Core\Planeacion\AdminBundle\Form;

use Core\Planeacion\AdminBundle\Entity\IdiomaProfe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdiomaProfeType extends AbstractType
{
    /**
     * @var IdiomaProfe
     */
    private $obj = null;

    public function __construct($obj=null)
    {
        $this->obj = $obj;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idioma','entity',array(
                'data'=>!is_null($this->obj)?$this->obj->getIdioma():null,
                'label'=>' ',
                'property'=>'nombre',
                'required'=>false,
                'class' => 'PlaneacionAdminBundle:Idioma'
            ))
            ->add('porciento',null, array('required'=>false,'label'=>'%:','max_length'=> 3,
                'data'=>!is_null($this->obj)?$this->obj->getPorciento():null,'attr'=>array('data-rule-digits'=>true,'max'=>100)))
        ;
        if(!is_null($this->obj)) {
            $this->obj->getIdioma()->getNombre();
            $builder->get('idioma')->setData($this->obj->getIdioma());
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\IdiomaProfe'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_idiomaprofetype';
    }
}
