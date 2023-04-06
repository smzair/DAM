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

$(document).ready(function() {
    $(".bell-drop").click(function() {
        let parentClasses = $('.notification-bell').attr("class");
        classArray = parentClasses.split(' ')
        if (classArray.includes("notification-open")) {
            $('.notification-bell').removeClass('notification-open')
        } else {
            $('.notification-bell').addClass('notification-open')
        }
    });
});

$(document).ready(function() {
    $('.close-link-notify').click(function() {
        var notificationId = $(this).find('input[name="notificationId"]').val();
        let n_count = +$('#notify-count').text();
        $.ajax({
            url: "set-notification-seen",
            type: "get",
            dataType: 'json',
            data: {
                notificationId: notificationId,
            },
            success: function(res) {
                console.log('res', res)
            },
            error: function (data) {
                console.log("error");
                console.log(data);
            }
        });

        $(this).closest('.notification-item').addClass('d-none');
        $(this).closest('.notification-item').remove();

        if(n_count == 1){
            $('#notify-count').text(0)
            let newElement = `<div><p>No unseen new notification.</p></div>`
            $('.notification-body').append(newElement);
            console.log('newElement', newElement)
        }else{
            $('#notify-count').text(n_count-1)
        }
        console.log("notificationId => ",notificationId);
    });
});

