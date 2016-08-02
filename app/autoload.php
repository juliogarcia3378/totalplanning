<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Ladybug',__DIR__.'/../vendor/RaulFraile/Bundle');
$loader->add('RaulFraile\Bundle',__DIR__.'/../vendor');
$loader->add('FOS',__DIR__.'/../vendor');
$loader->add('Oneup',__DIR__.'/../vendor');
$loader->add('Sonata',__DIR__.'/../vendor/bundles');
$loader->add('Application',__DIR__);
$loader->add('STJ',__DIR__);
$loader->add('Knp',array(__DIR__.'/../vendor/bundles',__DIR__.'/../vendor/Knp/Menu/src'));
$loader->add('Imagine', __DIR__ . '/../vendor/imagine/lib');
$loader->add('Avalanche', __DIR__ . '/../vendor/bundles');
//$loader->registerNamespace('Ladybug',__DIR__.'/../vendor/RaulFraile/Bundle');
// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';
}

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
