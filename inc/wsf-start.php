<?php 

// first start crate tables
$wsf_start = get_option('wsf-start');
if ( empty( $wsf_start ) ){
    require_once WSF_PATH . 'inc/create-db-tables.php';
    add_option( 'wsf-start', true );
}
       
// wsf load all files
require_once WSF_PATH . 'inc/assets.php';
require_once WSF_PATH . 'inc/functions.php';

// load & start class
require_once WSF_PATH . 'classes/class.posts.php';
$wsf_post = new wsf_posts;

// other files
require_once WSF_PATH . 'inc/ajax.php';
require_once WSF_PATH . 'inc/short-code.php';