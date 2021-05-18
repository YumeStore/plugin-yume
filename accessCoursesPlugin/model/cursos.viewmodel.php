<?php
require_once(dirname(__FILE__) . '/../consumo-api/consumo-api.php');
require_once(dirname(__FILE__) . '/cursos.model.php');
require_once(dirname(__FILE__) . '/../infra/querys/user-course/userCourses.repository.php');
class Cursos
{
    var $consumoApi;

    /**
     * Constrói uma instância da classe ConsumoApi
     */
    function __construct()
    {
        $this->consumoApi = new ConsumoApi('https://www.iped.com.br/', 'b6d5ee6c0bee8cb0e35a33e9677b45afc60d7eff');
    }

    /**
     * Retorna todos os cursos da primeira página.
     */
    public function getAllCursos($nameFilter = "")
    {
        $retorno = $this->consumoApi->retornoListaCursos($nameFilter);
        $retorno_array = json_decode($retorno);
        
        return $retorno_array->COURSES;
    }

    /**
     * Insere curso como post do learn press.
     */
    public function insertCoursePost(CursosModel $curso)
    {
        $courseUserRepository = new UserCourseRepository();

        // Create post object
        $my_post = array(
            'post_title'    => $curso->course_title,
            'post_content'  => $curso->course_description,
            'post_status'   => 'publish',
            'post_author'   => get_current_user_id(),
            'comment_status' => 'closed',
            'post_name' => $curso->course_title,
            'post_type' => 'lp_course',
            'meta_input'   => array(
                'id_course' => $curso->course_id,
            ),

        );

       $post_id = wp_insert_post($my_post);
       $aula_id = $this->createLesson($curso);

       $courseUserRepository->insert_lesson_section($post_id, $curso->course_title, $aula_id);
    }

    /**
     * Cria uma lesson.
     */
    private function createLesson(CursosModel $curso)
    {
        $my_post = array(
            'post_title'    => "Aula, {$curso->course_title}",
            'post_content'  => '[cursos-iframe]',
            'post_status'   => 'publish',
            'post_author'   => get_current_user_id(),
            'comment_status' => 'closed',
            'post_name' => "aula-$curso->course_title",
            'post_type' => 'lp_lesson',
            'meta_input'   => array(
                'id_course' => $curso->course_id,
            ),
        );

       $post_id = wp_insert_post($my_post);

       return $post_id;
    }

    /**
     * Retorna IFrame do referente curso.
     */
    public function retornoIframeCurso($id_usuario_wp, $id_post)
    {
        $repo = new UserCourseRepository();
        $retorno = $repo->consult_user_course($id_usuario_wp, $id_post);

        if($retorno){ 
            $retorno = $this->consumoApi->retornoIframeCurso($retorno[0]->id_aluno, $retorno[0]->id_course);
            $retorno_array = json_decode($retorno);

            return $retorno_array->ENVIRONMENT;
        }else{
            return null;
        }
    }

    /**
     * Retorna id usuario matricula.
     */
    public function retornoIdUsuarioMatricula($user_cpf, $curso_id, $user_name, $user_email ){
        $retorno = $this->consumoApi->postRegistration($user_cpf, $curso_id, $user_name, $user_email);
        $retorno_array = json_decode($retorno);
        
        return $retorno_array->REGISTRATION->user_id;
    }

}
