jQuery(function($){
  //画面サイズに合わせてheightを指定
  $(document).ready(function () {
    hsize = $(window).height();
    $("section").css("height", hsize + "px");
  });
  $(window).resize(function () {
    hsize = $(window).height();
    $("section").css("height", hsize + "px");
  });
});
