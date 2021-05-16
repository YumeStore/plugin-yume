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

if (!function_exists('add_action')) {
    echo _('O plugin não pode ser passado direto');
}

require_once(dirname(__FILE__) . '/model/cursos.viewmodel.php');

function shortCodeListaCursos()
{
    $cursos = new Cursos();
    $url_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
    define('pg', 'http://'.$url_host . '/eduAcademy'); // wp-content\plugins\accessCoursesPlugin/assets/css/bootstrap.min.css
?>
    <link rel="stylesheet" href="<?php  echo pg . '/wp-content/plugins/accessCoursesPlugin/assets/css/bootstrap.min.css' ?>"/>
    <table class="table table-dark">
        <thead>
            <th>ID Curso</th>
            <th>Nome Curso</th>
            <th></th>
        </thead>
        <tbody>
            <?php
            $curso_enviado = filter_input(INPUT_POST, 'AdicionarCurso', FILTER_SANITIZE_STRING);
            $dados_curso = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if($dados_curso){
               $cursos->insertCoursePost($dados_curso['courseTitle'], $dados_curso['courseDescription']);
            }
            
            foreach ($cursos->getCursos() as $key) {
            ?>
                <tr>
                    <th><?php echo $key->course_id ?></th>
                    <th><?php echo $key->course_title ?></th>
                    <th>
                        <form name="addCourse" method="POST">
                            <input type="hidden" name="courseTitle" value="<?php echo $key->course_title; ?>" />
                            <input type="hidden" name="courseDescription" value="<?php echo $key->course_description; ?>" />
                            <input type="submit" name="addCourse" value="Adicionar Curso" />
                        </form>
                    </th>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
<?php
}

add_shortcode('lista-cursos', 'shortCodeListaCursos');
?>