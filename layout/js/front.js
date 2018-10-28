
$('.live-name').keyup(function(){
    $('.live-preview .caption h3').text($(this).val());
});

$('.live-description').keyup(function(){
    $('.live-preview .caption p').text($(this).val());
});

$('.live-price').keyup(function(){
    $('.live-preview .price-tag').text($(this).val());
});

$(function (){
    
$('.login-page h1 span').click(function (){
   $(this).addClass('selected').siblings().removeClass('selected'); 
   $('.login-page form').hide();
   $('.' + $(this).data('class')).fadeIn(100);    
});
    
});