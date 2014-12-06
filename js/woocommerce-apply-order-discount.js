jQuery(function (jQuery) {
    jQuery('#woocommerce-apply-discount').find('button.apply_discount').click(apply_discount);

    function apply_discount() {

        var answer = confirm(scrobble_me_wcaod_locales.confirm_apply_discount);
        if (!answer) {
            return false;
        }
        var discount = jQuery('#woocommerce-apply-discount').find('input[name=discount]').val();
        if (discount.length == 0) {
            discount = 0;
        }

        jQuery('#order_line_items').find('tr.item').each(function (i, element) {
            var original_total = jQuery(element).find('.line_subtotal').val();
            original_total = original_total.replace(",", ".");
            var new_total = original_total - (original_total / 100 * discount);
            jQuery(element).find('.line_total').val(new_total);
        });
        jQuery('#woocommerce-order-items').find('button.button.button-primary.save-action').click();
        alert(scrobble_me_wcaod_locales.apply_success_message);
        return false;
    }
});