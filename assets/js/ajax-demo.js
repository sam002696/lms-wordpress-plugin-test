jQuery(document).ready(function ($) {

    $('#get-coupon-btn').on('click', function () {

        let couponId = $('#coupon-select').val();

        $('#coupon-result').text('Loading...');

        $.ajax({
            url: ajax_obj.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_coupon_details',
                coupon_id: couponId,
                nonce: ajax_obj.nonce
            },
            success: function (response) {
                if (response.success) {
                    $('#coupon-result').text('Discount: ' + response.data.discount);
                } else {
                    $('#coupon-result').text('Error: ' + response.data);
                }
            },
            error: function () {
                $('#coupon-result').text('AJAX request failed');
            }
        });

    });

});
