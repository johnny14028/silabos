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

namespace silabos\Service;

use silabos\Core\Template;
use silabos\Model\HomeModel;
use moodle_url;
use stdClass;

class HomeService extends Template {

    /**
     * Metodo para obtener la traducción de la variable $strLan
     * @param string $strLan
     * @return string
     */
    public function getString($strLan) {
        return get_string($strLan, 'local_silabos');
    }

    /**
     * Método para listar los cursos que están registrados en la tabla de los sílabos
     * @return arrayObject
     */
    public function getCourses() {
        return HomeModel::getCourses();
    }

    /**
     * Método para obtener la URI del indice del router
     * @param int $silaboId
     * @return string
     */
    public function getSilabosUriFiles($silaboId) {
        return $this->routes()->generate('silabos_files', ['silaboId' => $silaboId]);
    }

    /**
     * Método para listar todos los archivo adjuntos a este registro de curso
     * @param int $silaboid
     * @return arrayObject
     */
    public function getFilesBySilaboId($silaboid) {
        return HomeModel::getFilesBySilaboId($silaboid);
    }

    /**
     * Método para obtener el registro del silabo
     * @param int $id
     * @return object
     */
    public function getSilaboById($id) {
        return HomeModel::getSilaboById($id);
    }

}
