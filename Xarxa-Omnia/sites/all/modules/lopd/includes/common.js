$(document).ready(function(){
  $('a#termsAndConditionsLink').click(function() {
    if ($('div#termsAndConditionsText').css('display') == 'none') {
      $('div#termsAndConditionsText').slideDown();
    } else {
      $('div#termsAndConditionsText').slideUp();
    }
  });
});
