<?php

require_once(dirname(__FILE__) . '/../../tableEndPoints.php');
require_once(dirname(__FILE__) . '/../../../model/coursesUsers.model.php');
class UserCourseRepository
{
    /**
     * Consulta os valores de id_curso e id_aluno.
     * @param 
     * @return array.
     */
    function consult_user_course($user_id, $post_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . TableEndPoints::TabelaUsersCourses;

        $sql = "SELECT id_aluno, id_course FROM $table_name
        WHERE id_usuario_wp = $user_id AND id_post = $post_id";

        $result =  $wpdb->get_results($sql, OBJECT);

        return $result;
    }

    /**
     * Insere um curso no learn press.
     */
    function insert_user_course(CoursesUsersModel $coursesUsers)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . TableEndPoints::TabelaUsersCourses;

        $sql = "INSERT INTO $table_name ('id_aluno_wp','id_aluno','id_curso','id_post') 
                VALUES (%s, %s, %s, %s)";

        $wpdb->query(
            $wpdb->prepare($sql, $coursesUsers->id_usuario_wp , $coursesUsers->id_aluno, $coursesUsers->id_course, $coursesUsers->id_post)
        );
    }

    function insert_lesson_section($courseId, $courseName, $lesonId)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . TableEndPoints::TabelaLearPressSection;

        $sql = "INSERT INTO $table_name ( section_name, section_course_id, section_order )
                VALUES ( %s, %s, %s )";

        $sectionName   = "Modulo, {$courseName}";

        $wpdb->query(
            $wpdb->prepare($sql, $sectionName, $courseId, '2')
        );

        $retornoId = $wpdb->get_results( "SELECT section_id FROM {$table_name} WHERE section_course_id = {$courseId}", OBJECT );

        $this->insert_lesson_section_item($lesonId, $retornoId[0]->section_id);
    }

    /**
     * 
     */
    function insert_lesson_section_item($lesonId, $sectionId)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . TableEndPoints::TabelaLearnPressSectionItems;

        $sql = "INSERT INTO $table_name ( section_id, item_id, item_type, item_order )
                VALUES ( %s, %s, %s, %s )";

        $wpdb->query(
            $wpdb->prepare($sql, $sectionId, $lesonId, 'lp_lesson', '1')
        );
    }
}
