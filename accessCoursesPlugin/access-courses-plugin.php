<?php

/**
 * Plugin Name:       Yume Store
 * Description:       Plugin para acesso a API de cursos
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Murillo Vincente Araujo, Paulo Fernando Lima Ornelas do Amaral, Pedro Baptista dos Santos
 * License:           GPL v2 or later
 * Text Domain: acesso_api_cursos
 */

require_once 'config/config.php';
require_once 'infra/database/migrations/startup.php';
require_once 'shortcodes/users-course.php';

if (!function_exists('add_action')) {
    echo _('O plugin não pode ser passado direto');
}

function acesso_api_cursos_activate() { 
    DataBaseRepo::initTableUserCourses();
    DataBaseRepo::initTableCourses();
}

register_activation_hook( __FILE__, 'acesso_api_cursos_activate' );
