jQuery(document).ready(function ($) {
    "use strict";

    // show / hide
    multiple_block_show_hide("#etn_banner", ".banner_bg_type", ".banner_bg_image", ".banner_bg_color");
    multiple_block_show_hide("#banner_bg_type", ".banner_bg_color", ".banner_bg_image");

    function multiple_block_show_hide(trigger, selector1, selector2, selector3) {
        jQuery(trigger).on('change', function () {
            switch (trigger) {
                case "#etn_banner":
                    if ($(trigger).prop('checked')) {
                        $(selector1).fadeIn('slow');
                        $(selector2).fadeIn('slow');
                    } else {
                        $(selector1).fadeOut('slow');
                        $(selector2).fadeOut('slow');
                        $(selector3).css('display', 'none');
                    }
                    break;
                case "#banner_bg_type":
                    if ($(trigger).prop('checked')) {
                        $(selector1).fadeIn('slow');
                        $(selector2).fadeOut('slow');
                    } else {
                        $(selector1).fadeOut('slow');
                        $(selector2).fadeIn('slow');
                    }
                    break;
                default:
                    break;
            }
        })
    }
    // default check
    defualt_check("#etn_banner", [".banner_bg_type"]);
    defualt_check("#banner_bg_type", [".banner_bg_color"]);

    function defualt_check(trigger, class_name) {
        if ($(trigger).prop('checked')) {
            $.each(class_name, function (item, value) {
                $(value).css('display', 'block');
            })
        }
    }

    jQuery(window).trigger('etn.colorPicker');

    $('form#etn-admin-license-form').on('submit', function (e) {
        e.preventDefault();
        var __this = $(this),
            // edd_action_type = "check_license",
            // edd_action_type = "deactivate_license",
            // edd_action_type = "get_version",
            edd_action_type = "activate_license",
            license_key = __this.find("#etn-admin-option-text-etn-license-key").val();
            var successText = "Congratulations! Your product is activated. Refreshing...";
            var failureText = "Invalid Credentials";
        $.ajax({
            url: admin_object.ajax_url,
            type: "POST",
            data: {
                action: 'activate_license',
                edd_action_type: edd_action_type,
                license_key: license_key
            },
            success: function (response) {
                if( response == "valid" ){
                    var content = "<div class='etn-license-form-result'><p class='attr-alert attr-alert-success'>" + successText + "<\/p><\/div>";
                    location.reload();
                } else {
                    var content = "<div class='etn-license-form-result'><p class='attr-alert attr-alert-warning'>" + failureText + "<\/p><\/div>";
                }
                __this.parents(".etn-license-module-parent").find(".etn-license-result-box").html(content);
            },
            error: function (data) {
                // console.log( data );
            }
        });
    });

    $(".etn-select-marketplace").on("change", function(e){
        var __this = $(this);
        var selectedVal = __this.val();
        var parentDiv   = __this.parents(".etn-license-module-parent");
        if( selectedVal == "codecanyon" ){
            // console.log( parentDiv.find("etn-marketplace-codecanyon") );
            parentDiv.find(".etn-marketplace-codecanyon").css("display", "block");
            parentDiv.find(".etn-marketplace-themewinter").css("display", "none");
        }else if( selectedVal == "themewinter" ){
            parentDiv.find(".etn-marketplace-codecanyon").css("display", "none");
            parentDiv.find(".etn-marketplace-themewinter").css("display", "block");
        } else {
            parentDiv.find(".etn-marketplace-codecanyon").css("display", "none");
            parentDiv.find(".etn-marketplace-themewinter").css("display", "none");
        }
    });
    $(".etn-select-marketplace").trigger("change");

    $('.etn-revoke-license-text').on('click', function(e){
        var __this = $(this),
            edd_action_type = "deactivate_license",
            successText = 'License Revoked! Refreshing...',
            failureText  = 'Could not revoke license. Please try again!';;
        $.ajax({
            url: admin_object.ajax_url,
            type: "POST",
            data: {
                action: 'deactivate_license',
                edd_action_type: edd_action_type
            },
            success: function (response) {
                
                // console.log(response);
                if( response == 'deactivated' ){
                    __this.parents('.etn-license-form-result').find('.attr-alert-success').empty().html( successText );
                    location.reload();
                } else {
                    __this.parents('.etn-license-form-result').find('.attr-alert-success').empty().html( failureText );
                }
            },
            error: function (data) {
                console.log( data );
            }
        });
    });

    $(".etn-btn-save-marketplace").on("click", function(){
        var __this = $(this);
        var marketPlaceValue = __this.parents(".etn-license-module-parent").find(".etn-select-marketplace").val();
        var successText = "Marketplace Saved";
        var failureText = "Couldn't save marketplace value";
        $.ajax({
            url: admin_object.ajax_url,
            type: "POST",
            data: {
                action: 'save_market_place',
                market_place: marketPlaceValue
            },
            success: function (response) {
                if( response == "valid" ){
                    var content = "<div class='etn-license-form-result'><p class='attr-alert attr-alert-success'>" + successText + "<\/p><\/div>";
                } else {
                    var content = "<div class='etn-license-form-result'><p class='attr-alert attr-alert-warning'>" + failureText + "<\/p><\/div>";
                }
                __this.parents(".etn-license-module-parent").find(".etn-marketplace-save-result").html(content);
            },
            error: function (data) {
                // console.log( data );
            }
        });
    });

    var hide_license = $(".toplevel_page_etn-events-manager ul>li:nth-child(12)").css('display', 'none');
    // hide license module
    switch (admin_object.license_module) {
        case 'undefined':
            hide_license;
            break;
        case 'no':
            hide_license;
            break;
        case 'yes':
            $(".toplevel_page_etn-events-manager ul>li:nth-child(12)").css('display', 'block');
            break;
        default:
            break;
    }

    $('.add_attendee_extra_block').on('click', function( e ){
        var input_count             = $('.etn-attendee-field').length;
        input_count++;
        var label_text              = $(this).data("label_text");
        var placeholder_text        = $(this).data("placeholder_text");
        var select_input_type_text  = $(this).data("select_input_type_text");
        var input_type_text         = $(this).data("input_type_text");
        var input_type_number       = $(this).data("input_type_number");
        var input_type_markup   = '<select name="attendee_extra_type[]" id="attendee_extra_type_' + input_count + '" class=" attendee_extra_type mr-1 etn-settings-input etn-form-control">' +
                                '<option value="" disabled selected>'+ select_input_type_text +'</option>' +
                                '<option value="text">'+ input_type_text +'</option>' + 
                                '<option value="number">'+ input_type_number +'</option>' + 
                                '</select>'
        
        $('.attendee_extra_main_block').append(
            '<div class="etn-attendee-field attendee_block mb-2">' +
            '<input type="text" name="attendee_extra_label[]" value="" class="attendee_extra_label mr-1 etn-settings-input etn-form-control" placeholder="' + label_text + '" id="attendee_extra_label_' + input_count + '" />' +
            input_type_markup +
            '<input type="text" name="attendee_extra_place_holder[]" value="" class="attendee_extra_place_holder mr-1 etn-settings-input etn-form-control" placeholder="' + placeholder_text + '" id="attendee_extra_place_holder_' + input_count + '" />' +
            '<span class="dashicons etn-btn dashicons dashicons-no-alt remove_attendee_extra_field pl-1"></span>' +
            '</div>');
    });

    // remove repeater block
    var remove_blcok = {
        parent_block:   '.attendee_extra_main_block',
        remove_button:  '.remove_attendee_extra_field',
        removing_block: '.attendee_block'
    };

    etn_remove_block( remove_blcok );

});

jQuery(window).on('etn.colorPicker', function (e, val) {
    var getColor = jQuery("#banner_bg_color").data('default-color');
    var etnColorOptions = {
        defaultColor: getColor,
        hide: true,
        change: function (event, ui) {
            var theColor = ui.color.toString();
            jQuery("#banner_bg_color").val("");
            jQuery("#banner_bg_color").val(theColor);
        },
    };
    var el = jQuery('.banner_color_picker');
    el.wpColorPicker(etnColorOptions);
});