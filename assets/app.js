$( document ).ready(function() { // Handler for .ready() called.
  // sebagai action ketika row diklik
  $('.header1').click(function(){
       $(this).toggleClass('expand').nextUntil('tr.header1').slideToggle(100);
  });

  $('.header1').click();
});
