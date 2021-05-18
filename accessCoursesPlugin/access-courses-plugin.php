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
include_once 'config/config.php';

if (!function_exists('add_action')) {
    echo _('O plugin não pode ser passado direto');
}

require_once(dirname(__FILE__) . '/model/cursos.viewmodel.php');

function shortCodeListaCursos()
{
    $cursos = new Cursos();
?>
    <link rel="stylesheet" href="<?php echo pg . '/wp-content/plugins/accessCoursesPlugin/assets/css/bootstrap.min.css' ?>" />
    <div class="content">
        <table class="table table-striped table-dark">
            <thead>
                <th scope="col">ID Curso</th>
                <th scope="col">Nome Curso</th>
                <th scope="col"></th>
            </thead>
            <tbody>
                <?php
                $curso_enviado = filter_input(INPUT_POST, 'AdicionarCurso', FILTER_SANITIZE_STRING);
                $dados_curso = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if ($dados_curso) {
                    $cursos->insertCoursePost($dados_curso['courseTitle'], $dados_curso['courseDescription']);
                }

                foreach ($cursos->getAllCursos() as $key) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $key->course_id ?></th>
                        <th scope="row"><?php echo $key->course_title ?></th>
                        <th scope="row">
                            <form name="addCourse" method="POST">
                                <input type="hidden" name="courseTitle" value="<?php echo $key->course_title; ?>" />
                                <input type="hidden" name="courseDescription" value="<?php echo $key->course_description; ?>" />
                                <input type="submit" class="btn btn-success h-50" name="addCourse" value="Adicionar Curso" />
                            </form>
                        </th>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
    </div>
<?php
}

function shortCodeIframe($atts)
{
    $width = empty( $atts['width'] ) ? '90%' : $atts['width'];
    $height = empty( $atts['height'] ) ? '200' : $atts['height'];

    $cursos = new Cursos();
    $retorno = $cursos->retornoIframeCurso('6299133', '55387'); 

    $iframe = "<iframe src=\"{$retorno->course_iframe_url}\" width=\"{$width}\" height=\"{$height}\"></iframe>"; 
?>
    <div class="content"></div>
        <?php echo $iframe; ?> 
    </div>
<?php
}

add_shortcode('cursos-lista', 'shortCodeListaCursos');
add_shortcode('cursos-iframe', 'shortCodeIframe');

function acesso_api_cursos_activate() { 
    // Verificar se o BD já foi criado.
    global $wpdb;

	$table_name = $wpdb->prefix . '_yume_cursos_aluno';
	$charset_collate = $wpdb->get_charset_collate();
    
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		text text NOT NULL,
        id_aluno text NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

register_activation_hook( __FILE__, 'acesso_api_cursos_activate' );

?>
