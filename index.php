<?php

include('../../config.php');
require_once $CFG->dirroot . '/vendor/autoload.php';

use silabos\Core\Module;

$url = new moodle_url('/local/silabos/index.php');

$PAGE->set_url($url);

require_login();

$context_system = context_system::instance();

require_capability('local/silabos:control', $context_system, $USER->id, true, "nopermissions");

$PAGE->set_pagelayout('coursecategory');

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Symfony Start.
    Module::start();
    // Symfony End.
} else {
    $name = get_string('name', 'local_silabos');
    $PAGE->set_context($context_system);
    $PAGE->navbar->add('Silabos');
    $PAGE->set_title('Silabos');
    $PAGE->set_heading('Silabos');
    $stringman = get_string_manager();
    $strings = $stringman->load_component_strings('local_silabos', $CFG->lang);
    $PAGE->requires->data_for_js('local_silabos', $strings);
    $PAGE->requires->js_call_amd('local_silabos/silabos', 'init');
    $PAGE->requires->css('/local/silabos/Resources/css/jquery.dataTables.min.css');
    $PAGE->requires->css('/local/silabos/Resources/css/bootstrap-datetimepicker.min.css');
    echo $OUTPUT->header();
    // Symfony Start.
    Module::start();
    // Symfony End.
    echo $OUTPUT->footer();
}