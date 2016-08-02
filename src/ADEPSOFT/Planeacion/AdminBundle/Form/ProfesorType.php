<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Form;

use ADEPSOFT\ComunBundle\Util\UtilRepository2;
use ADEPSOFT\Planeacion\AdminBundle\Enums\ETipoMaestriaDoctorado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfesorType extends AbstractType
{
    private $maestria=null;
    private $doctorado=null;
    private $idioma1=null;
    private $idioma2=null;
    private function gatherData(array $options)
    {
        if(!is_null($options['data']->getId()))
        {
            $obj = $options['data'];
            $tmp = UtilRepository2::getEntityManager()->getRepository("PlaneacionAdminBundle:MaestriaDoctorado")->filterObjects(array('profesor' => $obj->getId(), 'tipo' => ETipoMaestriaDoctorado::Maestria));
            if(count($tmp) > 0)
                $this->maestria = $tmp[0];
            $tmp = UtilRepository2::getEntityManager()->getRepository("PlaneacionAdminBundle:MaestriaDoctorado")->filterObjects(array('profesor' => $obj->getId(), 'tipo' => ETipoMaestriaDoctorado::Doctorado));
            if(count($tmp) > 0)
                $this->doctorado = $tmp[0];

            $idioma1 =  UtilRepository2::getEntityManager()->getRepository("PlaneacionAdminBundle:IdiomaProfe")->filterObjects(array('profesor' => $obj->getId(), 'numero' => 1));
            if (count($idioma1) != 0)
                $this->idioma1 = $idioma1[0];
            $idioma2 =  UtilRepository2::getEntityManager()->getRepository("PlaneacionAdminBundle:IdiomaProfe")->filterObjects(array('profesor' => $obj->getId(), 'numero' => 2));
            if (count($idioma2))
                $this->idioma2 = $idioma2[0];

        }
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->gatherData($options);
        $builder
//            ->add('fotoFile','file',array('required'=>false,'mapped'=>false,'label'=>"Foto:"))
            ->add('inactivo',null,array('required'=>false,'label'=>'Profesor en activo:'))
            ->add('carrera', 'entity', array(
                'required' => true,
                'label' => 'Carrera:',
                'property' => 'nombre',
                'required' => true,
                'class' => 'PlaneacionAdminBundle:Licenciatura'
            ))
            ->add('nombres',null,array('label'=>'Nombre:* ','max_length'=> 50))
            ->add('apellidos',null,array('label'=>'Apellidos:* ','max_length'=> 50))
            ->add('perfil',null,array('label'=>'Competencias y habilidades:','max_length'=> 2500,'attr'=>array('data-rule-maxlength'=>2500)))
            ->add('numeroEmpleado',null,array('required'=>false,'label'=>'No. de Empleado:*','max_length'=> 10))
            ->add('fechaIngresoFac',null,array('label'=>'Fecha ingreso a la FACDYC:'))
            ->add('fechaIngresoUanl',null,array('label'=>'Fecha ingreso a la UANL:'))
            ->add('categoria','entity',array(
                'required'=>true,
                'label'=>'Categoría:',
                'property'=>'nombre',
                'required'=>true,
                'class' => 'PlaneacionAdminBundle:Categoria'
            ))
            ->add('genero', 'choice', array('label'=>'Género:*',
                'multiple'=>false,
                'required'=>true,
//                'expanded'=>true,
                'choices' => array('2' => 'Masculino', '1' => 'Femenino'),
            ))
            ->add('licenciaturaEn',null,array('required'=>false,'label'=>'Licenciatura en:*','max_length'=> 100))
            ->add('maestriaEn',new MaestriaDoctoradoType($this->maestria),array('required'=>false,'label'=>'Maestria en:','mapped'=>false))
            ->add('doctoradoEn',new MaestriaDoctoradoType($this->doctorado),array('required'=>false,'label'=>'Doctorado en:','mapped'=>false))

            ->add('idioma1', new IdiomaProfeType($this->idioma1),array('label'=>'(1)','max_length'=>20,'mapped'=>false))
            ->add('idioma2', new IdiomaProfeType($this->idioma2),array('label'=>'(2)','max_length'=>20,'mapped'=>false))

            ->add('domicilio',null,array('required'=>false,'label'=>'Domicilio:','max_length'=> 250))
            ->add('telParticular',new PhoneType(),array('label'=>'Tel. Particular:','max_length'=> 50))
            ->add('telCelular',new MobilePhoneType(),array('label'=>'Celular:','max_length'=> 50))
            ->add('telNextel',new MobilePhoneType(),array('label'=>'Nextel:','max_length'=> 50))
            ->add('correo',null,array('required'=>false,'label'=>'Correo:*','max_length'=> 150))
            ->add('facebook',new FacebookType(),array('required'=>false,'label'=>'Facebook:','max_length'=> 50))
            ->add('lugarLabora',null,array('required'=>false,'label'=>'Lugar donde labora:','max_length'=> 250))
            ->add('telLugarLabora',new PhoneType(),array('required'=>false,'label'=>'Teléfono donde labora:','max_length'=> 250))
            ->add('dirLabora',null,array('required'=>false,'label'=>'Dirección donde labora:','max_length'=> 250))
            ->add('fechaNacimiento',null,array('required'=>false,'label'=>'Fecha de Nacimineto:'))
            ->add('estadoCivil','entity',array(
                'required'=>false,
                'label'=>'Estado civil:',
                'property'=>'nombre',
                'required'=>false,
                'class' => 'PlaneacionAdminBundle:EstadoCivil'
            ))
            ->add('nombreConyugue',null,array('required'=>false,'label'=>'Nombre conyugue:','max_length'=> 50))
            ->add('linares',null,array('required'=>false,'label'=>'Linares:'))
            ->add('sabina',null,array('required'=>false,'label'=>'Sabina:'))
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
        return 'adepsoft_planeacion_adminbundle_profesortype';
    }
}
