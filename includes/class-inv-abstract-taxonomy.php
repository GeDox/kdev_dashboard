<?php if( ! defined( 'ABSPATH' ) ) exit;

interface INV_AbstractLoader {
    public function __construct();
    public function init();
}

interface INV_TaxonomyLoader {
    public function __construct();

    static function init( $taxonomyID, $taxonomyLabel, $taxonomySlug );
}

abstract class INV_Abstract_Taxonomy implements INV_TaxonomyLoader {
    public function __construct() {}
    public function initialize( $taxonomyID ) {}

    public static function init( $taxonomyID, $taxonomyLabel, $taxonomySlug ) {
        $instance = new static();
        $instance->initialize( $taxonomyID );

        $taxonomyOpt = array(
            'hierarchical'      => true,
            'label'             => __( $taxonomyLabel ),
            'query_var'         => INVMNG_PT_MAIN_NAME . '-' . $taxonomyID,
            'rewrite'           => array('slug' => $taxonomySlug ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'public'            => true,
            'has_archive'       => true,
            'show_in_rest'      => true
        );

        register_taxonomy( INVMNG_PT_MAIN_NAME . '-' . $taxonomyID, INVMNG_PT_MAIN_NAME, $taxonomyOpt );
    }
}