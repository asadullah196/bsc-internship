jQuery(document).ready(function ($) {
    'use strict';

    var container = jQuery('.etn-countdown-wrap');
    if (container.length > 0) {
        $.each(container, function (key, item) {

            // countdown
            let etn_event_start_date = '';
            etn_event_start_date = jQuery(item).data('start-date');

            var countDownDate = new Date(etn_event_start_date).getTime();

            let etn_timer_x = setInterval(function () {
                var now = new Date().getTime();
                var distance = countDownDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                jQuery(item).find('.day-count').html(days);
                jQuery(item).find('.hr-count').html(hours);
                jQuery(item).find('.min-count').html(minutes);
                jQuery(item).find('.sec-count').html(seconds);
                if (distance < 0) {
                    clearInterval(etn_timer_x);
                    jQuery(this).find('.etn-countdown-wrap').html('EXPIRED');
                }
            }, 1000);
        });

    }


    //cart attendee 

    $(".etn-extra-attendee-form").on('blur change click', function () {
        $('.wc-proceed-to-checkout').css({
            'cursor': "default",
            'pointer-events': 'none'
        });
        $.ajax({
            url: etn_localize_event.rest_root + 'etn-events/v1/cart/attendee',
            type: 'GET',
            data: $('.woocommerce-cart-form').serialize(),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', etn_localize_event.nonce);
            },
            success: function (data) {
                $('.wc-proceed-to-checkout').css({
                    'cursor': "default",
                    'pointer-events': 'auto'
                });
            },

        });
    });

    // calculate total price of an event ticket
    $('.etn-event-form-qty').on('change keyup', function () {

        var __this = $(this);
        var form_price_amount_holder = __this.parents(".etn-event-form-parent").find('.etn_form_price');
        var add_to_cart_button = __this.parents(".etn-event-form-parent").find('.etn-add-to-cart-block');
        var product_left_qty = parseInt(__this.data("left_ticket"));
        var product_qty = parseInt(__this.val());
        var invalid_qty_message = __this.data("invalid_qty_text");
        
        if (product_qty <= product_left_qty && product_qty > 0) {
            var total_price = 0.00;
            var total_product_price = 0.00;
            var product_qty = parseInt(__this.parents(".etn-event-form-parent").find('.etn_product_qty').val());
            var product_price = parseFloat(__this.parents(".etn-event-form-parent").find('.etn_product_price').val());
            
            total_product_price = product_price;
            total_price = total_product_price * product_qty;
            form_price_amount_holder.html(total_price);
            if (add_to_cart_button.is(":hidden")) {
                add_to_cart_button.show();
            }
        } else {
            form_price_amount_holder.html(invalid_qty_message);
            add_to_cart_button.hide();
        }
    });
    $('.etn-event-form-qty').trigger('change');

    $('.schedule-tab').on('click', openScheduleTab);

    function openScheduleTab() {
        var title = $(this).data('title');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(title).style.display = "block";
    }

    $('.schedule-tab-shortcode').on('click', openScheduleTabShortCode);

    function openScheduleTabShortCode() {
        var title = $(this).data('title');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent-shortcode");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks-shortcode");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        let single_title = "shortcode_" + title;
        document.getElementById(single_title).style.display = "block";
    }

    $('.attr-nav-pills>li>a').first().trigger('click');


    //   custom tabs
    // $(document).on('click', '.etn-tab-a', function (event) {
    //     event.preventDefault();

    //     $(this).parents(".schedule-tab-wrapper").find(".etn-tab").removeClass('tab-active');
    //     $(this).parents(".schedule-tab-wrapper").find(".etn-tab[data-id='" + $(this).attr('data-id') + "']").addClass("tab-active");
    //     $(this).parents(".schedule-tab-wrapper").find(".etn-tab-a").removeClass('etn-active');
    //     $(this).parent().find(".etn-tab-a").addClass('etn-active');
    // });

       //   custom tabs
    $(document).on('click', '.etn-tab-a', function (event) {
        event.preventDefault();

        $(this).parents(".etn-tab-wrapper").find(".etn-tab").removeClass('tab-active');
        $(this).parents(".etn-tab-wrapper").find(".etn-tab[data-id='" + $(this).attr('data-id') + "']").addClass("tab-active");
        $(this).parents(".etn-tab-wrapper").find(".etn-tab-a").removeClass('etn-active');
        $(this).parent().find(".etn-tab-a").addClass('etn-active');
    });

    //======================== Attendee form validation start ================================= //

    /**
     * Get form value and send for validation
     */
    $(".attendee_sumbit").prop('disabled', true).addClass('attendee_sumbit_disable');

    function button_disable(button_class) {
        var length = $(".attendee_error").length;
        var attendee_sumbit = $( button_class );

        if (length == 0) {
            attendee_sumbit.prop('disabled', false).removeClass('attendee_sumbit_disable');
        } else {
            attendee_sumbit.prop('disabled', true).addClass('attendee_sumbit_disable');
        }
    }

    var attendee_update_field = [
        "input[name='name']", 
        "input[name='phone']", 
        "input[name='email']"
    ]; 
    validation_checking( attendee_update_field , ".attendee_update_sumbit");
    
    var attendee_field = [
        "input[name='attendee_name[]']", 
        "input[name='attendee_phone[]']", 
        "input[name='attendee_email[]']",
    ];
    validation_checking( attendee_field , ".attendee_sumbit");

    var attendee_extra_field_classes    = [
        '.etn-attendee-extra-fields',
    ]
    validation_checking( attendee_extra_field_classes , ".attendee_sumbit");
    validation_checking( attendee_extra_field_classes , ".attendee_update_sumbit");
    
    function validation_checking(input_arr , button_class ) {
        $.each(input_arr, function (index, value) {
            if ( $(this).val() !== undefined && $(this).val().length == 0) {
                $(this).addClass("attendee_error");
            }
            $(".attende_form").on("keyup change", value, function () {
                var response = get_error_message($(this).attr('type'), $(this).val());
                var id = $(this).attr("id");
                $("." + id).html("");
                if (typeof response !== "undefined" && response.message !== 'success') {
                    $("." + id).html(response.message);
                    $(this).addClass("attendee_error");
                } else {
                    $(this).removeClass("attendee_error");
                }
                button_disable(button_class);

            });
        });
    }


    /**
     * Check type and input validation
     * @param {*} type 
     * @param {*} value 
     */
    function get_error_message(type, value) {
        var response = {
            error_type: "no_error",
            message: "success"
        };
        if (value.length == 0) {
            $(this).addClass("attendee_error");
        } else {
            $(this).removeClass("attendee_error");
        }

        switch (type) {
            case 'email':
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (value.length !== 0) {
                    if (re.test(String(value).toLowerCase()) == false) {
                        response.error_type = "not-valid";
                        response.message = "Email is not valid";
                    }
                } else {
                    response.error_type = "empty";
                    response.message = "Please fill the field";
                }
                break;
            case 'tel':

                if (value.length === 0) {
                    response.error_type = "empty";
                    response.message = "Please fill the field";
                } else if (value.length > 15) {
                    response.error_type = "not-valid";
                    response.message = "Invalid phone number";
                } else if (!value.match(/^\d+/) == true) {
                    response.error_type = "not-valid";
                    response.message = "Only number allowed";
                }
                break;
            case 'text':
                if (value.length === 0) {
                    response.error_type = "empty";
                    response.message = "Please fill the field";
                }
                break;
            case 'number':
                if ( value.length === 0 ) {
                    response.error_type = "empty";
                    response.message = "Please input a number";
                }
                break;
            default:
                break;
        }

        return response;
    }

    //====================== Attendee form validation end ================================= //

});