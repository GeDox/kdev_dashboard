<?php if( ! defined( 'ABSPATH' ) ) exit;

require_once 'helpers/templates.php';

class INV_Templates {
    public function init() {
        add_filter( 'invmng_navbar', array( 'INV_Templates', 'makeNavigation' ) );
        add_filter( 'template_include', array( 'INV_Templates', 'overrideTemplate' ) );
        add_action( 'wp_enqueue_scripts', array( 'INV_Templates', 'enqueueScripts' ) );
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
        
        $templateName = is_null( $wp_query->query['name'] ) ? get_queried_object()->name : $wp_query->query['name'];

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
        wp_enqueue_script( 'kdev-dashboard-script', INVMNG_PLUGIN_DIR_URL . 'assets/kdev_dashboard.js', array(''), time(), true );
    }
}

function test() {
    echo 'XD';
}