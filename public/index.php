<?php

use App\Kernel;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Doctrine\ORM\Configuration;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {

    $cache = new PhpFilesAdapter('doctrine_queries');
    $config = new Configuration();
    $config->setQueryCache($cache);
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
