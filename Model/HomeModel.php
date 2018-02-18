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

    /**
     * Metodo para retornar el objeto de registor de silabo
     * @global object $DB
     * @param int $id
     * @return object
     */
    public static function getSilaboById($id) {
        global $DB;
        return $DB->get_record('local_silabos', ['id' => $id]);
    }

    /**
     * Busca el registro de archivo en la tabla de archivos de sílabos
     * @global object $DB
     * @param int $id
     * @return object
     */
    public static function getFileSilaboById($id) {
        global $DB, $USER;
        $returnValue = NULL;
        if ($id > 0) {
            $returnValue = $DB->get_record('local_silabos_file', ['id' => $id]);
        } else {
            $objSilaboFile = new \stdClass();
            $objSilaboFile->id = 0;
            $objSilaboFile->int_silaboid = 0;
            $objSilaboFile->is_active = 1;
            $objSilaboFile->int_fileid = 0;
            $objSilaboFile->date_timecreated = time();
            $objSilaboFile->date_timemodified = time();
            $objSilaboFile->int_creatorid = $USER->id;
            $objSilaboFile->chr_file_name = '';
            $returnValue = $objSilaboFile;
        }
        return $returnValue;
    }

    /**
     * Método para obtener los archivos relacionado al silabo curso
     * @global object $DB
     * @return arrayObject
     */
    public static function getFilesBySilaboId() {
        global $DB;
        return $DB->get_records('local_silabos_file');
    }

    /**
     * Registra un archivo en estado desactivo y retorna el ID insert
     * @global object $DB
     * @param object $objFile
     * @return int
     */
    public static function saveFile($objFile) {
        global $DB;
        return $DB->insert_record('local_silabos_file', $objFile);
    }
    
    public static function updateFile($objFile) {
        global $DB;
        return $DB->update_record('local_silabos_file', $objFile);
    }    
    
    public static function createSilaboFile($objBeanSilaboFile) {
        global $DB;
        return $DB->insert_record('local_silabos_file', $objBeanSilaboFile);
    }    

}
