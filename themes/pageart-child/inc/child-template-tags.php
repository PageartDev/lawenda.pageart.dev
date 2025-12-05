<?php
function my_child_understrap_posted_on_output( $posted_on_html ) {
    $post = get_post();

    if ( ! $post ) {
        return '';
    }

    $date = get_the_date( 'Y-m-d', $post );

    return sprintf(
        '<span class="posted-on">%s %s</span>',
        esc_html__( 'Data publikacji', 'understrap-child' ),
        esc_html( $date )
    );
}
add_filter( 'understrap_posted_on', 'my_child_understrap_posted_on_output' );

add_filter( 'understrap_posted_by', '__return_empty_string' );