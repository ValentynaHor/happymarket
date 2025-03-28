jQuery().ready(function(){

  var $href1, flag1;
  $href1 = void 0;
  flag1 = false;

  jQuery('div.popup-link-hover').mouseenter(function() {
    var el;
    el = jQuery(this);
    $href1 = el.attr('data-selector');
    flag1 = true;
    jQuery($href1).stop().css({
      'visibility': 'visible',
      'z-index': 10
    }).animate({
      'opacity': 1
    }, 300);
  });

  jQuery('div.popup-categories-wrap, div.wrap-hover').mouseleave(function() {
    flag1 = false;
    jQuery($href1).css({
      'z-index': 0
    });
    setTimeout((function() {
      if (!flag1) {
        jQuery($href1).stop().animate({
          'opacity': 0
        }, 300, function() {
          jQuery($href1).css({
            'visibility': 'hidden',
            'z-index': -10
          });
        });
      }
    }), 10);
  });
});