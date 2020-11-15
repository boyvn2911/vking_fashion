(function ($) {
    'use strict';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function number_format(number, decimals, dec_point, thousands_sep) {
        let n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            toFixedFix = function (n, prec) {
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                let k = Math.pow(10, prec);
                return Math.round(n * k) / k;
            },
            s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');

        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }

        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    function filterSlider() {
        $('.nonlinear').each(function (index, element) {
            let $element = $(element);
            let min = $element.data('min');
            let max = $element.data('max');
            let $wrapper = $(element).closest('.nonlinear-wrapper');
            noUiSlider.create(element, {
                connect: true,
                behaviour: 'tap',
                start: [$wrapper.find('.product-filter-item-price-0').val(), $wrapper.find('.product-filter-item-price-1').val()],
                step: (max / 10),
                range: {
                    min: min,
                    '10%': max * 0.1,
                    '20%': max * 0.2,
                    '30%': max * 0.3,
                    '40%': max * 0.4,
                    '50%': max * 0.5,
                    '60%': max * 0.6,
                    '70%': max * 0.7,
                    '80%': max * 0.8,
                    '90%': max * 0.9,
                    max: max
                },
            });

            let nodes = [
                $('.ps-slider__min'),
                $('.ps-slider__max')
            ];

            element.noUiSlider.on('update', function (values, handle) {
                nodes[handle].html(number_format(Math.round(values[handle])));
            });

            element.noUiSlider.on('end', function (values, handle) {
                $wrapper.find('.product-filter-item-price-' + handle).val(Math.round(values[handle]));
                $wrapper.find('.product-filter-item').closest('form').submit();
            });
        });
    }

    $(document).ready(function () {

        let instagramUsername = $('div[data-instagram-username]').data('instagram-username');
        if (instagramUsername) {
            $.ajax({
                type: 'GET',
                cache: false,
                url: '/ajax/instagram/' + instagramUsername,
                success: res => {
                    if (!res.error) {
                        let instagramItems = '';
                        let media = res.data.data;
                        for (let i = 0; i < media.length; i++) {
                            let image =
                                '<div class="block--instagram">' +
                                '<img src="' + media[i].images.standard_resolution.url + '" alt="' + media[i].link + '">' +
                                '<a href="' + media[i].link + '" target="_blank" class="block__overlay"></a>' +
                                '<div class="block__actions">' +
                                '<a href="' + media[i].link + '" target="_blank"><i class="feather icon icon-thumbs-up"></i><span>' + number_format(media[i].likes.count) +
                                '</span></a>' +
                                '<a href="' + media[i].link + '" target="_blank"><i class="feather icon icon-message-circle"></i> <span>' + number_format(media[i].comments.count) +
                                '</span></a>';
                            if (media[i].caption) {
                                image += '<p class="block__caption">' + media[i].caption.text + '</p>';
                            }

                            image += '</div></div>';
                            instagramItems += image;
                        }
                        $('.section--instagram .half-circle-spinner').hide();
                        if (instagramItems) {
                            $('.instagram-images').html(instagramItems);
                            $('.section__follow-instagram').show();
                        }
                    }
                },
                error: res => {
                    $('.section--instagram .half-circle-spinner').hide();
                    console.log(res);
                }
            });
        }

        $('.block--method input[name=method]').on('change', function () {
            $(this)
                .closest('.block--method')
                .addClass('active');
            $(this)
                .closest('.block--method')
                .find('.block__content')
                .slideDown();
            $(this)
                .closest('.block--method')
                .siblings('.block--method')
                .removeClass('active');
            $(this)
                .closest('.block--method')
                .siblings('.block--method')
                .find('.block__content')
                .slideUp();
        });
        filterSlider();

        let handleError = function (data, form) {
            if (typeof (data.errors) !== 'undefined' && !_.isArray(data.errors)) {
                handleValidationError(data.errors, form);
            } else if (typeof (data.responseJSON) !== 'undefined') {
                if (typeof (data.responseJSON.errors) !== 'undefined' && data.status === 422) {
                    handleValidationError(data.responseJSON.errors, form);
                } else if (typeof (data.responseJSON.message) !== 'undefined') {
                    $(form).find('.error-message').html(data.responseJSON.message).show();
                } else {
                    let message = '';
                    $.each(data.responseJSON, (index, el) => {
                        $.each(el, (key, item) => {
                            message += item + '<br />';
                        });
                    });

                    $(form).find('.error-message').html(message).show();
                }
            } else {
                $(form).find('.error-message').html(data.statusText).show();
            }
        };

        let handleValidationError = function (errors, form) {
            let message = '';
            $.each(errors, (index, item) => {
                message += item + '<br />';
            });

            $(form).find('.success-message').html('').hide();
            $(form).find('.error-message').html('').hide();

            $(form).find('.error-message').html(message).show();
        };

        $(document).on('click', '.generic-form button[type=submit]', function (event) {
            event.preventDefault();
            event.stopPropagation();
            let buttonText = $(this).text();
            $(this).prop('disabled', true).addClass('btn-disabled').html('<i class="fa fa-spin fa-spinner"></i>');

            $.ajax({
                type: 'POST',
                cache: false,
                url: $(this).closest('form').prop('action'),
                data: new FormData($(this).closest('form')[0]),
                contentType: false,
                processData: false,
                success: res => {
                    $(this).closest('form').find('.success-message').html('').hide();
                    $(this).closest('form').find('.error-message').html('').hide();

                    if (!res.error) {
                        $(this).closest('form').find('input[type=email]').val('');
                        $(this).closest('form').find('input[type=text]').val('');

                        $(this).closest('form').find('.success-message').html(res.message).show();

                        setTimeout(function () {
                            $(this).closest('form').find('.success-message').html('').hide();
                        }, 5000);
                    } else {
                        $(this).closest('form').find('.error-message').html(res.message).show();

                        setTimeout(function () {
                            $(this).closest('form').find('.error-message').html('').hide();
                        }, 5000);
                    }

                    $(this).prop('disabled', false).removeClass('btn-disabled').html(buttonText);
                },
                error: res => {
                    $(this).prop('disabled', false).removeClass('btn-disabled').html(buttonText);
                    handleError(res, $(this).closest('form'));
                }
            });
        });

        $(document).ready(function () {
            window.onBeforeChangeSwatches = function () {
                $('.add-to-cart-form button[type=submit]').prop('disabled', true).addClass('btn-disabled');
            }

            window.onChangeSwatchesSuccess = function (res) {
                $('.add-to-cart-form .error-message').hide();
                $('.add-to-cart-form .success-message').hide();
                if (res.error) {
                    $('.add-to-cart-form button[type=submit]').prop('disabled', true).addClass('btn-disabled');
                    $('.number-items-available').html('<span class="text-danger">(0 products available)</span>').show();
                    $('#hidden-product-id').val('');
                } else {
                    $('.add-to-cart-form').find('.error-message').hide();
                    $('.product__price .product-sale-price-text').text(res.data.display_sale_price);
                    $('.product__price .product-price-text').text(res.data.display_price);
                    $('#hidden-product-id').val(res.data.id);
                    $('.add-to-cart-form button[type=submit]').prop('disabled', false).removeClass('btn-disabled');
                    if (!res.data.is_out_of_stock) {
                        if (res.data.with_storehouse_management && res.data.quantity) {
                            $('.number-items-available').html('<span class="text-success">(' + res.data.quantity + ' products available)</span>').show();
                        } else {
                            $('.number-items-available').html('<span class="text-success">(> 10 products available)</span>').show();
                        }
                    }
                }
            };

            $(document).on('click', '.add-to-cart-button', function (event) {
                event.preventDefault();
                let _self = $(this);

                let buttonText = _self.text();
                _self.prop('disabled', true).addClass('btn-disabled').html('<i class="fa fa-spin fa-spinner"></i>');

                $.ajax({
                    url: _self.data('url'),
                    method: 'POST',
                    data: {
                        id: _self.data('id')
                    },
                    dataType: 'json',
                    success: function (res) {
                        _self.prop('disabled', false).removeClass('btn-disabled').html(buttonText);

                        if (res.error) {
                            return false;
                        }

                        $.ajax({
                            url: '/ajax/cart',
                            method: 'GET',
                            success: function (response) {
                                if (!response.error) {
                                    $('#panel-cart .panel__content').html(response.data.html);
                                    $('.btn-shopping-cart.panel-trigger span').text(response.data.count);
                                    $('.btn-shopping-cart.panel-trigger').trigger('click');
                                }
                            }
                        });
                    },
                    error: () => {
                        _self.prop('disabled', false).removeClass('btn-disabled').html(buttonText);
                    }
                });
            });

            $(document).on('click', '.add-to-cart-form button[type=submit]', function (event) {
                event.preventDefault();
                event.stopPropagation();

                let _self = $(this);

                if (!$('#hidden-product-id').val()) {
                    _self.prop('disabled', true).addClass('btn-disabled');
                    return;
                }

                let buttonText = _self.text();
                _self.prop('disabled', true).addClass('btn-disabled').html('<i class="fa fa-spin fa-spinner"></i>');

                _self.closest('form').find('.error-message').hide();
                _self.closest('form').find('.success-message').hide();

                $.ajax({
                    type: 'POST',
                    cache: false,
                    url: _self.closest('form').prop('action'),
                    data: new FormData(_self.closest('form')[0]),
                    contentType: false,
                    processData: false,
                    success: res => {
                        _self.prop('disabled', false).removeClass('btn-disabled').html(buttonText);

                        if (res.error) {
                            _self.closest('form').find('.error-message').html(res.message).show();
                            return false;
                        }

                        _self.closest('form').find('.success-message').html(res.message).show();

                        $.ajax({
                            url: '/ajax/cart',
                            method: 'GET',
                            success: function (response) {
                                if (!response.error) {
                                    $('#panel-cart .panel__content').html(response.data.html);
                                    $('.btn-shopping-cart.panel-trigger span').text(response.data.count);
                                    $('.btn-shopping-cart.panel-trigger').trigger('click');
                                }
                            }
                        });
                    },
                    error: res => {
                        _self.prop('disabled', false).removeClass('btn-disabled').html(buttonText);
                        handleError(res, _self.closest('form'));
                    }
                });
            });

            $(document).on('click', '.add-to-wish-list-button', function (event) {
                event.preventDefault();
                let _self = $(this);

                let buttonText = $(this).text();
                _self.html('<i class="fa fa-spin fa-spinner"></i>');

                $.ajax({
                    url: _self.prop('href'),
                    method: 'POST',
                    success: res => {

                        if (res.error) {
                            _self.html(buttonText);
                            return false;
                        }

                        _self.html('<i class="fa fa-heart"></i><span>Added to wishlist</span>')
                            .addClass('remove-from-wish-list-button')
                            .removeClass('add-to-wish-list-button')
                    },
                    error: () => {
                        _self.html(buttonText);
                    }
                });
            });


            $(document).on('click', '.remove-from-wish-list-button', function (event) {
                event.preventDefault();
                let _self = $(this);

                let buttonText = $(this).text();
                _self.html('<i class="fa fa-spin fa-spinner"></i>');

                $.ajax({
                    url: _self.prop('href'),
                    method: 'DELETE',
                    success: res => {

                        if (res.error) {
                            _self.html(buttonText);
                            return false;
                        }

                        _self.html('<i class="fa fa-heart-o"></i><span>Add to wishlist</span>')
                            .removeClass('remove-from-wish-list-button')
                            .addClass('add-to-wish-list-button')
                    },
                    error: () => {
                        _self.html(buttonText);
                    }
                });
            });

            $(document).on('change', '.shop__sort select', function () {
                $(this).closest('form').submit();
            });

            $(document).on('change', '.product-filter-item', function () {
                $(this).closest('form').submit();
            });

            $(document).on('click', '.form--review-product button[type=submit]', function (event) {
                event.preventDefault();
                event.stopPropagation();
                let buttonText = $(this).text();
                $(this).prop('disabled', true).addClass('btn-disabled').html('<i class="fa fa-spin fa-spinner"></i>');

                $.ajax({
                    type: 'POST',
                    cache: false,
                    url: $(this).closest('form').prop('action'),
                    data: new FormData($(this).closest('form')[0]),
                    contentType: false,
                    processData: false,
                    success: res => {
                        $(this).closest('form').find('.success-message').html('').hide();
                        $(this).closest('form').find('.error-message').html('').hide();

                        if (!res.error) {
                            $(this).closest('form').find('select').val(0);
                            $(this).closest('form').find('textarea').val('');

                            $(this).closest('form').find('.success-message').html(res.message).show();

                            $.ajax({
                                url: '/ajax/reviews/' + $(this).closest('form').find('input[name=product_id]').val(),
                                method: 'GET',
                                success: function (response) {
                                    if (!response.error) {
                                        $('.block--product-reviews .block__content').html(response.data.html);

                                        $(document).find('select.rating').each(function () {
                                            let readOnly;
                                            readOnly = $(this).attr('data-read-only') === 'true';
                                            $(this).barrating({
                                                theme: 'fontawesome-stars',
                                                readonly: readOnly,
                                                emptyValue: '0'
                                            });
                                        });
                                    }
                                }
                            });

                            setTimeout(function () {
                                $(this).closest('form').find('.success-message').html('').hide();
                            }, 5000);
                        } else {
                            $(this).closest('form').find('.error-message').html(res.message).show();

                            setTimeout(function () {
                                $(this).closest('form').find('.error-message').html('').hide();
                            }, 5000);
                        }

                        $(this).prop('disabled', false).removeClass('btn-disabled').html(buttonText);
                    },
                    error: res => {
                        $(this).prop('disabled', false).removeClass('btn-disabled').html(buttonText);
                        handleError(res, $(this).closest('form'));
                    }
                });
            });

        });

        $('.product__qty .up').on('click', function (event) {
            event.preventDefault();
            let currentVal = parseInt($(this).next('.qty-input').val(), 10);
            $(this).next('.qty-input').val(currentVal + 1);
        });

        $('.product__qty .down').on('click', function (event) {
            event.preventDefault();
            let currentVal = parseInt($(this).prev('.qty-input').val(), 10);
            if (currentVal > 0) {
                $(this).prev('.qty-input').val(currentVal - 1);
            }
        });

        $(document).on('click', '.remove-cart-button', function (event) {
            event.preventDefault();

            $('.confirm-remove-item-cart').data('url', $(this).prop('href'));
            $('#remove-item-modal').modal('show');
        });


        $(document).on('click', '.confirm-remove-item-cart', function (event) {
            event.preventDefault();
            let _self = $(this);

            let buttonText = _self.text();
            _self.prop('disabled', true).addClass('btn-disabled').html('<i class="fa fa-spin fa-spinner"></i>');

            $.ajax({
                url: _self.data('url'),
                method: 'GET',
                success: function (res) {
                    _self.prop('disabled', false).removeClass('btn-disabled').html(buttonText);

                    if (res.error) {
                        return false;
                    }

                    _self.closest('.modal').modal('hide');

                    if ($('.section--shopping-cart').length) {
                        $('.section--shopping-cart').load(window.location.href + ' .section--shopping-cart > *');
                    }

                    $.ajax({
                        url: '/ajax/cart',
                        method: 'GET',
                        success: function (response) {
                            if (!response.error) {
                                $('#panel-cart .panel__content').html(response.data.html);
                                $('.btn-shopping-cart.panel-trigger span').text(response.data.count);
                            }
                        }
                    });
                },
                error: () => {
                    _self.prop('disabled', false).removeClass('btn-disabled').html(buttonText);
                }
            });
        });

        $(document).on('click', '.js-add-favorite-button', function (event) {
            event.preventDefault();
            let _self = $(this);

            let buttonHtml = $(this).html();
            _self.html('<i class="fa fa-spin fa-spinner"></i>');

            $.ajax({
                url: _self.prop('href'),
                method: 'POST',
                success: res => {

                    if (res.error) {
                        _self.html(buttonHtml);
                        return false;
                    }

                    _self.html('<i class="fa fa-heart"></i>').removeClass('js-add-favorite-button').addClass('js-remove-favorite-button active');
                },
                error: () => {
                    _self.html(buttonHtml);
                }
            });
        });


        $(document).on('click', '.js-remove-favorite-button', function (event) {
            event.preventDefault();
            let _self = $(this);

            let buttonHtml = $(this).html();
            _self.html('<i class="fa fa-spin fa-spinner"></i>');

            $.ajax({
                url: _self.prop('href'),
                method: 'DELETE',
                success: res => {

                    if (res.error) {
                        _self.html(buttonHtml);
                        return false;
                    }

                    _self.html('<i class="fa fa-heart-o"></i>').removeClass('js-remove-favorite-button active').addClass('js-add-favorite-button');
                },
                error: () => {
                    _self.html(buttonHtml);
                }
            });
        });

    });

})(jQuery);

(function ($) {
    'use strict';

    function backgroundImage() {
        let background = $('[data-background]');
        background.each(function () {
            if ($(this).attr('data-background')) {
                let image_path = $(this).attr('data-background');
                $(this).css({
                    background: 'url(' + image_path + ')'
                });
            }
        });
    }

    function siteToggleAction() {
        let siteOverlay = $('.site-mask');

        $('body').on('click', function (e) {
            if ($(e.target).siblings('.panel--sidebar').hasClass('active')) {
                $('.panel--sidebar').removeClass('active');
                siteOverlay.removeClass('active');
                $('body').css('overflow', 'auto');
            }
        });
    }

    function subMenuToggle() {
        $('.menu--mobile .menu-item-has-children > .sub-toggle').on(
            'click',
            function (e) {
                e.preventDefault();
                let current = $(this).parent('.menu-item-has-children');
                $(this).toggleClass('active');
                current
                    .siblings()
                    .find('.sub-toggle')
                    .removeClass('active');
                current.children('.sub-menu').slideToggle(350);
                current
                    .siblings()
                    .find('.sub-menu')
                    .slideUp(350);
                if (current.hasClass('has-mega-menu')) {
                    current.children('.mega-menu').slideToggle(350);
                    current
                        .siblings('.has-mega-menu')
                        .find('.mega-menu')
                        .slideUp(350);
                }
            }
        );

        $('.menu--mobile .has-mega-menu .mega-menu__column .sub-toggle').on(
            'click',
            function (e) {
                e.preventDefault();
                let current = $(this).closest('.mega-menu__column');
                $(this).toggleClass('active');
                current
                    .siblings()
                    .find('.sub-toggle')
                    .removeClass('active');
                current.children('.sub-menu--mega').slideToggle();
                current
                    .siblings()
                    .find('.sub-menu--mega')
                    .slideUp();
            }
        );
    }

    function slickConfig() {
        let product = $('.product--detail');
        if (product.length > 0) {
            let primary = product.find('.product__gallery'),
                second = product.find('.product__thumbs'),
                vertical = product.find('.product__thumbnail').data('vertical');
            primary.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.product__thumbs',
                fade: true,
                dots: false,
                infinite: false,
                arrows: primary.data('arrow'),
                prevArrow: '<a href="#"><i class="fa fa-angle-left"></i></a>',
                nextArrow: '<a href="#"><i class="fa fa-angle-right"></i></a>'
            });

            second.slick({
                slidesToShow: second.data('item'),
                slidesToScroll: 1,
                infinite: false,
                arrows: second.data('arrow'),
                focusOnSelect: true,
                prevArrow: '<a href="#"><i class="fa fa-angle-up"></i></a>',
                nextArrow: '<a href="#"><i class="fa fa-angle-down"></i></a>',
                asNavFor: '.product__gallery',
                vertical: vertical,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            arrows: second.data('arrow'),
                            slidesToShow: 4,
                            vertical: false,
                            prevArrow: '<a href="#"><i class="fa fa-angle-left"></i></a>',
                            nextArrow: '<a href="#"><i class="fa fa-angle-right"></i></a>'
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            arrows: second.data('arrow'),
                            slidesToShow: 4,
                            vertical: false,
                            prevArrow: '<a href="#"><i class="fa fa-angle-left"></i></a>',
                            nextArrow: '<a href="#"><i class="fa fa-angle-right"></i></a>'
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 3,
                            vertical: false,
                            prevArrow: '<a href="#"><i class="fa fa-angle-left"></i></a>',
                            nextArrow: '<a href="#"><i class="fa fa-angle-right"></i></a>'
                        }
                    }
                ]
            });
        }
    }

    function tabs() {
        $('.tab-list  li > a ').on('click', function (e) {
            e.preventDefault();
            let target = $(this).attr('href');
            $(this)
                .closest('li')
                .siblings('li')
                .removeClass('active');
            $(this)
                .closest('li')
                .addClass('active');
            $(target).addClass('active');
            $(target)
                .siblings('.tab')
                .removeClass('active');
        });

        $('.tab-list.owl-slider .owl-item a').on('click', function (e) {
            e.preventDefault();
            let target = $(this).attr('href');
            $(this)
                .closest('.owl-item')
                .siblings('.owl-item')
                .removeClass('active');
            $(this)
                .closest('.owl-item')
                .addClass('active');
            $(target).addClass('active');
            $(target)
                .siblings('.tab')
                .removeClass('active');
        });
    }

    function rating() {
        $(document).find('select.rating').each(function () {
            let readOnly;
            readOnly = $(this).attr('data-read-only') === 'true';
            $(this).barrating({
                theme: 'fontawesome-stars',
                readonly: readOnly,
                emptyValue: '0'
            });
        });
    }

    function handleSearch() {
        let searchBox = $('.panel--search');
        $('.search-btn').on('click', function (e) {
            e.preventDefault();
            searchBox.addClass('active');
            $('.site-mask').addClass('active');
        });
        $('.panel--search .panel__close').on('click', function (e) {
            e.preventDefault();
            searchBox.removeClass('active');
            $('.site-mask').removeClass('active');
        });
    }

    function togglePanel() {
        $('.panel-trigger').on('click', function (e) {
            e.preventDefault();
            let target = $(this).attr('href');
            $(target).addClass('active');
            $(target)
                .siblings('.panel--sidebar')
                .removeClass('active');
            $('.site-mask').addClass('active');
            $('body').css('overflow', 'hidden');
        });

        $('.panel--sidebar .panel__close').on('click', function (e) {
            e.preventDefault();
            $(this)
                .closest('.panel--sidebar')
                .removeClass('active');
            $('.site-mask').removeClass('active');
            $('body').css('overflow', 'auto');
        });
    }

    function initAnimation(items) {
        items.each(function () {
            let element = $(this);
            let delay = element.attr('data-animation-delay');

            element.css({
                '-webkit-animation-delay': delay,
                '-moz-animation-delay': delay,
                'animation-delay': delay,
                opacity: 0
            });
        });
    }

    $(function () {
        backgroundImage();
        siteToggleAction();
        subMenuToggle();
        tabs();
        slickConfig();
        rating();
        handleSearch();
        togglePanel();

        initAnimation($('.animation'));
        initAnimation($('.staggered-animation'), $('.staggered-animation-wrap'));

        $(document).on('translated.owl.carousel', '.owl-slider', function () {
            initAnimation($('.animation'));
            initAnimation($('.staggered-animation'), $('.staggered-animation-wrap'));
        });
    });

    $(window).on('load', function () {
        $('body').addClass('loaded');
    });
})(jQuery);
