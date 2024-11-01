<?php

// register short codes
add_action('init', 'wsf_register_short_codes');
function wsf_register_short_codes(){
    add_shortcode('wsf-load', 'wsf_load_callback');    
}

// short code callbacak
function wsf_load_callback(){

    $content = '
    <div class="wsf-space">

        <div class="wsf-sender">

            <form class="wsf-post-send" method="post" data-nonce="' . wsf_nonce() . '">
                
                <a href="javascript:void(0)" title="' . __( 'Cancel reply', 'wsf' ) . '" class="wsf-cancel-reply">' . __( 'Cancel reply', 'wsf' ) . '</a>

                <textarea class="wsf-send-content" name="wsf-content" placeholder="' . __( 'Write something...', 'wsf' ) . '" data-null-msg="' . __( 'Please write something.', 'wsf' ) . '" required></textarea>

                <div class="wsf-btn-status float-right">
                    <button type="submit" data-text="' . __( 'Please wait...', 'wsf' ) . '" class="wsf-sending wsf-btn wsf-btn-red">' . __( 'Send', 'wsf' ) . '</button>
                </div>

            </form>

        </div>

        <div class="wsf-general-space">   
            ' . __( 'Loading...', 'wsf' ). '
        </div>
    
    </div>';

    return $content;

}