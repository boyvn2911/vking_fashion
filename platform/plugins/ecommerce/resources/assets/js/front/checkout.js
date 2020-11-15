import {CheckoutAddress} from './partials/address';
import {DiscountManagement} from './partials/discount';

class MainCheckout {
    constructor() {
        new CheckoutAddress().init();
        new DiscountManagement().init();
    }

    static showNotice(messageType, message) {
        toastr.clear();

        toastr.options = {
            closeButton: true,
            positionClass: 'toast-bottom-right',
            onclick: null,
            showDuration: 1000,
            hideDuration: 1000,
            timeOut: 10000,
            extendedTimeOut: 1000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };

        let messageHeader = '';

        switch (messageType) {
            case 'error':
                messageHeader = 'Error';
                break;
            case 'success':
                messageHeader = 'Success';
                break;
        }
        toastr[messageType](message, messageHeader);
    }

    init() {
        $(document).on('change', 'input[name=shipping_method]', event => {
            // Fixed: set shipping_option value based on shipping_method change:
            $('input[name=shipping_option]').val($(event.currentTarget).data('option'));

            let show_mobile_info = '';
            if ($('#cart-item').hasClass('show')) {
                show_mobile_info = 'show';
            }

            let target = '#main-checkout-product-info';
            if ($('#main-checkout-product-info').is(':hidden')) {
                target = '#main-checkout-product-info-mobile';

                if (show_mobile_info === 'show') {
                    $('.payment-info-loading').show();
                }
            } else {
                $('.payment-info-loading').show();
            }

            $('.mobile-total').text('...');

            $(target).load(window.location.href
                + '?shipping_method=' + $(event.currentTarget).val()
                + '&shipping_option=' + $(event.currentTarget).data('option')
                + '&show_mobile_info=' + show_mobile_info
                + ' ' + target + ' > *', () => {
                $('.payment-info-loading').hide();
            });
        });
    }
}

$(document).ready(() => {
    new MainCheckout().init();

    window.MainCheckout = MainCheckout;
});
