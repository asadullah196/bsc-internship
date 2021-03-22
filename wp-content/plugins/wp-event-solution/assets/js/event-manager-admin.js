jQuery(document).ready(function ($) {
    'use strict';

    // load color picker   
    $("#etn_primary_color").wpColorPicker();
    $("#etn_secondary_color").wpColorPicker();

    $('body').on('click', '.etn_event_upload_image_button', function (e) {

        e.preventDefault();
        var multiple = false;

        if ($(this).data('multiple')) {
            multiple = Boolean($(this).data('multiple'));
        }

        var button = $(this),
            custom_uploader = wp.media({
                title: 'Insert image',
                library: {

                    type: 'image'
                },
                button: {
                    text: 'Use this image' // button label text
                },
                multiple: multiple
            }).on('select', function () {
                var attachment = custom_uploader.state().get('selection').first().toJSON();

                $(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" alt="" />').next().val(attachment.id).next().show();


            })
            .open();
    });

    /*
     * Remove image event
     */
    $('body').on('click', '.essential_event_remove_image_button', function () {
        $(this).hide().prev().val('').prev().addClass('button').html('Upload image');
        return false;
    });

    // select2 for meta box
    $('.etn_es_event_select2').select2();

    // social icon
    var etn_selected_social_event_icon = null;
    $(' .social-repeater').on('click', '.etn-social-icon', function () {

        etn_selected_social_event_icon = $(this);

    });

    $('.etn-social-icon-list i').on("click", function () {
        var icon_class_selected = $(this).data('class');
        etn_selected_social_event_icon.val(icon_class_selected);
        $('.etn-search-event-mng-social').val(icon_class_selected);
        etn_selected_social_event_icon.siblings('i').removeClass().addClass(icon_class_selected);
    });


    $('.etn-search-event-mng-social').on('input', function () {
        var search_value = $(this).val().toUpperCase();

        let all_social_list = $(".etn-social-icon-list i");

        $.each(all_social_list, function (key, item) {

            var icon_label = $(item).data('value');

            if (icon_label.toUpperCase().indexOf(search_value) > -1) {
                $(item).show();
            } else {
                $(item).hide();
            }

        });
    });

    var etn_social_rep = $('.social-repeater').length;

    if (etn_social_rep) {
        $('.social-repeater').repeater({

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {

                $(this).slideUp(deleteElement);

            },

        });
    }

    // works only this page post_type=etn-schedule
    $('.etn_es_event_repeater_select2').select2();


    // event manager repeater
    var etn_repeater_markup_parent = $(".etn-event-manager-repeater-fld");
    var schedule_repeater = $(".schedule_repeater");
    var schedule_value = $("#etn_schedule_sorting");
    var speaker_sort = {};

    if ((schedule_value.val() !== undefined) && (schedule_value.val() !== '')) {
        speaker_sort = JSON.parse(schedule_value.val());
    }

    if (etn_repeater_markup_parent.length) {
        etn_repeater_markup_parent.repeater({
            show: function () {
                var repeat_length = $(this).parent().find('.etn-repeater-item').length;
                $(this).slideDown();
                $(this).find('.event-title').html($(this).parents('.etn-repeater-item').find(".etn-title").text() + " " + repeat_length);
                $(this).find('.select2').remove();
                $(this).find('.etn_es_event_repeater_select2').select2();

                // make schedule repeater sortable 
                var repeater_items_length = schedule_repeater.find('.sort_repeat').length;
                if (repeater_items_length > 0) {
                    schedule_repeater.find('.sort_repeat:last-child').attr("data-repeater-item", repeater_items_length - 1);
                    etn_drag_and_drop_sorting();
                }
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
                speaker_sort = {};
                $(this).closest(".sort_repeat").remove();
                $(".sort_repeat").each(function (index, item) {
                    var $this = $(this);
                    if (typeof $this.data('repeater-item') !== undefined) {
                        var check_index = index == $(".sort_repeat").length ? index - 1 : index
                        $this.attr("data-repeater-item", check_index);
                        speaker_sort[index] = check_index;
                    }
                })
                schedule_value.val("").val(JSON.stringify(speaker_sort));
            },
        });
    }

    // Repetaer data re-ordering 
    if (schedule_repeater.length) {

        schedule_repeater.sortable({
            opacity: 0.7,
            revert: true,
            cursor: 'move',
            stop: function (e, ui) {
                etn_drag_and_drop_sorting();
            },
        });
    }

    function etn_drag_and_drop_sorting() {
        $(".sort_repeat").each(function (index, item) {
            var $this = $(this);
            if (typeof $this.data('repeater-item') !== "undefined") {
                var check_index = index == $(".sort_repeat").length ? index - 1 : index
                var repeat_value = $this.data('repeater-item') == $(".sort_repeat").length ? $this.data('repeater-item') - 1 : $this.data('repeater-item')
                speaker_sort[check_index] = repeat_value;
            }
        })
        schedule_value.val(JSON.stringify(speaker_sort));
    }

    // slide repeater
    $(document).on('click', '.etn-event-shedule-collapsible', function () {
        $(this).next('.etn-event-repeater-collapsible-content').slideToggle()
            .parents('.etn-repeater-item').siblings().find('.etn-event-repeater-collapsible-content').slideUp();

    });
    $('.etn-event-shedule-collapsible').first().trigger('click');
    // ./End slide repeater
    // ./end works only this page post_type=etn-schedule

    if ($("#etn_start_date").length) {

        $('#etn_start_date').datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function () {
                $(this).val();
            }
        });
    }



    if ($("#etn_end_date").length) {
        $('#etn_end_date').datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function () {
                $(this).val();
            }
        });
    }
    if ($("#etn_registration_deadline").length) {

        $('#etn_registration_deadline').datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function () {
                $(this).val();
            }
        });
    }

    // event schedule date repeater 

    $(document).on('focus', ".etn_schedule_event_date", function () {
        $(this).datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function () {
                $(this).val();
            }
        });
    });
    var eventMnger = '#etn-general_options';
    if (window.location.hash) {
        eventMnger = window.location.hash;
    }

    $('.etn-settings-tab .nav-tab[href="' + eventMnger + '"]').trigger('click');

    // Previous tab active on reload or save
    if ($('.etn-settings-dashboard').length > 0) {
        let locationHash = window.location.hash;
        if(locationHash && $( `.etn-tab li a[href='${locationHash}']`)[0]){
            $(`.etn-tab li:first-child`).removeClass("attr-active");
            $(`.attr-tab-pane:first-child`).removeClass("attr-active");
            $(`.etn-tab li a[href='${locationHash}']`).parent().addClass("attr-active");
            $(`.attr-tab-pane[id='${locationHash.substr(1)}']`).addClass("attr-active");
        }else{
            $('.etn-tab li:first-child').addClass("attr-active");
            $('.attr-tab-pane:first-of-type').addClass("attr-active");
        }

        // Hide submit button for Hooks tab
        var data_id = $(`.attr-tab-pane[id='${locationHash.substr(1)}']`).attr('data-id');
        var settings_submit = $(".etn_save_settings");
        if ( data_id =="tab5" ) {
            settings_submit.addClass("attr-hide");
        }
        else{
            settings_submit.removeClass("attr-hide");
        }
    }

    //admin settings tab
    $(document).on('click', ".etn-tab li a", function (e) {
        e.preventDefault();
        $(".etn-tab li").removeClass("attr-active");
        $(this).parent().addClass("attr-active");
        $(".attr-tab-content .attr-tab-pane").removeClass("attr-active");
        $(".attr-tab-pane[data-id='" + $(this).attr('data-id') + "']").addClass("attr-active");

        //set hash link
        window.location.hash = $(this).attr("href");

        // Hide submit button for Hooks tab
        var data_id = $(this).attr('data-id');
        var settings_submit = $(".etn_save_settings");
        if ( data_id =="tab5" ) {
            settings_submit.addClass("attr-hide ");
        }
        else{
            settings_submit.removeClass("attr-hide ");
        }
    });

    // schedule tab
    $('.postbox .hndle').css('cursor', 'pointer');

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

    // dashboard menu active class pass
    var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
    $("#toplevel_page_etn-events-manager .wp-submenu-wrap li a").each(function () {
        if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
            $(this).parent().addClass("current");
    });

    // ZOOM MODULE
    // zoom moudle on / off
    block_show_hide('#zoom_api', ".zoom_block");

    // add date time picker
    var start_time = $('#zoom_start_time');
    start_time.datetimepicker({
        format: "Y-m-d H:i:s",
        step: 30
    });
    start_time.attr('required', true);


    $('#zoom_meeting_password').attr('maxlength', '10');

    $(document).on('click', '.eye_toggle_click', function () {
        var get_id = $(this).parents('.etn-secret-key').children().attr('id');
        $(this).toggleClass('fa fa-eye fa fa-eye-slash');
        show_password(get_id);
    });
    // show hide password
    function show_password(id) {
        var pass = document.getElementById(id);
        if (pass.type === "password") {
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    }
    // check api connection
    $(document).on('click', '.check_api_connection', function (e) {
        e.preventDefault();
        var data = {
            action: 'zoom_connection',
            zoom_nonce: form_data.zoom_connection_check_nonce,
        }
        $.ajax({
            url: form_data.ajax_url,
            method: 'POST',
            data: data,
            success: function (data) {
                if (typeof data.data.message !== "undefined" && data.data.message.length > 0) {
                    alert(data.data.message[0]);
                }
            }
        });
    });

    var hide_zomm = $(".toplevel_page_etn-events-manager ul>li:nth-child(9)").css('display', 'none');
    var hide_attendee = $(".toplevel_page_etn-events-manager ul>li:nth-child(3)").css('display', 'none');

    // hide zoom module
    switch (form_data.zoom_module) {
        case 'undefined':
            hide_zomm;
            break;
        case 'no':
            hide_zomm;
            break;
        case 'yes':
            $(".toplevel_page_etn-events-manager ul>li:nth-child(9)").css('display', 'block');
            break;
        default:
            break;
    }

    // hide attendee module
    switch (form_data.attendee_module) {
        case 'undefined':
            hide_attendee;
            break;
        case 'no':
            hide_attendee;
            break;
        case 'yes':
            $(".toplevel_page_etn-events-manager ul>li:nth-child(3)").css('display', 'block');
            break;
        default:
            break;
    }

    $(".etn-settings-select").select2();


    /*-----------------Conditional Block --------------------*/

    $(".etn-conditional-control").on("change", function () {
        var _this = $(this);
        var conditional_control_content = _this.parents(".etn-label-item").next(".etn-label-item");
        if (_this.prop('checked')) {
            conditional_control_content.slideDown();
        } else {
            conditional_control_content.slideUp();
        }
    });
    $(".etn-conditional-control").trigger("change");

    /*------------------Conditional Block------------------*/


    $("#etn_ticket_availability").on("change", function () {
        var _this = $(this);
        var ticket_count_div = $("#etn_avaiilable_tickets");
        var actual_ticket_count = ticket_count_div.val();
        var unlimited_ticket_count = 999999999;
        if (_this.prop('checked')) {
            ticket_count_div.val(actual_ticket_count);
        } else {
            ticket_count_div.val(unlimited_ticket_count);
        }
    });
    $("#etn_ticket_availability").trigger("change");


    $("#attendee_registration").on("change", function () {
        var _this = $(this);
        var attendeeConditionalInputField = _this.parents(".etn-label-item").nextAll(':lt(3)');
        if (_this.prop('checked')) {
            attendeeConditionalInputField.slideDown();
        } else {
            //hide all conditional divs
            attendeeConditionalInputField.slideUp();

            //update input values
            $("#reg_require_phone").prop("checked", false);
            $("#reg_require_email").prop("checked", false);
        }
    });
    $("#attendee_registration").trigger("change");

    // Zoom password field length validation
    var zoom_password = $("#zoom_password");
    // if the id found , trigger the action
    if (zoom_password.length > 0) {
        zoom_password.prop('maxlength', 10)
    }

    //   custom tabs
    $(document).on('click', '.etn-tab-a', function (event) {
        event.preventDefault();

        $(this).parents(".schedule-tab-wrapper").find(".etn-tab").removeClass('tab-active');
        $(this).parents(".schedule-tab-wrapper").find(".etn-tab[data-id='" + $(this).attr('data-id') + "']").addClass("tab-active");
        $(this).parents(".schedule-tab-wrapper").find(".etn-tab-a").removeClass('etn-active');
        $(this).parent().find(".etn-tab-a").addClass('etn-active');
    });


});

//   copy text
function copyTextData(FIledid) {
    var FIledidData = document.getElementById(FIledid);
    if (FIledidData) {
        FIledidData.select();
        document.execCommand("copy");
    }
}

function block_show_hide(trigger, selector) {
    jQuery(trigger).on('change', function () {
        if (jQuery(trigger).prop('checked')) {
            jQuery(selector).fadeIn('slow');
        } else {
            jQuery(selector).fadeOut('slow');
        }
    })
}

function etn_remove_block(remove_block_object) {
    jQuery(remove_block_object.parent_block).on('click', remove_block_object.remove_button, function (e) {
        e.preventDefault();
        jQuery(this).parent(remove_block_object.removing_block).remove();
    });
}