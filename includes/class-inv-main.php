<?php if( ! defined( 'ABSPATH' ) ) exit;

class INV_Main {

    public function __construct() { }

    public function init() {
        INV_Invoices::init( 'invoices', 'Invoices', 'invoices' );
        INV_Orders::init( 'orders', 'Orders', 'orders' );
        INV_Orders_Status::init( 'status', 'Status', 'status' );
        INV_Coupons::init( 'coupons', 'Coupons', 'coupons' );
        INV_Restaurants::init( 'restaurants', 'Restaurants', 'restaurants' );
        INV_Templates::init();

        $unusedTermsFields = array( 'status', 'invoices', 'coupons', 'restaurants' );
        foreach( $unusedTermsFields as $term ) {
            INV_Main::hideUnusedFormFields( $term );
        }
    }

    public function hideUnusedFormFields( $taxonomyType ) {
        add_filter( INVMNG_PT_MAIN_NAME .'-'. $taxonomyType .'_edit_form', array( 'INV_Main', 'handleUnusedFormFields' ), 10, 2 );
        add_filter( INVMNG_PT_MAIN_NAME .'-'. $taxonomyType .'_add_form', array( 'INV_Main', 'handleUnusedFormFields' ), 10, 2 );
    }

    public function handleUnusedFormFields( ) {
        ?> <style>.term-description-wrap,.term-parent-wrap{display:none;}</style> <?php
    }
}