<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
namespace silabos\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;
use silabos\Resources\config\Routes;

class Module
{
    public static function start()
    {
        $request = Request::createFromGlobals();

        $routes = Routes::getCollection();

        $context = new Routing\RequestContext();
        $matcher = new Routing\Matcher\UrlMatcher($routes, $context);

        $controllerResolver = new ControllerResolver();
        $argumentResolver   = new ArgumentResolver();

        $framework = new Framework($matcher, $controllerResolver, $argumentResolver);
        $response  = $framework->handle($request);

        $response->send();
    }

    /**
     * Retorna verdadero si el request es Ajax.
     *
     * @return bool
     */
    public static function isAjax()
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            return true;
        }

        return false;
    }
}