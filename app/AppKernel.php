<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),

            new ADEPSOFT\ComunBundle\ComunBundle(),
            new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new \Knp\Bundle\MenuBundle\KnpMenuBundle(),
			new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),

            new \Oneup\UploaderBundle\OneupUploaderBundle(),
            new ADEPSOFT\MenuBundle\ADEPSOFTMenuBundle(),
            new ADEPSOFT\MySecurityBundle\MySecurityBundle(),

            new ADEPSOFT\Planeacion\AdminBundle\PlaneacionAdminBundle(),
            new \Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new ADEPSOFT\Planeacion\HorarioBundle\HorarioBundle(),
           /* new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),*/
            new TotalPlanning\GeneralConfigBundle\GeneralConfigBundle(),
            new Site\SiteBundle\SiteBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {

            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
     public function __construct($environment, $debug)
    {
        date_default_timezone_set( 'America/Los_Angeles' );
        parent::__construct($environment, $debug);
    }

}
