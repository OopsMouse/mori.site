jQuery(function($){
  //画面サイズに合わせてheightを指定,CSS書き換えます
  $(document).ready(function () {
    hsize = $(window).height();
    $("section").css("height", hsize + "px");
  });
  $(window).resize(function () {
    hsize = $(window).height();
    $("section").css("height", hsize + "px");
  });
  // #で始まるアンカーをクリックした場合の処理
  jQuery('a[href^=#]').click(function() {
    var speed = 400; // ミリ秒
    var href= jQuery(this).attr("href");
    var target = jQuery(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top;
    jQuery('body,html').animate({scrollTop:position}, speed, 'swing');
    return false;
  });
});
