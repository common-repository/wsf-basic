<?php 

/**
 * WSF Post class
 */
class wsf_posts{

    public function insert_post( $content ){

        global $wpdb;
        $table_name = $wpdb->prefix . "wsf_posts";

        $wsf_posts = array(
            "post_user_id" => $this->get_user_id(),
            "post_date" => $this->get_date(),
            "post_content" => $content,
        );

        $wpdb->insert( $table_name,  $wsf_posts );

        $result = $wpdb->insert_id;

        return $result;

    }

    /**
     * to load with ajax after installing to disable cache systems.
     */
    public function wsf_post_list( $paged = null, $count = null, $load_more = false ){

        global $wpdb;
        $posts_table = $wpdb->prefix . "wsf_posts"; 
        $content = ""; 

        if ( $paged == null && $count == null ) :
            $paged = 1;
            $count = 10;
        endif;
        
        $offset = ( $paged - 1 ) * $count;
        $total = $wpdb->get_var( "SELECT COUNT(`post_id`) FROM $posts_table ORDER BY post_id DESC" );
        $total_pages = ceil( $total / $count );

        if ( $load_more == false ) {
            $content .= '<ul class="wsf-posts-list">';
        }

            $posts_result = $wpdb->get_results( "SELECT * FROM $posts_table ORDER BY post_id DESC LIMIT $offset, $count" );

            if ( $posts_result ) :
                foreach ( $posts_result as $post ) :
                    
                    $content .= $this->wsf_post_list_li( $post );
                        
                endforeach;
            else :
                $content .= __( 'No content found! How about you make the first post?', 'wsf' );
            endif;
        
        if ( $load_more == false ) {
            $content .= '</ul>';
        }

        if ( $count < $total && $load_more == false ) {
            $content .= '
                <div class="center">
                    <div class="wsf-btn-status">
                        <button class="wsf-load-more-post wsf-btn wsf-btn-red" data-text="' . __( 'Please wait...', 'wsf' ) . '" data-paged="1" data-count="'. $count .'" data-max-page="'. $total_pages .'" data-nonce="'. wsf_nonce() .'">' . __( 'Load more post', 'wsf' ) . '</button>
                    </div>
                </div>';
        }

        return $content;

    }

    // post list li
    public function wsf_post_list_li( $post ){

        $post_id = $post->post_id;
        $user_id = $post->post_user_id;
        $post_content = $post->post_content;

        $post_date = wsf_human_date( $post->post_date );

        $user_name = wsf_author_user_name( $user_id );

        $avatar = get_avatar( $user_id, "60" );

        $content = '
        <li id="wsf-post-id-' . $post_id . '" class="wsf-post-class" data-id="' . $post_id . '">

            <div class="wsf-avatar">
                ' . $avatar . '
            </div>

            <div class="wsf-user-name">
                ' . $user_name . '
            </div>

            <div class="wsf-post-content-space wsf-background">

                <article class="wsf-post-content">

                    ' . stripslashes( $post_content ) . '

                </article>

                <span class="wsf-date">
                    ' . $post_date . '
                </span>
                
            </div><!-- wsf-post-content-space -->

            <div class="clear"></div>

        </li>';

        return $content;

    }

    private function get_user_id(){

        if ( is_user_logged_in() ) {
            global $current_user;
            $user_id = $current_user->ID;
        } else {
            $user_id = 0;
        }

        return $user_id;

    }

    private function get_date(){

        return strval( date('Y-m-d H:i:s') );

    }

}