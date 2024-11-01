<?php 

// hook to enqueue front assets
function wsf_front_assets() {
    wp_enqueue_script( 'wsf_ajax_js', WSF_URL . 'assets/js/main.js' );
    wp_enqueue_style( 'wsf_style', WSF_URL . 'assets/css/style.css' );
    wp_localize_script( 'wsf_ajax_js', 'url', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wsf_front_assets' );