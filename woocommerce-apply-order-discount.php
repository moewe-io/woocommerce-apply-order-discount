<?php
/*
Plugin Name: WooCommerce Admin Apply Order Discount
Version: 1.1.2
Plugin URI: https://github.com/scrobbleme/woocommerce-apply-order-discount
Description: This plugin allows administrators to apply discounts on orders from the administration panel.
Author: MOEWE GbR - Adrian M&ouml;rchen, Markus Weigelt
Text Domain: woocommerce-apply-order-discount
Domain Path: /languages/
Author URI: https://www.moewe.io
*/

add_action('add_meta_boxes', 'scrobble_me_wcaod_add_apply_discount_container', 10, 2);
add_action('admin_enqueue_scripts', 'scrobble_me_wcaod_enque_scripts');

function scrobble_me_wcaod_enque_scripts() {
    wp_enqueue_script('scrobble_me_wcaod-js', plugins_url('js/woocommerce-apply-order-discount.js', __FILE__), array(), '1.1', false);
    wp_localize_script('scrobble_me_wcaod-js', 'scrobble_me_wcaod_locales', array(
        'confirm_apply_discount' => __('Are you sure? Applying the discount may overwrite existing discounts.', 'woocommerce-apply-order-discount'),
        'apply_success_message'  => __('Please press "Calc Taxes" and "Calc Totals" and save the order afterwards.', 'woocommerce-apply-order-discount')));
}

/**
 * @param $post_type string
 * @param $post WP_Post
 */
function scrobble_me_wcaod_add_apply_discount_container($post_type, $post) {
    if ($post_type != 'shop_order') {
        return;
    }
    $order = new WC_Order($post->ID);
    if (!$order->is_editable()) {
        return;
    }
    add_meta_box('woocommerce-apply-coupon-later-container', __('Apply Discount', 'woocommerce-apply-order-discount'),
        'scrobble_me_wcaod_create_apply_discount_container', 'shop_order', 'side');
}

function scrobble_me_wcaod_create_apply_discount_container() {
    ?>
    <ul id="woocommerce-apply-discount" class="woocommerce-apply-discount">
        <li>
            <input type="number" name="discount" min="0" step="1"
                   placeholder="<?php _e('Discount in %', 'woocommerce-apply-order-discount') ?>"/>
        </li>
        <li>
            <button
                    class="button apply_discount"><?php _e('Apply Discount', 'woocommerce-apply-order-discount'); ?></button>
        </li>
    </ul>
    <?php
}

/**
 * Check for plugin updates
 */
require __DIR__ . '/libs/plugin-update-checker-3.1/plugin-update-checker.php';
$updater = PucFactory::buildUpdateChecker(
    'https://raw.githubusercontent.com/moewe-io/woocommerce-apply-order-discount/stable/updater.json',
    __FILE__,
    'woocommerce-apply-order-discount',
    24
);
$updater->throttleRedundantChecks = true;

