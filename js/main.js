var $ = jQuery;

//nav
$('#nav-toggle').on('click',function(){
	$('header').toggleClass('header-active');
});
$('.nav-close').on('click',function(){
	$('header').removeClass('header-active');
});

$('.menu-item__parent').each(function(){
  let btn = $(this).find('.menu-item__icon');
  let btnLink = btn.prev();
  let subNav = $(this).find('.sub-menu');
  btn.on('click',function(e){
    if($(window).width()<992){
      e.preventDefault();
      subNav.slideToggle();
    }
  });
  btnLink.on('click',function(e){
    if($(window).width()<992){
      e.preventDefault();
      subNav.slideToggle();
    }
  });
})

//header white
if($(".header__white").length){
  $(function() {
    $(window).on("scroll", function() {
        if($(window).scrollTop() > 50) {
            $("#header").addClass("scrolled");
        } else {
            //remove the background property so it comes transparent again (defined in your css)
          $("#header").removeClass("scrolled");
        }
    });
  });
}


//lazy loading
function lazyInit(){
    $('.lazy-img').Lazy({
        afterLoad: function(element){
            imagesLoaded(element,function(){
                element.parent().addClass('loaded');
            });
        }
    });
}
lazyInit();
//smooth scroll to anchor
$(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
});

//animations

//appearence animation on scroll
$('.appear').each(function() {
    let el = $(this);
    let inview = el.waypoint(function(direction) {
        el.addClass('visible');
    }, {
        offset: '95%'
    });
});
