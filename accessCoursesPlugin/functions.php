<?php

    echo '<h2>page</h2>';
    
if (array_key_exists("courseTitle", $_POST)){
    $post_title = $_POST['courseTitle'];
    $post_content = $_POST['courseDescription'];


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

    echo '<h2>Curso Adicionado !</h2>';
}
    

?>