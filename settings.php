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
defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) { // needs this condition or there is error on login page
    // $settings = new admin_settingpage('local_silabos', get_string('Administrarsilabos', 'local_silabos'));
    // $ADMIN->add('localplugins', $settings);
    //$settings->add(new admin_setting_configtext('local_silabos/option', 'Option', 'Information about this option', 100, PARAM_INT));
    $ADMIN->add('localplugins', new admin_externalpage('local_silabos', get_string('admin', 'local_silabos'), new moodle_url('/local/silabos')));
}