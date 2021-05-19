<?php

function minhas_configuracoes() {
    $args = array(
        'type' => 'string', 
        'sanitize_callback' => 'sanitize_text_field',
        'default' => NULL,
        );
    register_setting( 'general', 'Teste', $args ); 
}

add_action( 'admin_init', 'minhas_configuracoes' );