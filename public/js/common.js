$(function () {
    $("#resizable").resizable();
});

function validateEmail(email) {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test(email) == false) {
        return false;
    }
    return true;
}

function isAlphaNumeric(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode >= 48 && charCode <= 57) || ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 8 || charCode == 32)) {
        return true;
    }
    return false;
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function isAlphabet(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 8 || charCode == 32) {
        return true;
    }
    return false;
}

function showLoader() {
    $('.loader-ajax').fadeIn('slow');
}

function hideLoader() {
    $('.loader-ajax').fadeOut('slow');
}

function tooltip() {
    $('[data-toggle="tooltip"]').tooltip();
}

function select2() {
    if ($('.select2').length) {
        $('.select2').each(function () {
            var placeholder = "Please select...";
            var definePlaceholder = $(this).data('placeholder');
            if (typeof (definePlaceholder) != 'undefined') {
                placeholder = definePlaceholder;
            }
            $(this).select2({
                placeholder: placeholder
            });
        });
    }
}


function makeDataTable() {
    $('.data-table').each(function () {
        var order = ["0", "desc"];
        var sequence = $(this).data('sequence');
        if (typeof (sequence) != 'undefined') {
            sequence = sequence.split(':');
            order = sequence;
        }
        $(this).DataTable({
            order: [order],
            responsive: true
        });
    });
}


function getServiceList(obj) {
    var c_short = $(obj).find('option:selected').data('c_short');
    $('#c_short').val(c_short);
    showLoader();
    $.ajax({
        url: "/get-service/",
        method: 'GET',
        dataType: 'html',
        data: {},
        success: function (htmlData) {
            $('#service_list_html').html(htmlData);
            hideLoader();
            select2();
        }
    });
}


function showModal() {
    $('#myModal').modal();
}

function removeWrcRow(lot_id) {
    $('#wrcNum_' + lot_id).remove();
}

function allwrc(obj) {
    var lot_id = $(obj).data('id');
    showLoader();
    $.ajax({
        url: "/get-wrc-list",
        method: 'GET',
        dataType: "html",
        data: {lot_id: lot_id},
        success: function (htmlData) {
            $('#wrcNum_' + lot_id).remove();
            $('#lot_row' + lot_id).after(htmlData);
            $('#wrcNum_' + lot_id).slideDown('slow');
            makeDataTable();
            hideLoader();
        }
    });
}

function wrcstatus(obj) {
    var wrc_id = $(obj).data('wrcid');
    $.ajax({
        url: "/wrc-status",
        method: 'GET',
        dataType: "html",
        data: {wrc_id: wrc_id},
        success: function (htmlData) {
            $('#dynamic_timline').html(htmlData);
            $('#wrcStatus').modal();

        }

    });

}

function removeSkuRow(wrc_id) {
    $('#dynamic_sku_' + wrc_id).remove();
}
function allsku(obj) {
    var wrc_id = $(obj).data('id');
    showLoader();
    $.ajax({
        url: "/get-sku-list",
        method: 'GET',
        dataType: "html",
        data: {wrc_id: wrc_id},
        success: function (htmlData) {
            $('#dynamic_sku_' + wrc_id).remove();
            $('#wrc_row_' + wrc_id).after(htmlData);
            $('#dynamic_sku_' + wrc_id).slideDown('slow');
            hideLoader();
        }
    });
}


// $(window).on('load', function () {
//     setTimeout(function () {
//         $('.loader-ajax').fadeOut('slow', function () {
//         });
//     }, 300)
// });

$(function () {
    select2();
    tooltip();

    $(".brand").change(function () {
        var short_name = $(this).find('option:selected').data('short_name');
        $('#short_name').val(short_name);
        showLoader();
        $.ajax({
            url: "/get-user/",
            method: 'GET',
            dataType: 'html',
            data: {brand_id: $(this).val()},
            success: function (htmlData) {
                $('#company_list_html').html(htmlData);
                hideLoader();
                select2();
            }
        });
    });

    $('.swalDefaultSuccess').click(function () {
        Toast.fire({
            icon: 'success',
            title: 'Thank you for your support. Your Customer Id ' + $lotId
        });
    });

    $("#selectAll").click(function () {
        $(".check-ln, .allcheck").prop("checked", $(this).prop("checked"));
        togglePlanShootBtn();
    });

    $('.check-ln').click(function () {
        var index = $(this).data('index');
        var wrc_id = $(this).data('wrc_id');
        $('#sku_list_' + wrc_id + '_' + index).find('.allcheck').prop("checked", $(this).prop("checked"));
        togglePlanShootBtn();
    });

    $('.allcheck').click(function () {
        var wrc_id = $(this).data('wrc_id');
        var checked_count = 0;
        $('#checkall' + wrc_id).prop('checked', false);
        $(this).parents('tbody').find('.allcheck').each(function () {
            if ($(this).prop('checked')) {
                $('.plan-shoot').addClass('checkshow');
                checked_count++;
            }
        });
        if (checked_count > 0) {
            $('#checkall' + wrc_id).prop('checked', 'checked');
        }
        togglePlanShootBtn();
    });

    $('#sku_images_form1').on('submit', (function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log("success");
                console.log(data);
            },
            error: function (data) {
                console.log("error");
                console.log(data);
            }
        });
    }));

});

function togglePlanShootBtn() {
    var checked_count = 0;
    $('.check-ln').each(function () {
        if ($(this).prop('checked')) {
            checked_count++;
        }
    });
    $('.plan-shoot').removeClass('checkshow');
    if (checked_count > 0) {
        $('.plan-shoot').addClass('checkshow');
    }
}

function showSelectedSkus() {
    var wrcs = [];
    $('.check-ln:checked').each(function () {
        wrcs.push($(this).data('wrc_name'));
    });

    var skus_id = [];
    var skus_code = [];
    $('.allcheck:checked').each(function () {
        skus_id.push($(this).data('sku_id'));
        skus_code.push($(this).data('sku_code'));
    });
    showLoader();
    $.ajax({
        url: "/plan-shoot-ajax",
        method: 'GET',
        dataType: "html",
        data: {wrcs: wrcs, skus_id: skus_id, skus_code: skus_code},
        success: function (htmlData) {
            $('#d-sku-plan').html(htmlData);
            select2();
            $('#shoot_plan_modal').modal();
            hideLoader();


        }

    });
}

function planShoot() {
    showLoader();
    $.ajax({
        url: "/save-shoot-plan",
        method: 'POST',
        dataType: "text",
        data: $('#day_shoot_form').serialize(),
        success: function (data) {
            $('#shoot_plan_modal').modal('hide');
            window.location.reload();
            hideLoader();

        }

    });
}

function skuList(obj) {
    showLoader();
    $.ajax({
        url: "/sku-list-content",
        method: 'GET',
        dataType: "html",
        data: {day_plan_id: $(obj).val()},
        success: function (htmlData) {
            $('#sku_list_content').html(htmlData);
            calculateNumbers();
            hideLoader();
            $('body').removeClass('lot-open').removeClass('wrc-open');
        }

    });
}

function calculateNumbers() {
    var lots = $('.lot-number').length;
    $('#lot_count').text(lots);
}


function saveComForm(resetStatus) {
    $.ajax({
        url: "/save-com",
        method: 'POST',
        dataType: "json",
        data: $('#comform').serialize(),
        success: function (data) {
            if (resetStatus == '1') {
                $('.reset').val('');
            } else {
              window.location.reload();
            }
        }
    });
}



$(".company").change(function () {
    var client_id = $(this).find('option:selected').data('client_id');
    $('#client_id').val(client_id);
    var user_id = $(this).val();
    $.ajax({
        url: "/get-brand",
        method: 'GET',
        dataType: "json",
        data: {user_id: user_id},
        success: function (data) {
            $('#brands').html(data.html);
        }
    });
});

function saveWrcForm(resetStatus) {
  
    $.ajax({
        url: "/save-wrc",
        method: 'POST',
        dataType: "text",
        data: $('#wrcform').serialize(),
        success: function (data) {
            if (resetStatus == '1')
            {
                $('.reset').val('');
                $('#msg').slideDown('slow');
                setTimeout(function () {
                    $('#msg').slideUp('slow');
                }, 6000);
            } else {
                location.reload();
            }

        }
    });
}


$("#wrc_com").change(function () {
    var client_id = $(this).find('option:selected').data('client_id');
    $('#client_id').val(client_id);
    var user_id = $(this).val();

    showLoader();


    $.ajax({
        url: "/get-brand",
        method: 'GET',
        dataType: "json",
        data: {user_id: user_id},
        success: function (data) {
            $('.brand').html(data.html);
            hideLoader();
        }
    });
});



$("#wrc_brands").change(function () {
    var brand_id = $(this).val();
    var user_id = $('#wrc_com').val();
    showLoader();
    $.ajax({
        url: "/get-wrc-lots",
        method: 'GET',
        dataType: "json",
        data: {user_id: user_id, brand_id: brand_id},
        success: function (data) {
            $('#wrc_lots').html(data.lots_html);
            $('#product_category').html(data.coms_html);
            hideLoder();
        }
    });
});

$("#product_category").change(function () {

    var brand_id = $('#wrc_brands').val();
    var user_id = $('#wrc_com').val();
    var lot_id = $('#wrc_lots').val();
    var com_id = $(this).val();
    showLoader();
    $.ajax({
        url: "/get-wrc-com",
        method: 'GET',
        dataType: "html",
        data: {user_id: user_id, brand_id: brand_id, lot_id: lot_id, com_id: com_id},
        success: function (htmlData) {
            $('#dwrc').html(htmlData);
            hideLoader();
        }
    });

    getSkuListHtml(lot_id, com_id);
});


$("#wrc_lots").change(function () {

    var brand_id = $('#wrc_brands').val();
    var user_id = $('#wrc_com').val();
    var lot_id = $(this).val();
    
    $.ajax({
        url: "/get-wrc-details",
        method: 'GET',
        dataType: "html",
        data: {user_id: user_id, brand_id: brand_id, lot_id: lot_id},
        success: function (htmlData) {
            select2();
            $('#Hwrc').html(htmlData);
         
        }
    });

    getSkuListHtml(lot_id, 0);

});

$("#upload_sku_form").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: "/upload-sku",
        type: 'POST',
        data: formData,
        success: function (data) {
            window.location.reload();
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


$("#brand_sku").change(function () {

    showLoader();
    $.ajax({
        url: "/get-company/" + $(this).val(),
        method: 'GET',
        success: function (data) {
            $('.com').html(data.html);
            hideLoader();
        }
    });
});


$(".com").change(function () {
    var user_id = $(this).val();
    var brand_id = $('#brand_sku').val();
    showLoader();
    $.ajax({
        url: "/get-sku-lots",
        method: 'GET',
        dataType: "json",
        data: {user_id: user_id, brand_id: brand_id},
        success: function (data) {
            $('.lots').html(data.html);
            hideLoader();
        }
    });
});


$(".lots").change(function () {
    var lot_id = $(this).val();
    showLoader();
    $.ajax({
        url: "/get-wrc",
        method: 'GET',
        dataType: "json",
        data: {lot_id: lot_id},
        success: function (data) {
            $('.wrc').html(data.html);
            hideLoader();
        }
    });
});
$(document).on('click', '[data-toggle="lightbox"]',
        function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

$('.fa-angle-down').click(function () {
    $(this).toggleClass('rotate');
});

function getPlanCount() {
    $.ajax({
        url: "/plancount",
        method: 'GET',
        dataType: "text",
        success: function (planCount) {
            $('#plan_count').text(planCount + ' WRC to Plan');
        }
    });


}

function getAllocationCount() {
    $.ajax({
        url: "/allocationcount",
        method: 'GET',
        dataType: "text",
        success: function (allocationCount) {
            $('#allocation_count').text(allocationCount + ' LOT to Allocate');
        }
    });
}

$(function () {
    // ID selector on Master Checkbox
    // ID selector on Items Container
    var listCheckItems = $(".checkallsku .allcheck");

    // Click Event on Master Check
    $(".checkall").on("change", function () {
        var lot_id = $(this).data('lot_id');
        var isMasterChecked = $(this).is(":checked");
        if (isMasterChecked) {
            $('tr#' + lot_id).find('.check-wrc').prop('checked', true);
            $('tr#' + lot_id).find('.check-sku').prop('checked', true);
        } else {
            $('tr#' + lot_id).find('.check-wrc').prop('checked', false);
            $('tr#' + lot_id).find('.check-sku').prop('checked', false);
        }
        togglePlanShootBtn();
    });

    getPlanCount();
    getAllocationCount();

    makeDataTable();

    $(".check-wrc").on("change", function () {
        var lot_id = $(this).data('lot_id');
        var wrc_id = $(this).data('wrc_id');
        if ($(this).is(":checked")) {
            $('tr#' + wrc_id).find('.check-sku').prop('checked', true);
        } else {
            $('tr#' + wrc_id).find('.check-sku').prop('checked', false);
        }

        var checkCount = 0;
        $(".check-wrc").each(function () {
            if ($(this).is(":checked")) {
                checkCount++;
            }
        });

        $('#check_' + lot_id).prop('checked', false);
        if (checkCount > 0) {
            $('#check_' + lot_id).prop('checked', true);
        }
        togglePlanShootBtn();
    });

    $(".check-sku").on("change", function () {
        var lot_id = $(this).data('lot_id');
        var wrc_id = $(this).data('wrc_id');

        var checkCount = 0;
        $(".check-sku").each(function () {
            if ($(this).is(":checked")) {
                checkCount++;
            }
        });

        $('#check_' + lot_id).prop('checked', false);
        $('tr#' + lot_id).find('.check-wrc').prop('checked', false);
        if (checkCount > 0) {
            $('#check_' + lot_id).prop('checked', true);
            $('tr#' + lot_id).find('.check-wrc').prop('checked', true);
        }
        togglePlanShootBtn();
    });
});

$("#lotid").change(function () {
    var lotid = $(this).val();
    showLoader();
    $.ajax({
        url: "/find-wrc",
        method: 'GET',
        dataType: "json",
        data: {lot_id: lotid},
        success: function (data) {
            $('#wrcid').html(data.wrc_html);
            hideLoader();
        }
    });
});

$(".wrcid").change(function () {
    var wrcid = $(this).val();
    showLoader();
    $.ajax({
        url: "/find-com",
        method: 'GET',
        dataType: "json",
        data: {wrc_id: wrcid},
        success: function (data) {
            $('#adaptations').html(data.com_html);
            hideLoader();
        }
    });
});

$(document).ready(function () {
    var body_class = $.cookie('body_class');
    if (body_class) {
        $('body').attr('class', body_class);
    }
    $(".toggle-inner").click(function () {
        $("body").toggleClass("light-dsh-mode");
        $.cookie('body_class', $('body').attr('class'));
    });
});

$(document).on('click', '.cpy-clipboard', function () {
    var skuText = $(this).prev('#skuNum').text().trim();
    navigator.clipboard.writeText(skuText).then(() => {
        alert("Text copied to clipboard");
    })
            .catch((err) => {
                alert("Error in copying text: ", err);
            });
});
// Theme mode ends

// Search Functionality Start

$(function () {

    // the input field
    var $input = $(".hdr-search"),
            // clear button
            $clearBtn = $("button[data-search='clear']"),
            // prev button
            $prevBtn = $("button[data-search='prev']"),
            // next button
            $nextBtn = $("button[data-search='next']"),
            // the context where to search
            $content = $("#main-bdy"),
            // jQuery object to save <mark> elements
            $results,
            // the class that will be appended to the current
            // focused element
            currentClass = "current",
            // top offset for the jump (the search bar)
            offsetTop = 50,
            // the current index of the focused element
            currentIndex = 0;

    /**
     * Jumps to the element matching the currentIndex
     */
    function jumpTo() {
        if ($results.length) {
            var position,
                    $current = $results.eq(currentIndex);
            $results.removeClass(currentClass);
            if ($current.length) {
                $current.addClass(currentClass);
                position = $current.offset().top - offsetTop;
                window.scrollTo(0, position);
            }
        }
    }

    /**
     * Searches for the entered keyword in the
     * specified context on input
     */
    $input.on("input", function () {
        var searchVal = this.value;
        $content.unmark({
            done: function () {
                $content.mark(searchVal, {
                    separateWordSearch: true,
                    done: function () {
                        $results = $content.find("mark");
                        currentIndex = 0;
                        jumpTo();
                    }
                });
            }
        });
    });

    /**
     * Clears the search
     */
    $clearBtn.on("click", function () {
        $content.unmark();
        $input.val("").focus();
    });

    /**
     * Next and previous search jump to
     */
    $nextBtn.add($prevBtn).on("click", function () {
        if ($results.length) {
            currentIndex += $(this).is($prevBtn) ? -1 : 1;
            if (currentIndex < 0) {
                currentIndex = $results.length - 1;
            }
            if (currentIndex > $results.length - 1) {
                currentIndex = 0;
            }
            jumpTo();
        }
    });
});

// Search Functionality Ended


$(window).scroll(function () {
    var distanceY = window.pageYOffset || document.documentElement.scrollTop,
            shrinkOn = 300,
            body = document.querySelector("body");
    if ($(this).scrollTop() > 150) {
        $('body').addClass("scroll-header");
    } else {
        $('body').removeClass("scroll-header");
    }
});

$("#back-to-top").hide();

$(window).scroll(function () {
    if ($(window).scrollTop() > 100) {
        $("#back-to-top").fadeIn(500);
    } else
    {
        $("#back-to-top").fadeOut(500);
    }
});
//back to top
$("#back-to-top").click(function () {
    $('body,html').animate({scrollTop: 0}, 500);
    return false;
});

$(document).on('click', '#search-toggle-btt', function () {
    $(this).next('.hdr-search-wrapper').toggleClass('open-search-ss');
    $('.infor-content').removeClass('open-infor');
    $('.information-pp-btn').removeClass('cls-infor');
});

// Sidebar links active js

$(document).ready(function () {
    $('.nav-sidebar .nav-item > .nav-link').each(function (index) {
        if (this.href.trim() == window.location) {
            $(this).parents('.nav-item').siblings().removeClass('menu-open');
            $(this).parents('.nav-item').addClass('menu-open');
        }
    });

    $('.nav-sidebar .nav-item > .nav-treeview > li.nav-item > a.nav-link').each(function (index) {
        if (this.href.trim() == window.location) {
            $(this).parent('.nav-item').siblings().removeClass('menu-child-open');
            $(this).parent('.nav-item').addClass('menu-child-open');
        }
    });

    $('.nav-sidebar > .nav-item > .nav-link').on("click", function () {
        $(this).parent('.nav-item').siblings().removeClass('menu-open');
        $(this).parent('.nav-item').siblings().children('.nav-treeview').slideUp(250);
    });
});

function getSkuListHtml(lot_id, com_id) {
    $.ajax({
        url: "/get-wrc-Csku",
        method: 'GET',
        dataType: "html",
        data: {lot_id: lot_id, com_id: com_id},
        success: function (htmlData) {
            $('#Allsku').html(htmlData);
        }
    });
}
// Filter Dropdown Js

$(document).on('click', '.filter-link', function (e) {
    e.preventDefault();
    $(this).parents('.custom-filter-drop').toggleClass('filter-open');
});

$(document).on('click', '.filter-label', function () {
    var filterVal = $(this).children('.filter-text').text().trim();
    $(this).parents('.filter-dropdown-list').prev('.filter-link').find('.filter-active-text').text(filterVal);
    $(this).parents('.custom-filter-drop').removeClass('filter-open');
    var filterBackground = $(this).children('.filter-list-badge').css('background-color');
    $(this).parents('.filter-dropdown-list').prev('.filter-link').find('.filter-active-badge').css({'display': 'inline-block', 'background-color': filterBackground});
});


// End of filter dropdown js




