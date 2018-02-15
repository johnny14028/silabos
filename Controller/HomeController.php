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

namespace silabos\Controller;

use silabos\Service\HomeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends HomeService {

    private $params;

    public function __construct() {
        $this->params = [];
    }

    /**
     * Vista Home.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {        
        return $this->template('Home')->renderResponse('index.html.twig', $this->params);
    }
}