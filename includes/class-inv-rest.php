<?php if( ! defined( 'ABSPATH' ) ) exit;

class INV_Rest {
    public function init() {
        add_action( 'rest_api_init', array( 'INV_Rest', 'initRest' ) );
    }

    public function initRest() {
        /*register_rest_route( 'invmngr/v2', '/list/invoices/', array(
            'methods' => 'GET', 
            'callback' => array( 'INV_Rest', 'listInvoices' )
        ) );*/

        register_rest_field( INVMNG_PT_MAIN_NAME, 'meta-fields', array(
            'get_callback' => function ( $object ) use ( $field ) {
                $post_id = $object[ 'id' ];
                $post_data = get_post_meta( $post_id );

                unset( $post_data[ '_edit_last' ] );
                unset( $post_data[ '_edit_lock' ] );
                unset( $post_data[ '_wp_old_slug' ] );

                return $post_data;
            },
            'update_callback' => null,
            'schema' => null
        ) );

        register_rest_field( INVMNG_PT_MAIN_NAME, 'status', array(
            'get_callback' => function ( $object ) use ( $field ) {
                $postID = $object[ 'invmng-status' ][ 0 ];

                $postData = get_term( $postID, 'invmng-status' )->name;
                $metaData = get_post_meta( $postID, 'class' )[ 0 ];

                $returnData = array( 
                    'id' => $postID, 
                    'name' => $postData, 
                    'class' => $metaData 
                );

                return $returnData;
            },
            'update_callback' => null,
            'schema' => null
        ) );

        register_rest_field( INVMNG_PT_MAIN_NAME, 'restaurants', array(
            'get_callback' => function ( $object ) use ( $field ) {
                $postID = $object[ 'invmng-restaurants' ][ 0 ];

                $postData = get_term( $postID, 'invmng-restaurants' )->name;
                $metaData = get_post_meta( $postID, 'thumbnail' )[ 0 ];

                $returnData = array( 
                    'id' => $postID, 
                    'name' => $postData, 
                    'thumbnail' => $metaData 
                );

                return $returnData;
            },
            'update_callback' => null,
            'schema' => null
        ) );

        register_rest_field( INVMNG_PT_MAIN_NAME, 'orders', array(
            'get_callback' => function ( $object ) use ( $field ) {
                $postData = $object[ 'invmng-orders' ];

                return count( $postData );
            },
            'update_callback' => null,
            'schema' => null
        ) );

        add_filter( 'rest_'. INVMNG_PT_MAIN_NAME .'_query', array( 'INV_Rest', 'timeslip_meta_request_params' ), 10, 2 );
    }

    public function timeslip_meta_request_params( $args, $request ) {
        $args['meta_key']   = $request['meta_key'];
        $args['meta_value'] = $request['meta_value'];

        return $args;
    }
}