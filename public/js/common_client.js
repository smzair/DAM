

console.log('Flipkart Editing Panel | All Right Reserved by ODN Digital Services');


$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $(".profile-info").on('click', function () {
        $(this).parent('.user-photo').toggleClass('dropdown-open');
    });


});


function show(){
    $('.loader-ajax').removeClass('.d-none');
    $('.loader-ajax').addClass('.d-block');
}

function hide() {
    $('.loader-ajax').removeClass('.d-block');
      $('.loader-ajax').addClass('.d-none');
}
