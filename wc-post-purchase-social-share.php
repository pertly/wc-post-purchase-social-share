<?php
/*
  Plugin Name: WC E-commerce Simple Post Purchase Social Share
  Description: WC E-commerce Post Purchase Social Share. Enables sharing purchase details through twitter, facebook. It requires active Wordpress installed with Woocommerce.
  Version: 1.0
  Author: Vijay M
 */
defined( 'ABSPATH' ) or die();

$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
if ( !in_array( 'woocommerce/woocommerce.php', $active_plugins) ) {
    //Woocommerce is not actively available. So nothing to do.
    return;
}

if(!function_exists('wc_post_purchase_social_share')){
    function wc_post_purchase_social_share($orderId){
        $order = new WC_Order($orderId);
        if(!empty($order)){
            ob_start();
            require_once 'social_share_template.php';
            echo ob_get_clean();
        }
    }

    add_action( 'woocommerce_thankyou', 'wc_post_purchase_social_share', 10, 1 );
}

function wc_pp_socialshare_enqueue_scripts(){
    wp_enqueue_script( 'jquery-ui-tabs' );
    wp_enqueue_style( 'wcppss-jquery-ui-css' , plugin_dir_url(__FILE__).DIRECTORY_SEPARATOR.'assets/jquery-ui.min.css', false);

    wp_enqueue_script( 'wc-post-purchase-social-share-js', plugin_dir_url(__FILE__).DIRECTORY_SEPARATOR.'assets/wc-post-purchase-social-share.js', array(
        'jquery'
    ) );
    wp_enqueue_style( 'wc-post-purchase-social-share-css', plugin_dir_url(__FILE__).DIRECTORY_SEPARATOR.'assets/wc-post-purchase-social-share.css', false );
}

add_action( 'wp_enqueue_scripts', 'wc_pp_socialshare_enqueue_scripts' );

?>