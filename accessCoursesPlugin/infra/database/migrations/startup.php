<?php

// Verificar se o BD já foi criado.
require_once(dirname(__FILE__) . '/../../tableEndPoints.php');
require_once(dirname(__FILE__) . '/../../../model/coursesUsers.model.php' );

class DataBaseRepo {

	public static function initTableUserCourses(){
		global $wpdb;

		$table_name = $wpdb->prefix . TableEndPoints::TabelaUsersCourses ;
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			id_aluno text NOT NULL,
			id_post text NOT NULL,
			id_course text NOT NULL,
			id_usuario_wp text NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";
	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	public static function initTableCourses(){

	}
}