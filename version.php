<?php

defined('MOODLE_INTERNAL') || die;

$plugin->version   = 2018011201; // The (date) version of this plugin
$plugin->maturity = MATURITY_STABLE;
$plugin->release   = '3.4+ (Build: 20171208)';
$plugin->requires  = 2016120500; // Requires this Moodle version
$plugin->component = 'local_silabos';

// Requiere campusbcp para los jss y css.
//$plugin->dependencies = ['theme_campusbcp' => 2017042000];