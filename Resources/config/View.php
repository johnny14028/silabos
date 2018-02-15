<?php

namespace silabos\Resources\config;

class View
{
    public static function getCollection($controller)
    {
        $viewRoute = dirname(__DIR__, 1) . '/views/' . $controller . '/';

        return $viewRoute;
    }
}
