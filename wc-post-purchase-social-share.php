<?php
/*
  Plugin Name: WooCommerce Post Purchase Social Share
  Description: WooCommerce Post Purchase Social Share. Enables sharing purchase details through twitter, facebook.
  Version: 1.0
  Author: Vijay M
 */
defined( 'ABSPATH' ) or die();

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
    //add_action( 'woocommerce_order_details_after_order_table', 'wc_post_purchase_social_share', 10, 1 );
}

function wc_pp_socialshare_enqueue_scripts(){
    wp_enqueue_script( 'jquery-ui-tabs' );
    wp_enqueue_style( 'wcppss-admin-ui-css' , plugin_dir_url(__FILE__).DIRECTORY_SEPARATOR.'assets/jquery-ui.min.css', false);
    wp_enqueue_style( 'round-out-tabs-style' , plugin_dir_url(__FILE__).DIRECTORY_SEPARATOR.'assets/round_out_tabs_style.css', false);

    wp_enqueue_script( 'wc-post-purchase-social-share-js', plugin_dir_url(__FILE__).DIRECTORY_SEPARATOR.'assets/wc-post-purchase-social-share.js', array(
        'jquery'
    ) );
    wp_enqueue_style( 'wc-post-purchase-social-share-css', plugin_dir_url(__FILE__).DIRECTORY_SEPARATOR.'assets/wc-post-purchase-social-share.css', false );
}

add_action( 'wp_enqueue_scripts', 'wc_pp_socialshare_enqueue_scripts' );

?>