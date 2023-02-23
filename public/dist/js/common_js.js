console.log('hello world');

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    // First 
    var qty1 = 4567;

    setInterval(function(){
        odometer1.innerHTML = qty1++;
    }, 2000);

    // Second
    var qty2 = 1297;

    setInterval(function(){
        odometer2.innerHTML = qty2++;
    }, 2000);

    // Third
    var qty3 = 2367;

    setInterval(function(){
        odometer3.innerHTML = qty3++;
    }, 2000);

    // Fourth
    var qty4 = 5267;

    setInterval(function(){
        odometer4.innerHTML = qty4++;
    }, 2000);

    // Fifth
    var qty5 = 8267;

    setInterval(function(){
        odometer5.innerHTML = qty5++;
    }, 2000);

    var notiFy = $('.custom-notification-alert');

    setTimeout(function(){
        notiFy.css("opacity", "1");
        notiFy.css("visibility", "visible");
    }, 4000);

    setTimeout(function(){
        notiFy.css("opacity", "0");
        notiFy.css("visibility", "hidden");
    }, 8000);


});