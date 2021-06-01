<?php if( ! defined( 'ABSPATH' ) ) exit;

require_once 'helpers/templates.php';

class INV_Templates {
    public function init() {
        add_filter( 'invmng_navbar', array( 'INV_Templates', 'makeNavigation' ) );
        add_filter( 'template_include', array( 'INV_Templates', 'overrideTemplate' ) );
        add_action( 'wp_enqueue_scripts', array( 'INV_Templates', 'enqueueScripts' ) );
        add_filter( 'style_loader_src', array( 'INV_Templates', 'styleLoaderSrc' ) );
    }

    public function makeNavigation() {
        //isActiveSpecificArchiveOrPostType
        $navigationTabs = array(
            [ 'id' => 'dashboard', 'name' => 'Dashboard', 'active' => false ],
            [ 'id' => 'coupons', 'name' => 'Coupons', 'active' => false ],
            [ 'id' => 'invoices', 'name' => 'Invoices', 'active' => false ],
            [ 'id' => 'restaurants', 'name' => 'Restaurants', 'active' => false ],
            [ 'id' => 'users', 'name' => 'Users', 'active' => false ],
            [ 'id' => 'orders', 'name' => 'Orders', 'active' => false ],
        );
        return $navigationTabs;
    }

    public function overrideTemplate( $template ) {
        global $wp_query;
        /*echo '<pre>';
        var_dump( $wp_query, get_queried_object() );
        echo '</pre>';

        //var_dump( get_queried_object()->name, isInSpecificType( get_queried_object()->name, $postTypes ), isInSpecificType( get_post_type( get_the_ID() ), $postTypes ) );
        */
        $archiveTypes = array( 'coupons', 'orders', 'invoices', 'restaurants', 'status' );
        $postTypes = array( 'orders-invoices' );
        
        $templateName = getTemplateName();

        if ( $templateName == 'invmng' ) 
            $templateName = 'invoices';

        //var_dump( get_queried_object() );
        if( isInSpecificType( $templateName, $archiveTypes ) ) {
            return INVMNG_PLUGIN_DIR_PATH . '/templates/archive-' . $templateName . '.php';
        } else {
            $templateName = $wp_query->query_vars['taxonomy'];

            if( isInSpecificType( $wp_query->query_vars['taxonomy'], $postTypes ) ) {
                return INVMNG_PLUGIN_DIR_PATH . '/templates/page-' . $templateName . '.php';
            }
        }
        
        return $template;
    }

    public function enqueueScripts() {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', "https://code.jquery.com/jquery-3.1.1.min.js", array(), '3.1.1' );

        wp_enqueue_script( 'kdev-dashboard-script', INVMNG_PLUGIN_DIR_URL . 'assets/kdev_dashboard.js', array( 'jquery' ) );
        wp_localize_script( 'kdev-dashboard-script', 'ajaxVars', [
            'root'  => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
        ] );
    }

    public function styleLoaderSrc($href) {
        if( is_null( getTemplateName() ) ) return $href;

        if( strpos($href, "/themes/") === false ) {
            return $href;
        }

        return false;
    }
}

function test() {
    echo 'XD';
}