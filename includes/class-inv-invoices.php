<?php if( ! defined( 'ABSPATH' ) ) exit;

class INV_Invoices {
    public function __construct() {}
    
    public function init( $taxonomyID, $taxonomyLabel, $taxonomySlug ) {
        register_post_type( INVMNG_PT_MAIN_NAME,
            array(
                'labels' => array(
                    'name' => __( $taxonomyLabel ),
                    'singular_name' => __( $taxonomyLabel )
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array( 'slug' => $taxonomySlug ),
                'show_in_rest' => true,
                'supports' => array( 'title' ),
            )
        );

        add_filter( 'invmng_invoices_category', array( 'INV_Invoices', 'invoiceCategory' ) );
        add_action( 'save_post_' . INVMNG_PT_MAIN_NAME, array( 'INV_Invoices', 'overrideSave' ), 20, 2 );
    }

    public function invoiceCategory() {
        $invCat = (object)array( 'name' => 'ALL', 'taxonomy' => INVMNG_PT_MAIN_NAME . '-status', 'term_id' => 0 );
        $terms = get_terms([
            'taxonomy' => INVMNG_PT_MAIN_NAME . '-status',
            'hide_empty' => false,
        ]);

        array_unshift( $terms, $invCat );
        return $terms;
    }

    public function overrideSave( $post_id, $post ) {   
        $terms = get_the_terms( $post_id, INVMNG_PT_MAIN_NAME . '-orders' );
        $total = 0; $fees = 0;

        for( $i=0; $i < count( $terms ); $i++ ) {
            $term = $terms[ $i ];
            $meta = get_post_meta( $term->term_id );

            $total += (float)$meta[ 'total' ][ 0 ];
            $fees += (float)$meta[ 'fees' ][ 0 ];
        }

        $transfer = $total + $fees;

        update_post_meta( $post_id, 'total', $total );
        update_post_meta( $post_id, 'fees', $fees );
        update_post_meta( $post_id, 'transfer', $transfer );
    }
}