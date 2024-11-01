<?php

function wsf_human_date( $date ){
    $date = explode( " ", $date );
    $date = explode( "-", $date[0] );
    $date = implode( '/', array_reverse( $date ) );
    return $date;
}

function wsf_author_user_name( $user_id ){
    if ( $user_id != 0 ) {
        $user_data = get_userdata( $user_id );
        $user_name = $user_data->user_login;
        $user_name_full = $user_data->display_name . ' - <span>@'. $user_name.'</span>';
        $user_name = '<a href="' . esc_url( get_bloginfo('url') . '/author/' . $user_name ) . '" title="@' . $user_name . '">' . $user_name_full . '</a>';
    } else {
        $user_name = __( 'Visitor', 'wsf' );
    }
    return $user_name;
}