<?php

function xmldb_local_silabos_install() {
    global $DB;
    //listaremos todos los cursos y procederemos a crear los registros en el inidate
    $sql_courses = "SELECT * FROM {course} WHERE category > :category";
    $courses = $DB->get_records_sql($sql_courses, ['category' => 0]);
    if (is_array($courses) && count($courses) > 0) {
        foreach ($courses as $index => $objCourse) {
            $objBeanSilabos = new stdClass();
            $objBeanSilabos->int_courseid = $objCourse->id;
            $objBeanSilabos->chr_course_shortname = $objCourse->shortname;
            $objBeanSilabos->chr_course_fullname = $objCourse->fullname;
            $objBeanSilabos->int_groupid = 0;
            $objBeanSilabos->chr_group_name = '';
            $objBeanSilabos->is_active = 0;
            $objBeanSilabos->is_deleted = 0;
            $objBeanSilabos->date_timecreated = time();
            $objBeanSilabos->date_timemodified = time();
            $DB->insert_record('local_silabos', $objBeanSilabos);
        }
    }
}
