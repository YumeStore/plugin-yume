<?php
class Cursos
{
    public function getCursos()
    {
        require_once(dirname(__FILE__) . '/../consumo-api/consumo-api.php');

        $consumoApi = new ConsumoApi('https://www.iped.com.br/', 'b6d5ee6c0bee8cb0e35a33e9677b45afc60d7eff');

        $retorno = $consumoApi->retornoListaCursos();
        $retorno_array = json_decode($retorno);

        return $retorno_array->COURSES;
    }

    public function insertCoursePost($post_title, $post_content)
    {
        // Create post object
        $my_post = array(
            'post_title'    => $post_title,
            'post_content'  => $post_content,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'comment_status' => 'closed',
            'post_name' => 'novo-curso-wp',
            'post_type' => 'lp_course'
        );

        // Insert the post into the database
        wp_insert_post($my_post);
    }
}