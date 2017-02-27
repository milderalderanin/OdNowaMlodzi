$(window).load(function() {
	$(".loader").fadeOut("slow");
	$('#about').addClass('text-1-loaded').removeClass('text-1');
});

$("#slideShow").carousel({
		interval: 6000,
		cycle: true
});

$(document).ready(function() {
    $(window).scroll( function(){
        $('.info').each( function(i){
            var bottom_of_object = $(this).offset().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height();

            if( bottom_of_window > bottom_of_object ){            
                $(this).animate({'opacity':'1'},500);                  
            }           
        });    
    });    
});