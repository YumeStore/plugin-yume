<?php

require_once(dirname(__FILE__) . '/../model/cursos.viewmodel.php');
require_once(dirname(__FILE__) . '/../model/cursos.model.php');
require_once(dirname(__FILE__) . '/../infra/querys/user-course/userCourses.repository.php');

function shortCodeListaCursos()
{
    $cursos = new Cursos();
    ?>
    <link rel="stylesheet" href="<?php echo pg . '/wp-content/plugins/accessCoursesPlugin/assets/css/bootstrap.min.css' ?>" />
    <div class="content">
        <div class="row m-4">
            <form name="searchCourse" method="POST">
                <div class="row my-4">
                    <div class="col mx-2">
                        <label>Search Curso: </label>
                    </div>
                    <div class="col-9 mx-2">
                        <input type="text" id="nameCurso" name="nameCurso">
                    </div>
                    <div class="col mx-2">
                        <input type="submit" class="btn btn-success" name="searchCourse" value="Search Curso" />
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <table class="table table-striped table-dark">
                <thead>
                    <th scope="col">ID Curso</th>
                    <th scope="col">Nome Curso</th>
                    <th scope="col"></th>
                </thead>
                <tbody>
                    <?php
                    $course_title = filter_input(INPUT_POST, 'courseTitle', FILTER_SANITIZE_STRING);
                    $course_description = filter_input(INPUT_POST, 'courseDescription', FILTER_SANITIZE_STRING);
                    $course_id = filter_input(INPUT_POST, 'courseId', FILTER_SANITIZE_STRING);

                    if ($course_title) {
                        $curso = new CursosModel();
                        $curso->course_id = $course_id;
                        $curso->course_title = $course_title;
                        $curso->course_description = $course_description;

                        $cursos->insertCoursePost($curso);
                    }

                    foreach ($cursos->getAllCursos(empty($_POST['nameCurso']) ? "" : $_POST['nameCurso']) as $key) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $key->course_id ?></th>
                            <th scope="row"><?php echo $key->course_title ?></th>
                            <th scope="row">
                                <form name="addCourse" method="POST">
                                    <input type="hidden" name="courseTitle" value="<?php echo $key->course_title; ?>" />
                                    <input type="hidden" name="courseDescription" value="<?php echo $key->course_description; ?>" />
                                    <input type="hidden" name="courseId" value="<?php echo $key->course_id; ?>" />
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
    </div>
    <?php
}

/**
 * Retorna o Iframe do Curso.
 */
function shortCodeIframe($atts)
{
    $width = empty($atts['width']) ? '90%' : $atts['width'];
    $height = empty($atts['height']) ? '200' : $atts['height'];

    $cursos = new Cursos();
    $retorno = $cursos->retornoIframeCurso(get_current_user_id(), get_the_ID());

    if ($retorno) {
        $html = "<iframe src=\"{$retorno->course_iframe_url}\" width=\"{$width}\" height=\"{$height}\"></iframe>";
    }else{
        ?>
            <div class="content">
                <form action="matriculaCurso" method="post">
                    <input type="hidden" name="idUsuario" value="<?php echo get_current_user_id() ?>">
                    <input type="hidden" name="idCurso" value="<?php echo get_post_meta(get_the_ID(), 'id_course') ?>">
                    <input type="submit" value="Iniciar Curso">
                </form>
            </div>
        <?php
    }
    ?>
        <div class="content"></div>
        <?php
            echo $html;
        ?>
        </div>
    <?php
}

add_shortcode('cursos-lista', 'shortCodeListaCursos');
add_shortcode('cursos-iframe', 'shortCodeIframe');
