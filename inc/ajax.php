<?php 

// create nonce
function wsf_nonce(){
    wp_enqueue_script( 'wsf_ajax_js' );
    $nonce = wp_create_nonce( 'wsf-nonce' );
    return esc_attr( $nonce );
}

// ajax action
function wsf_ajax_action( $action ){
	add_action( 'wp_ajax_'.$action.'' , $action );
    add_action( 'wp_ajax_nopriv_'.$action.'' , $action );
    return;
}

// new nonce create
wsf_ajax_action( "wsf_new_nonce" );
function wsf_new_nonce(){

	echo wsf_nonce();

    wp_die();

}

/**
 * to load with ajax after installing to disable cache systems.
 */
wsf_ajax_action( "wsf_load_post_list" );
function wsf_load_post_list(){

    global $wsf_post;
	echo $wsf_post->wsf_post_list();

    wp_die();
    
}

// send new post
wsf_ajax_action( "wsf_send_post" );
function wsf_send_post(){

    // nonce control
	check_ajax_referer( 'wsf-nonce', 'nonce' );

    $content = (isset( $_POST['wsf-content'] )) ? sanitize_text_field( $_POST['wsf-content'] ) : null;

    if ( $content != null && is_string( $content ) ) {

        global $wpdb, $wsf_post;
        $table_name = $wpdb->prefix . "wsf_posts";
        
        $post_id = $wsf_post->insert_post( $content );

        $current_post = $wpdb->get_row("SELECT * FROM $table_name WHERE post_id = $post_id");

        echo $wsf_post->wsf_post_list_li( $current_post );

    } else {
        echo 'invalid';
    }

	wp_die();

}

// load more post
wsf_ajax_action( "wsf_load_more_post" );
function wsf_load_more_post(){

	// nonce control
    check_ajax_referer( 'wsf-nonce', 'nonce' );

    $paged = (isset( $_POST['post'] )) ? intval( $_POST['post'] ) : null;
    $count = (isset( $_POST['count'] )) ? intval( $_POST['count'] ) : null;

    if ( is_integer( $count ) && is_integer( $paged ) ) {
        global $wsf_post;
        echo $wsf_post->wsf_post_list( $paged, $count, true );
    } else {
        echo 'invalid';
    }

    wp_die();

}