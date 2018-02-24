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
use context_system;
use moodle_url;

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

    /**
     * Método para cargar un formulario de registro de archivos para un sílabo
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formfilesAction(Request $request) {
        $silaboid = $request->attributes->get('silaboId');
        $fileid = $request->attributes->get('fileId');
        if ($silaboid == 0 && $fileid == 0) {
            redirect($this->routes()->generate('index'), 'Falta el ID del registro', 2, notification::NOTIFY_ERROR);
        }
        $objSilabo = $this->getSilaboById($silaboid);
        $objFile = $this->getFileSilaboById($fileid);
        $exist_file = 0;
        $record = $this->getMoodleFileById($objFile->int_fileid);
        if(is_object($record)){
            $exist_file = 1;
        }
        $objFile->int_silaboid = $silaboid;
        $this->params['objFile'] = $objFile;
        $this->params['objSilabo'] = $objSilabo;
        $this->params['exist_file'] = $exist_file;
        return $this->template('Home')->renderResponse('form.html.twig', $this->params);
    }

    public function saveAction(Request $request) {
        global $USER;
        $post = $request->request->all();
        $success = true;
        $message = '';
        $fileid = 0;
        if ($post['id'] > 0) {
            //verificamos si es una habilitación
            if($post['inputIsActive']){
                //desactivamos todos los archivos con respecto al curso
                //para garintizar que solo exista un sílabo activo por curso
                $this->disableSilabosBySilaboId($post['silaboid']);
            }
            //actualizar el registro file
            $objBeanSilaboFile = new \stdClass();
            $objBeanSilaboFile->id = $post['id'];
            $objBeanSilaboFile->int_silaboid = $post['silaboid'];
            $objBeanSilaboFile->is_active = $post['inputIsActive'];
            $objBeanSilaboFile->date_timemodified = time();
            $objBeanSilaboFile->int_creatorid = $USER->id;
            $objBeanSilaboFile->chr_name = $post['inputName'];
            $this->updateSilaboFile($objBeanSilaboFile);
        } else {
            //verificamos si es una habilitación
            if($post['inputIsActive']){
                //desactivamos todos los archivos con respecto al curso
                //para garintizar que solo exista un sílabo activo por curso
                $this->disableSilabosBySilaboId($post['silaboid']);
            }            
            //crear un nuevo registro file
            $objBeanSilaboFile = new \stdClass();
            $objBeanSilaboFile->id = $post['id'];
            $objBeanSilaboFile->int_silaboid = $post['silaboid'];
            $objBeanSilaboFile->is_active = $post['inputIsActive'];
            $objBeanSilaboFile->int_fileid = 0;
            $objBeanSilaboFile->date_timecreated = time();
            $objBeanSilaboFile->date_timemodified = time();
            $objBeanSilaboFile->int_creatorid = $USER->id;
            $objBeanSilaboFile->chr_file_name = '';
            $objBeanSilaboFile->chr_name = $post['inputName'];
            $post['id'] = $this->createSilaboFile($objBeanSilaboFile);
        }
        if (is_object($request->files->get('inputFile'))) {
            //print_object($request->files->get('inputFile')->getClientOriginalExtension());
            $valid_exts = $this->getValidExts();
            if ($request->files->get('inputFile')->getError()) {
                $success = false;
                $message = 'Ocurrio un error inesperado al intentar subir el archivo';
            } elseif (!in_array($request->files->get('inputFile')->getClientOriginalExtension(), $valid_exts)) {
                //validamos las extensiones del archivo
                $success = false;
                $message = 'Solo se permiten formatos: ' . implode(',', $valid_exts);
            } elseif ($request->files->get('inputFile')->getClientSize() > $this->getMaxSize()) {
                //validamos que el peso del archivo sea correcto
                $success = false;
                $message = 'Solo se permiten archivos con peso menor a ' . $this->getMaxSize();
            } else {
                //realizamos el registro de un archivo en estado desactivo
                $fileid = $post['id'];
                $resultSaveFile = $this->uploadfile('pdf', $request->files->get('inputFile'), $fileid);
                if ($resultSaveFile['id'] == 0) {
                    $success = false;
                    $message = 'Sucedió un error al crear el archivo temporal';
                } else {
                    //actualizamos el registro del file a un estado activo
                    $this->updateFile($resultSaveFile, $fileid);
                }
            }
        }
//        $status = $response['success'] ? 200 : 500; // Status code de la respuesta.
//        return new JsonResponse($response, $status);
        redirect($this->routes()->generate('silabos_files', ['silaboId' => $post['silaboid']]), get_string('changessaved'));
        die();
    }

    private function uploadfile($elname, $files, $itemid) {
        global $USER, $DB, $CFG;
        $author = '';
        $license = $CFG->sitedefaultlicense;
        $savepath = '/';
        $record = new \stdClass();
        $record->filearea = $elname;
        $record->component = 'local_silabos';
        $record->filepath = $savepath;
        $record->itemid = $itemid;
        $record->license = $license;
        $record->author = $author;
        $context = context_system::instance();
        $fs = get_file_storage();
        $sm = get_string_manager();
        if ($record->filepath !== '/') {
            $record->filepath = file_correct_filepath($record->filepath);
        }
        // Get file
        $file = $fs->get_file($context->id, $record->component, $record->filearea, $record->itemid, $record->filepath, $files->getClientOriginalName());
        // Delete it if it exists
        if ($file) {
            $file->delete();
        }
        $record->source = $this->build_source_field($files->getClientOriginalName());
        if (empty($saveas_filename)) {
            $record->filename = clean_param($files->getClientOriginalName(), PARAM_FILE);
        } else {
            $ext = '';
            $match = [];
            $filename = clean_param($files->getClientOriginalName(), PARAM_FILE);
            if (strpos($filename, '.') === false) {
                // File has no extension at all - do not add a dot.
                $record->filename = $saveas_filename;
            } else {
                if (preg_match('/\.([a-z0-9]+)$/i', $filename, $match)) {
                    if (isset($match[1])) {
                        $ext = $match[1];
                    }
                }
                $ext = !empty($ext) ? $ext : '';
                if (preg_match('#\.(' . $ext . ')$#i', $saveas_filename)) {
                    // saveas filename contains file extension already
                    $record->filename = $saveas_filename;
                } else {
                    $record->filename = $saveas_filename . '.' . $ext;
                }
            }
        }
        $record->contextid = $context->id;
        $record->userid = $USER->id;
        $stored_file = $fs->create_file_from_pathname($record, $files->getPathname());
        //make_pluginfile_url
        return [
            'url' => moodle_url::make_pluginfile_url($context->id, $record->component, $record->filearea, $record->itemid, $record->filepath, $record->filename)->out(false),
            'itemid' => $record->itemid,
            'id' => $stored_file->get_id(),
            'file' => $record->filename,];
    }

    public function build_source_field($source) {
        $sourcefield = new \stdClass();
        $sourcefield->source = $source;
        return serialize($sourcefield);
    }
    
    public function ajaxAction(Request $request) {
        global $USER;
        $subject = $request->request->get('subject');
        switch ($subject) {
            case 'activeCourse':
                $activeid = $request->request->get('active');
                $itemid = $request->request->get('itemid');
                $this->activeCourse($itemid, $activeid);
                $response['success'] = true;
                $status = $response['success'] ? 200 : 500; // Status code de la respuesta.
                return new JsonResponse($response, $status);
                break;
        }
    }    

}
