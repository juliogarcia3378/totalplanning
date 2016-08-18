<?php
namespace  Core\MenuBundle\Command;

use Core\ComunBundle\Util\UtilRepository2Config;
use Core\MySecurityBundle\Entity\Permission;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ImportarPermisosCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this->setName('importarPermisos')->setDefinition(array(
            new InputOption(
                'security_yml', null, InputOption::VALUE_OPTIONAL,
                'Ruta al archivo de seguridad'
            )));
    }
    protected  function execute(InputInterface $input, OutputInterface $output){
        UtilRepository2Config::$output = $output;
        $output->write("Ejecutando\n");

        $file = $input->getOption('security_yml');
        if($file == null)
            $file = __DIR__.'/../../../../app/config/security.yml';

        $var = file_get_contents($file);

//        $kk = Yaml::parse($file);
//        ldd($kk['security']['access_control']);
        preg_match_all('/ROLE(_[A-Z]+)+/',$var,$result);

        $result = array_unique($result[0]);

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
//        $em = new EntityManager();
        $permisos_bd = $em->createQuery('select permiso.permiso from MySecurityBundle:Permission permiso')->getResult(Query::HYDRATE_SCALAR);

        $array_bd = array();
        foreach($permisos_bd as $permisos_bd)
            $array_bd[]=$permisos_bd['permiso'];

        $new_perms = array_diff($result,$array_bd);
        $toDisable = array_diff($array_bd,$result);

        if(count( $toDisable) > 0)
            $em->createQuery('update  MySecurityBundle:Permission permiso set permiso.activo = false where permiso.permiso in (:toDisable)')->setParameters(array('toDisable'=>$toDisable))
                ->execute();

        $i = 0;

        foreach($new_perms as $newPerm)
        {
            $permiso = new Permission();
            $permiso->setPermiso($newPerm);
            $permiso->setDenominacion(str_replace('_',' ',$newPerm));
            $em->persist($permiso);
            if($i++ % 20 == 0)
                $em->flush();
        }
        $em->flush();


        $output->write("Completado\n");
    }
}

?>