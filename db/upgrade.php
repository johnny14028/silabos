<?php

function xmldb_local_silabos_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();
    if ($oldversion < 2018011202) {

        // Define field is_deleted to be added to local_silabos_file.
        $table = new xmldb_table('local_silabos_file');
        $field = new xmldb_field('is_deleted', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'chr_name');

        // Conditionally launch add field is_deleted.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Silabos savepoint reached.
        upgrade_plugin_savepoint(true, 2018011202, 'local', 'silabos');
    }

    if ($oldversion < 2018011201) {

        // Define field chr_name to be added to local_silabos_file.
        $table = new xmldb_table('local_silabos_file');
        $field = new xmldb_field('chr_name', XMLDB_TYPE_CHAR, '200', null, null, null, null, 'chr_file_name');

        // Conditionally launch add field chr_name.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Silabos savepoint reached.
        upgrade_plugin_savepoint(true, 2018011201, 'local', 'silabos');
    }

    return true;
}
