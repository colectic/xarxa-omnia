$(document).ready(function(){
  $("a.target_blank").click(function(){
    window.open(this.href);
    return false;
  });
});
