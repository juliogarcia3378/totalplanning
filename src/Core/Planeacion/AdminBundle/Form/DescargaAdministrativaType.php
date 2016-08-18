<?php

namespace Core\Planeacion\AdminBundle\Form;

use Core\Planeacion\AdminBundle\Entity\Profesor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DescargaAdministrativaType extends AbstractType
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

        ->add('profesor','entity',array(
        'required'=>true,
        'label'=>'Profesor*:',
        'property'=>'nombre',
        'required'=>true,
        'class' => 'PlaneacionAdminBundle:Profesor'
    ))
        ->add('tipodescarga','entity',array(
        'required'=>true,
        'label'=>'Tipo de Descarga*:',
        'property'=>'nombre',
        'required'=>true,
        'class' => 'PlaneacionAdminBundle:TipoDescargaAdministrativa'
    ))
            ->add('Periodo','entity',array(
        'required'=>true,
        'label'=>'Periodo*:',
        'property'=>'nombre',
        'required'=>true,
        'class' => 'PlaneacionAdminBundle:Periodo'
    ))
        ->add('comentario',null,array('label'=>'Comentario:','max_length'=> 500));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\Planeacion\AdminBundle\Entity\DescargaAdministrativa'
        ));
    }

    public function getName()
    {
        return 'Core_planeacion_adminbundle_descargaadministrativatype';
    }
}
