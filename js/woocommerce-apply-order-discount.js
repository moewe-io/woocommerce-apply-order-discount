jQuery(function ($) {
    $('#woocommerce-apply-discount').find('button.apply_discount').click(function () {
        var item_wrapper = $('.woocommerce_order_items_wrapper');
        item_wrapper.block({ message: null, overlayCSS: { background: '#fff url(' + woocommerce_writepanel_params.plugin_url + '/assets/images/ajax-loader.gif) no-repeat center', opacity: 0.6 } });
        var answer = confirm(scrobble_me_wcaod_locales.confirm_apply_discount);
        if (answer) {
            var discount = $('#woocommerce-apply-discount').find('input[name=discount]').val();
            $('#order_items_list').find('tr.item').each(function (i, element) {
                var original_total = $(element).data('unit_subtotal');
                var quantity = $(element).find('input.quantity').val();
                var new_total = (original_total * quantity) - (original_total * quantity / 100 * discount);
                $(element).find('input.line_total').val(accounting.toFixed(new_total, 2)).change();
            });
        }
        item_wrapper.unblock();
        alert(scrobble_me_wcaod_locales.apply_success_message);
    }).hover(function () {
            $('.woocommerce_order_items input.line_total').css('background-color', '#e3d2dd');
        }, function () {
            $('.woocommerce_order_items input.line_total').css('background-color', '');
        })
});