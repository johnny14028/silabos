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

namespace silabos\Model;

/**
 * Class HomeModel.
 * Silabos
 * =======
 * Los silabos se encarga de añadir una fecha de inicio y fin a cada grupo dentro de un curso.
 *
 * @copyright  2017 Pucp Virtual <www.pucp.edu.pe>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class HomeModel {

    /**
     * Metodo para obtener de la BD los registos de la tabla sílabos
     * @global object $DB
     * @return arrayObject
     */
    public static function getCourses() {
        global $DB;
        return $DB->get_records('local_silabos', ['is_deleted' => '0']);
    }

    public static function getSilaboById($id) {
        global $DB;
        return $DB->get_record('local_silabos', ['id' => $id]);
    }
    
    public static function getFilesBySilaboId() {
        global $DB;
        return $DB->get_records('local_silabos_file');
    }    

}
