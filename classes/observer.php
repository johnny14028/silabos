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

/**
 * Event observers supported by this module
 *
 * @package    local_silabos
 * @copyright  2017 PUCP Virtual
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Event observers supported by this module
 *
 * @package    local_silabos
 * @copyright  2017 PUCP Virtual
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_silabos_observer {

    public static function course_deleted(\core\event\course_deleted $event) {
        global $DB;
        $sql_update_to_delete = "UPDATE {local_silabos} SET is_deleted='1' WHERE int_courseid=" . $event->courseid;
        $DB->execute($sql_update_to_delete);
    }

    public static function course_created(\core\event\course_created $event) {
        global $DB, $USER;
        $course = get_course($event->courseid);
        $objBeanSilabo = new stdClass();
        $objBeanSilabo->int_courseid = $course->id;
        $objBeanSilabo->chr_course_shortname = $course->shortname;
        $objBeanSilabo->chr_course_fullname = $course->fullname;
        $objBeanSilabo->int_groupid = 0;
        $objBeanSilabo->chr_group_name = '';
        $objBeanSilabo->is_active = 0;
        $objBeanSilabo->is_deleted = 0;
        $objBeanSilabo->date_timecreated = time();
        $objBeanSilabo->date_timemodified = time();
        $DB->insert_record('local_silabos', $objBeanSilabo);
    }

}
