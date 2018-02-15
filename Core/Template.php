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

use moodle_url;

use silabos\Resources\config\Routes;
use silabos\Service\HomeService;
use silabos\Resources\config\View;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\DelegatingEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Template
{
    public function template($controller)
    {
        $viewDirroot = View::getCollection($controller);

        $loader = new Twig_Loader_Filesystem($viewDirroot);
        $twig   = new Twig_Environment($loader);

        // Add global services here
        $twig->addGlobal('home', new HomeService());
        $templating = new TwigEngine($twig, new TemplateNameParser(), new FileLocator($viewDirroot));

        return $templating;
    }

    public function routes()
    {
        $routes = Routes::getCollection();

        $context = new RequestContext();
        $url     = new moodle_url('/local/silabos');
        $context->setBaseUrl($url);

        $generator = new UrlGenerator($routes, $context);

        return $generator;
    }
}