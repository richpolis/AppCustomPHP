$(document).ready(function(){
  $('p.cta-button a')
    .css({  'backgroundPosition': '0 0' })
    .hover(
      function(){
        $(this)
          .stop()
          .animate({
            'opacity': 0
          }, 650);
      },
      function(){
        $(this)
          .stop()
          .animate({
            'opacity': 1
          }, 650);
      }
    );
	
	$('p.cta-button2 a')
    .css({  'backgroundPosition': '0 0' })
    .hover(
      function(){
        $(this)
          .stop()
          .animate({
            'opacity': 0
          }, 650);
      },
      function(){
        $(this)
          .stop()
          .animate({
            'opacity': 1
          }, 650);
      }
    );
});