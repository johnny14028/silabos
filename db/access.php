<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/silabos:control' => [
        'riskbitmask'  => RISK_PERSONAL,
        'captype'      => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => [
            'manager' => CAP_ALLOW,],],];