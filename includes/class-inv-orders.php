<?php if( ! defined( 'ABSPATH' ) ) exit;

class INV_Orders extends INV_Abstract_Taxonomy {
    private static $taxID;

    public function initialize( $taxID ) {
        self::$taxID = $taxID;

        

        add_action( 'orders-invoices_edit_form_fields', array( 'INV_Orders', 'taxonomyShowAdminCustomFields' ), 10, 2 );  
        add_action( 'orders-invoices_add_form_fields', array( 'INV_Orders', 'taxonomyShowAdminCustomFields' ), 10, 2 );  

    }

    public function taxonomyShowAdminCustomFields( $tag ) {
        echo self::$taxID; ?>
        XD
        <?php
    }
}