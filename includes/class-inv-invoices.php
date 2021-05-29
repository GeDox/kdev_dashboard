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
}