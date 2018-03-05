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
use context_system;
use moodle_url;
use stdClass;

class HomeService extends Template {

    private $valid_exts = ['pdf'];
    private $max_size = 20000 * 1024;

    public function __construct() {
        $this->valid_exts = ['pdf'];
    }

    /**
     * Método para listar un array de formatos o extensiones habilitadas
     * @return array
     */
    public function getValidExts() {
        return $this->valid_exts;
    }

    /**
     * Método que retorna el tamaño máximo del archivo a subir
     * @return int
     */
    public function getMaxSize() {
        return $this->max_size;
    }

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
     * Obtener la URI de la vista de formularios
     * @param int $silaboId
     * @param int $fileId
     * @return string
     */
    public function getSilabosUriFormFiles($silaboId, $fileId) {
        return $this->routes()->generate('silabos_files_form', ['silaboId' => $silaboId, 'fileId' => $fileId]);
    }

    /**
     * Método para la URL del submit donde se guarda los uploads
     * @return string
     */
    public function getSilabosFormSubmitUri() {
        return $this->routes()->generate('silabos_files_save');
    }

    /**
     * Obtenemos la URL del index del plugin sílabo
     * @return string
     */
    public function getIndexUri() {
        return $this->routes()->generate('index');
    }
    /**
     * Obtenemos la URL del ajax del plugin sílabo
     * @return string
     */
    public function getAjaxUri() {
        return $this->routes()->generate('ajax');
    }

    /**
     * Obtenemos la URL del archivo sílabo
     * @param int $fileid
     */
    public function getUriFile($fileid) {
        $returnValue = '#';
        $context = context_system::instance();
        $record = HomeModel::getMoodleFileById($fileid);
        if(is_object($record)){
            $returnValue = moodle_url::make_pluginfile_url($context->id, $record->component, $record->filearea, $record->itemid, $record->filepath, $record->filename)->out(false);
        }
        return $returnValue;
    }
    
    public function getMoodleFileById($fileid){
        return HomeModel::getMoodleFileById($fileid);
    }

    /**
     * Método para listar todos los archivo adjuntos a este registro de curso
     * @param int $silaboid
     * @return arrayObject
     */
    public function getFilesBySilaboId($silaboid) {
        $returnValue = [];
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

    /**
     * Método para cargar el objecto archivo o sílabo de un registro adjuntable
     * @param int $id
     * @return object
     */
    public function getFileSilaboById($id) {
        return HomeModel::getFileSilaboById($id);
    }

    /**
     * Método para la primera inserción de archivo en estado deshabilitado
     * retornale Insert ID
     * @global Object $USER
     * @param int $silaboid
     * @return int
     */
    public function savefile($silaboid) {
        global $USER;
        $objFile = new \stdClass();
        $objFile->int_silaboid = $silaboid;
        $objFile->is_active = 0;
        $objFile->date_timecreated = time();
        $objFile->int_creatorid = $USER->id;
        return HomeModel::saveFile($objFile);
    }

    /**
     * 
     * @param array $resultSaveFile
     * @param int $fileid
     * @return int
     */
    public function updateFile($resultSaveFile, $fileid) {
        $objFile = new \stdClass();
        $objFile->id = $fileid;
        //$objFile->is_active = 0;
        $objFile->chr_file_name = $resultSaveFile['file'];
        $objFile->int_fileid = $resultSaveFile['id'];
        return HomeModel::updateFile($objFile);
    }

    public function updateSilaboFile($objBeanSilaboFile) {
        HomeModel::updateFile($objBeanSilaboFile);
    }

    public function createSilaboFile($objBeanSilaboFile) {
        return HomeModel::createSilaboFile($objBeanSilaboFile);
    }
    
    public function disableSilabosBySilaboId($silaboid){
        HomeModel::disableSilabos($silaboid);
    }
    
    public function activeCourse($itemid, $activeid){
        HomeModel::activeCourse($itemid, $activeid);
    }
    
    public function deleteFile($itemid){
        HomeModel::deleteFile($itemid);
    }
    
    public function is_admin(){
        $returnValue = FALSE;
        if(is_siteadmin()){
            $returnValue = TRUE;
        }
        return $returnValue;
    }    

}
