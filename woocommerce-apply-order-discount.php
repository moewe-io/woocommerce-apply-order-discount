<?php
/*
Plugin Name: WooCommerce Admin Apply Order Discount
Version: 1.0.1
Plugin URI: https://github.com/scrobbleme/woocommerce-apply-order-discount
Description: This plugin allows administrators to apply discounts on orders from the administration panel.
Author: Adrian M&ouml;rchen
Text Domain: woocommerce-apply-order-discount
Domain Path: /languages/
Author URI: http://www.scrobble.me
*/

add_action('add_meta_boxes_shop_order', 'scrobble_me_wcaod_add_apply_discount_container');
add_action('admin_enqueue_scripts', 'scrobble_me_wcaod_enque_scripts');

function scrobble_me_wcaod_enque_scripts()
{
    wp_enqueue_script('scrobble_me_wcaod-js', plugins_url('js/woocommerce-apply-order-discount.js', __FILE__), array(), '1.0.0', false);
    wp_localize_script('scrobble_me_wcaod-js', 'scrobble_me_wcaod_locales', array(
        'confirm_apply_discount' => __('Are you sure? Applying the discount may overwrite existing discounts.', 'woocommerce-apply-order-discount'),
        'apply_success_message' => __('Please press "Calc Taxes" and "Calc Totals" and save the order afterwards.', 'woocommerce-apply-order-discount')));
}

function scrobble_me_wcaod_add_apply_discount_container()
{
    add_meta_box('woocommerce-apply-coupon-later-container', __('Apply Discount', 'woocommerce-apply-order-discount'),
        'scrobble_me_wcaod_create_apply_discount_container', 'shop_order', 'side');
}

function scrobble_me_wcaod_create_apply_discount_container()
{
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

