<?php 
/**
 * Plugin Name:       Yume Store
 * Description:       Plugin para acesso a API de cursos
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Paulo Fernando, Pedro Vski, Murillo Vski
 * License:           GPL v2 or later
 * Text Domain: acesso_api_cursos
 */

    if(!function_exists('add_action')){
        echo _('O plugin não pode ser passado direto');
    }

    require_once(dirname(__FILE__).'/model/cursos.viewmodel.php');

    function shortCodeListaCursos(){
        $cursos = new Cursos();

        foreach ($cursos->getCursos() as $key) {
            echo "ID Curso: {$key->course_id}";
            echo '<br>';
            echo "Nome Curso: {$key->course_title}";
            echo '<br>';
            echo "Descrição: {$key->course_description}";
            echo "<br>";
            echo "<br>";
            echo "<br>";
        }
    }

    add_shortcode('lista-cursos', 'shortCodeListaCursos');
 ?>