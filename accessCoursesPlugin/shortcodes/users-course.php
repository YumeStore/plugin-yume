<?php

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
    $retorno = $cursos->retornoIframeCurso(get_current_user_id(), get_the_ID()); 

    $iframe = "<iframe src=\"{$retorno->course_iframe_url}\" width=\"{$width}\" height=\"{$height}\"></iframe>"; 
?>
    <div class="content"></div>
        <?php echo $iframe; ?> 
    </div>
<?php
}

add_shortcode('cursos-lista', 'shortCodeListaCursos');
add_shortcode('cursos-iframe', 'shortCodeIframe');
