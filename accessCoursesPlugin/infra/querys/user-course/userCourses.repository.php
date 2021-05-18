<?php

require_once(dirname(__FILE__) . '/../../tableEndPoints.php');
require_once(dirname(__FILE__) . '/../../../model/coursesUsers.model.php');

class UserCourseRepository
{
    /**
     * Consulta os valores de id_curso e id_aluno
     * @parameter
     * @return array.
     */
    function consult_user_course($user_id, $post_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . TableEndPoints::TabelaUsersCourses;

        $sql = "SELECT id_aluno, id_curso FROM $table_name
        WHERE id_usuario_wp = $user_id AND id_post = $post_id";

        $result =  $wpdb->get_results($sql, OBJECT);

        var_dump($result);
        return $result;
    }

    // $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options WHERE option_id = 1", OBJECT );

    function insert_user_course(CoursesUsersModel $coursesUsers)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . TableEndPoints::TabelaUsersCourses;

        $sql = "INSERT INTO $table_name ('id_aluno','id_course','id_post','id_post') 
                VALUES ($coursesUsers->id_aluno, 
                        $coursesUsers->id_course, 
                        $coursesUsers->id_post, 
                        $coursesUsers->id_usuario_wp)";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}