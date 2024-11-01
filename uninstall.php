<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// delete options
delete_option( 'wsf-start' );

// delete plugin tables
global $wpdb;

$wsf_posts = $wpdb->prefix . "wsf_posts";

$wpdb->query( "DROP TABLE IF EXISTS $wsf_posts" );