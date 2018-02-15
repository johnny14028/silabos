<?php

namespace silabos\Resources\config;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

class Routes
{
    /**
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public static function getCollection()
    {
        $locator = new FileLocator([__DIR__]);
        $loader  = new YamlFileLoader($locator);

        return $loader->load('routes.yml');
    }
}
