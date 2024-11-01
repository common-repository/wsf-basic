<?php 

// Add in $wpdb class
global $wpdb;

/**
 * Set charset
 */
$charset = 'DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';

/**
 * Post table
 */
$wsf_posts = $wpdb->prefix . "wsf_posts";
$wsf_posts = "CREATE TABLE $wsf_posts (
    post_id BIGINT(20) AUTO_INCREMENT,
    PRIMARY KEY (post_id),
    post_user_id BIGINT(20),
    post_date datetime,
    post_content text
) $charset;";

/**
 * Crate tables
 */
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $wsf_posts );