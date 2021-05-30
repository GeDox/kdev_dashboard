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

        add_action( INVMNG_PT_MAIN_NAME . '-' . $taxonomyID . '_edit_form_fields', 
            array( $instance, 'taxonomyShowAdminCustomFields' ), 10, 2 );  
        add_action( INVMNG_PT_MAIN_NAME . '-' . $taxonomyID . '_add_form_fields', 
            array( $instance, 'taxonomyShowAdminCustomFields' ), 10, 2 );  

        add_action( 'edited_' . INVMNG_PT_MAIN_NAME . '-' . $taxonomyID, 
            array( $instance, 'taxonomySaveCustomFields' ), 10, 2 );

        register_rest_field( INVMNG_PT_MAIN_NAME . '-' . $taxonomyID, 'meta-fields', 
            array( 
                'get_callback' => array( $instance, 'getPostMetaForAPI' ),
                'schema' => null
            )
        );
    }

    public function taxonomySaveCustomFields( $t_id ) {
        if ( isset( $_POST['term_meta'] ) ) {
            $term_meta = get_post_meta( $t_id );
            $cat_keys = array_keys( $_POST[ 'term_meta' ] );  

            foreach ( $cat_keys as $key ) {  
                if ( isset( $_POST[ 'term_meta' ] [$key ] ) ){  
                    update_post_meta( $t_id, $key, $_POST[ 'term_meta' ][ $key ] );
                }  
            }
        }  
    }

    public function getPostMetaForAPI( $object ) {
        $post_id = $object[ 'id' ];
        $post_data = get_post_meta( $post_id );

        unset( $post_data[ '_edit_last' ] );
        unset( $post_data[ '_edit_lock' ] );
        unset( $post_data[ '_wp_old_slug' ] );
        return $post_data;
    }
}