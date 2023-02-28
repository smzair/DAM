$(document).ready(function() {

  // $(".gypq-form").validate();

  $('.formselect').niceSelect();


  // Scroll Header

  $(window).scroll(function () {
    body = document.querySelector("body");
    var headerHeight = $('.custom-header').outerHeight();
    if ($(this).scrollTop() > headerHeight) {
      $('body').addClass("scroll-header");
    } else {
      $('body').removeClass("scroll-header");
      $('.user-actions').slideUp(250);
    }
  });

  // Notification dropdown js 

  $('.bell-drop').on('click', function() {
    $(this).parent('.notification-bell').toggleClass('notification-open');
    $('.navbar-search-block').slideUp(250);
  });

  $('.close-link-notify').on('click', function() {
    $(this).parents('.notification-item').css('display', 'none');
  });

  $('.dash-mobile-trigger').on('click', function() {
    $('body').toggleClass('sidebar-open');
  });

  $('.sidebar-close').on('click', function() {
    $('body').removeClass('sidebar-open');
  });

  $('.mobile-search-toggle').on('click', function() {
    $('.navbar-search-block').slideToggle(250);
    $('.notification-bell').removeClass('notification-open');
    var headerHeight = $('.custom-dashboard-header').outerHeight();
    $('.navbar-search-block').css('top', headerHeight);
  });

  // Order Tabber

  $('ul.tabs li').click(function(){
    var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});


  // Pagination JS

  var paginationBlock = $('.dash-pagination'),
  total = $('.total-pg', paginationBlock).attr('data-total'),
  current = $('.current-pg', paginationBlock),
  nodata = current.attr('data-current');

  $('.next-page-btn', paginationBlock).on('click', function(e){
    e.preventDefault();
    $('.prev-page-btn').removeClass('deactive');
    (nodata + 1 >= total) ? ( nodata = total, $(this).addClass('deactive')) : nodata++;
    current.attr('data-current', nodata).html(nodata);
  });

  $('.prev-page-btn', paginationBlock).on('click', function(e){
    e.preventDefault();
    $('.next-page-btn').removeClass('deactive');
    (nodata - 1 <= 1) ? ( nodata = 1, $(this).addClass('deactive')) : nodata--;
    current.attr('data-current', nodata).html(nodata);
  });

  // Toasts Alert 

  $('.alert-toast').on('click', function() {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function(toastEl) {
      return new bootstrap.Toast(toastEl);
    });
    toastList.forEach(toast => toast.show());
  });


  $('#clearMarklink').on('click', function() {
    $('.notification-listing-group').remove();
    $('.no-notification-listing').removeClass('d-none');
  });

  var headerpadHeight = $('.custom-dashboard-header').outerHeight();
 
  $('.custom-dashboard-content').css('padding-top', headerpadHeight);
  $('.toast').css('top', headerpadHeight);

   // OTP Verification Js

   function processInput(holder){
    var elements = holder.children(), //taking the "kids" of the parent
        str = ""; //unnecesary || added for some future mods
    
    elements.each(function(e){ //iterates through each element
      var val = $(this).val().replace(/\D/,""), //taking the value and parsing it. Returns string without changing the value.
          focused = $(this).is(":focus"), //checks if the current element in the iteration is focused
          parseGate = false;
      
      val.length==1?parseGate=false:parseGate=true; 
        /*a fix that doesn't allow the cursor to jump 
        to another field even if input was parsed 
        and nothing was added to the input*/
      
      $(this).val(val); //applying parsed value.
      
      if(parseGate&&val.length>1){ //Takes you to another input
        var	exist = elements[e+1]?true:false; //checks if there is input ahead
        exist&&val[1]?( //if so then
          elements[e+1].disabled=false,
          elements[e+1].value=val[1], //sends the last character to the next input
          elements[e].value=val[0], //clears the last character of this input
          elements[e+1].focus() //sends the focus to the next input
        ):void 0;
      } else if(parseGate&&focused&&val.length==0){ //if the input was REMOVING the character, then
        var exist = elements[e-1]?true:false; //checks if there is an input before
        if(exist) elements[e-1].focus(); //sends the focus back to the previous input
      }
      
      val==""?str+=" ":str+=val;
    });
  }
  
  $(".inputs").on('input', function(){processInput($(this))}); //still wonder how it worked out. But we are adding input listener to the parent... (omg, jquery is so smart...);
  
  $(".inputs").on('click', function(e) { //making so that if human focuses on the wrong input (not first) it will move the focus to a first empty one.
    var els = $(this).children(),
        str = "";
    els.each(function(e){
      var focus = $(this).is(":focus");
      $this = $(this);
      while($this.prev().val()==""){
        $this.prev().focus();
        $this = $this.prev();
      }
    })
  });

  // End of OTP Verification Js


  // Show Password

  $('body').on('click', '.pswd-eye-icon:not(.eye-active)', function () {
      $(this).addClass('eye-active');
      $(this).parents('.password-form-group').find('.formInput').attr('type', 'text');
  });

  $('body').on('click', '.pswd-eye-icon.eye-active', function () {
      $(this).removeClass('eye-active');
      $(this).parents('.password-form-group').find('.formInput').attr('type', 'password');
  });

  // Verification success msg js

  $(".verify-btn").on('click', function () {
    $(this).parents('.custom-modal-form-wrapper').slideUp(250);
    $(this).parents('.custom-modal-form-wrapper').siblings('.custom-verification-success-msg').slideDown(250);
    $(this).parents('.custom-modal-form-wrapper').siblings('.custom-verification-success-msg').find('.check-icon').hide();
    setTimeout(function () {
      $(".check-icon").show();
    }, 200);
  });
  

  // Review Rate Js

  $('.rate-submit-btn').on('click', function(){
    $('.review-rating-card').hide();
    $('.loader').show();
    setTimeout(function () {
      $(".loader").hide();
      $(".review-submitted-wrapper").show();
    }, 1500);
  });


});
