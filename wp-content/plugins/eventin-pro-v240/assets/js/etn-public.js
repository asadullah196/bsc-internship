'use strict';
jQuery(document).ready(function ($) {

    /*================================
        speaker slider
    ===================================*/
    var $scope = $(".speaker_shortcode_slider");
    speaker_sliders_pro($, $scope);

    /*================================
        speaker slider
    ===================================*/
    var $scope = $(".event-slider-shortcode");
    event_sliders_pro($, $scope);


    /*================================
     Event accordion
    ===================================*/

    $(".etn-content-item > .etn-accordion-heading").on("click", function (e) {
        e.preventDefault();
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).siblings(".etn-acccordion-contents").slideUp(200);
            $(".etn-content-item > .etn-accordion-heading i")
                .removeClass("fa-minus")
                .addClass("fa-plus");
        } else {
            $(".etn-content-item > .etn-accordion-heading i")
                .removeClass("fa-minus")
                .addClass("fa-plus");
            $(this).find("i").removeClass("fa-plus").addClass("fa-minus");
            $(".etn-content-item > .etn-accordion-heading").removeClass("active");
            $(this).addClass("active");
            $(".etn-acccordion-contents").slideUp(200);
            $(this).siblings(".etn-acccordion-contents").slideDown(200);
        }
    });

    /*================================
      // countdown 
    ===================================*/
    var main_block = $(".count_down_block")
    if ( main_block.length > 0 ) {
        count_down($, main_block);
    }

});

// countdown function
function count_down($, $scope) {
    var $container = $scope.find('.etn-event-countdown-wrap');
    var date_texts   = $container.data('date-texts');

    var day_text = date_texts.day;
    var hour_text = date_texts.hr;
    var min_text = date_texts.min;
    var second_text = date_texts.sec;
    var days_text = date_texts.days;
    var hours_text =  date_texts.hrs;
    var mins_text = date_texts.mins;
    var seconds_text = date_texts.secs;

    if ($container.length > 0) {
        var targetDate = $container.data('start-date');
        var targetNode = $scope.find(".etn-countdown-parent");
        $(targetNode).countdown({
            date: targetDate,
            day: day_text,
            days: days_text,
            hour: hour_text,
            hours: hours_text,
            minute: min_text,
            minutes: mins_text,
            second: second_text,
            seconds: seconds_text,
            hideOnComplete: true
        }, function (container) {
            $scope.html("Expired");
        });
    }
}

// print order details
function etn_pro_pirnt_content_area(divContents) {
    "use strict";
    var mywindow = window.open('', 'PRINT', 'height=400,width=800');
    mywindow.document.write(
        '<style type="text/css">' +
        '.woocommerce-column--1, .woocommerce-column--2{display:inline-block; float: none; width: 300px; vertical-align: top;}  .woocommerce-table tr th{text-align:left; width: 300px; }' +
        '</style>');

    var contentToPrint = document.getElementsByClassName(divContents)[0].innerHTML;
    contentToPrint = contentToPrint.split("<div class=\"extra-buttons\">")[0];
    // console.log(contentToPrint);
    mywindow.document.write('</head><body >');
    mywindow.document.write(contentToPrint);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/
    mywindow.print();
    return true;
}

//download pdf
function etn_pro_download_pdf() {
    var contentToPrint = document.getElementsByClassName("woocommerce-order")[0].innerHTML;
    var source = contentToPrint.split("<div class=\"extra-buttons\">")[0];
    var filename = "invoice";
    jQuery('.woocommerce-order').html(source);
    var divToPrint = jQuery('.woocommerce-order')[0];

    // create custom canvas for a better resolution
    var w = 1000;
    var h = 1000;
    var canvas = document.createElement('canvas');
    canvas.width = w * 5;
    canvas.height = h * 5;
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
    var context = canvas.getContext('2d');
    context.scale(5, 5);

    html2canvas(divToPrint, {
        scale: 4,
        dpi: 288,
        onrendered: function (canvas) {
            var data = canvas.toDataURL('image/png', 1);
            var docDefinition = {
                content: [{
                    image: data,
                    width: 500
                }]
            };
            pdfMake.createPdf(docDefinition).download(filename + ".pdf");
        }
    });
    window.setTimeout(function () {
        location.reload()
    }, 500);

}

// speaker sliders pro
function speaker_sliders_pro($, $scope) {
    var $container = $scope.find('.etn-speaker-slider');
    var count = $container.data('count');
    var space = $container.data('space');

    if ($container.length > 0) {
        $($container).each(function (index, element) {
            var mySwiper = new Swiper(element, {
                slidesPerView: count,
                spaceBetween: space,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },

                paginationClickable: true,
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                    },
                    600: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: count,
                    }
                }
            })
        });
    }
}
// Event sliders pro
function event_sliders_pro($, $scope) {
    var $container = $scope.find('.etn-event-slider');
    var count = $container.data('count');

    if ($container.length > 0) {
        $($container).each(function (index, element) {
            var mySwiper = new Swiper(element, {
                slidesPerView: count,
                spaceBetween: 30,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                paginationClickable: true,
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                    },
                    600: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: count,
                    }
                }
            })
        });
    }
}