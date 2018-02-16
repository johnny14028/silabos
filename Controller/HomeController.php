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
use core\output\notification;

class HomeController extends HomeService {

    private $params;

    public function __construct() {
        $this->params = [];
    }

    /**
     * Vista para listar los registros de la tabla sílabos
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {
        $courses = $this->getCourses();
        $this->params['courses'] = $courses;
        return $this->template('Home')->renderResponse('index.html.twig', $this->params);
    }

    /**
     * Método para listar los archivos de tipo sílabo subido por curso
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filesAction(Request $request) {
        $silaboid = $request->attributes->get('silaboId');
        if ($silaboid == 0) {
            redirect($this->routes()->generate('index'), 'Falta el ID del registro', 2, notification::NOTIFY_ERROR);
        }
        $files = $this->getFilesBySilaboId($silaboid);
        $objSilabo = $this->getSilaboById($silaboid);
        $this->params['files'] = $files;
        $this->params['objSilabo'] = $objSilabo;
        return $this->template('Home')->renderResponse('files.html.twig', $this->params);
    }

}
