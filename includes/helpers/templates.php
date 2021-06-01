<?php if( ! defined( 'ABSPATH' ) ) exit;

function isActiveSpecificArchiveOrPostType( $type ) {
    return is_post_type_archive( $type ) || get_post_type( get_the_ID() ) === $type ? 'active' : '';
}

function isInSpecificType( $type, $arr ) {
    return ! is_null( $type ) && in_array( $type, $arr );
}

function getTemplateName() {
    return is_null( $wp_query->query['name'] ) ? get_queried_object()->name : $wp_query->query['name'];
}